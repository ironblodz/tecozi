<?php

namespace App\Http\Controllers\Portfolio;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PortfolioCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    //
    public function validateData($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'img.image' => 'A imagem de capa deve ser um arquivo de imagem.',
            'gallery.*.image' => 'Cada arquivo na galeria deve ser uma imagem.',
        ]);

    }

    public function index(Request $request)
    {
        $query = PortfolioCategory::latest();

        // Aplicar filtro de 'visible_on_portfolio' se necessário
        if ($request->input('visible_on_portfolio', false)) {
            $query->where('visible_on_portfolio', true);
        }

        // Aplicar filtro de 'visible_in_materials' se necessário
        if ($request->input('visible_in_materials', false)) {
            $query->where('visible_in_materials', true);
        }

        $categories = $query->get();

        if ($request->wantsJson()) {
            return response()->json($categories);
        }

        return Inertia::render('Backoffice/Portfolio/Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function getVisibleInMaterialsCategories(Request $request)
    {
        $categories = PortfolioCategory::where('visible_in_materials', true)->get();

        return response()->json($categories);
    }



    public function toggleArchive(Request $request, PortfolioCategory $category)
    {
        $category->archived = !$category->archived;
        $category->save();

        return response()->json(['message' => 'Categoria atualizada com sucesso.']);
    }

    public function toggleVisibility(Request $request, PortfolioCategory $category)
    {
        $category->visible_in_materials = !$category->visible_in_materials;
        $category->save();

        return response()->json(['message' => 'Visibilidade da categoria atualizada com sucesso.']);
    }

    public function toggleVisibilityOnPortfolio(Request $request, PortfolioCategory $category)
    {
        $category->visible_on_portfolio = !$category->visible_on_portfolio;
        $category->save();

        return response()->json(['message' => 'Visibilidade no portfólio atualizada com sucesso.']);
    }




    public function getCategories(Request $request)
    {
        $limit = 5;

        $query = PortfolioCategory::latest();

        // Se um parâmetro 'active' for passado, filtra categorias ativas
        if ($request->has('active') && $request->active) {
            $query->where('archived', false);
        }

        $categories = $query->take($limit)->get();

        // Retorna os dados como JSON
        if ($categories) {
            return response()->json($categories);
        }

        return response()->json(['error' => 'Algo deu errado!'], 500);
    }




    public function edit($id)
    {
        $category = PortfolioCategory::with('photos')->findOrFail($id);

        // Garante que `gallery` sempre seja uma coleção válida
        $category->gallery = $category->gallery ?? collect([]);

        return inertia('Backoffice/Portfolio/Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        return Inertia::render('Backoffice/Portfolio/Categories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);

        try {
            // Salvar imagem de capa
            $imagePath = null;
            if ($request->hasFile('img')) {
                $imagePath = $request->file('img')->store('categories', 'public');
            }

            // Criar a categoria
            $category = PortfolioCategory::create([
                'name' => $request->name,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'img' => $imagePath,
            ]);

            // Salvar imagens da galeria
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $galleryImage) {
                    $galleryPath = $galleryImage->store('categories/gallery', 'public');
                    $category->photos()->create(['photo_path' => $galleryPath]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Categoria criada com sucesso!']);
        } catch (\Exception $e) {
            \Log::error('Erro ao criar categoria: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao criar categoria!'], 500);
        }
    }

    public function update(Request $request, PortfolioCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);

        try {
            // Atualizar imagem de capa, se houver
            if ($request->hasFile('img')) {
                if ($category->img) {
                    Storage::disk('public')->delete($category->img);
                }
                $imagePath = $request->file('img')->store('categories', 'public');
                $category->img = $imagePath;
            }

            $category->update($request->only(['name', 'subtitle', 'description']));

            // Adicionar novas imagens à galeria
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $galleryImage) {
                    $galleryPath = $galleryImage->store('categories/gallery', 'public');
                    $category->photos()->create(['photo_path' => $galleryPath]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Categoria atualizada com sucesso!']);
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar categoria: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar categoria!'], 500);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $category = PortfolioCategory::with('photos')->findOrFail($request->id);

            // Excluir imagens da galeria
            foreach ($category->photos as $photo) {
                Storage::disk('public')->delete($photo->photo_path);
                $photo->delete();
            }

            // Excluir imagem de capa
            if ($category->img) {
                Storage::disk('public')->delete($category->img);
            }

            $category->delete();

            return response()->json(['success' => true, 'message' => 'Categoria excluída com sucesso.']);
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir categoria: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao excluir categoria!'], 500);
        }
    }

}
