<?php

namespace App\Http\Controllers\Portfolio;

use App\Models\CategoryPhoto;
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
            'reference' => 'nullable|string',
            'label' => 'nullable|string',
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
        $query = PortfolioCategory::orderBy('order'); // Ordenar pelo campo 'order'

        // Aplicar filtros se necessário
        if ($request->input('visible_on_portfolio', false)) {
            $query->where('visible_on_portfolio', true);
        }

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

    public function reorder(Request $request)
{
    $orderedIds = $request->input('orderedIds');

    foreach ($orderedIds as $index => $id) {
        PortfolioCategory::where('id', $id)->update(['order' => $index + 1]);
    }

    return response()->json(['message' => 'Ordem atualizada com sucesso.'], 200);
}


    public function getVisibleInMaterialsCategories(Request $request)
    {
        $categories = PortfolioCategory::where('visible_in_materials', true)
            ->with('photos') // Carrega as fotos relacionadas
            ->get();

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
        // Criação ou atualização da categoria
        $category = PortfolioCategory::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'img' => $request->hasFile('img') ? $request->file('img')->store('images') : (isset($category) ? $category->img : null),
            ]
        );

        // Remover imagens existentes se necessário
        if ($request->filled('removedGallery')) {
            $removedIds = json_decode($request->removedGallery, true);
            foreach ($removedIds as $id) {
                $photo = CategoryPhoto::find($id);
                if ($photo) {
                    Storage::delete($photo->photo_path);
                    $photo->delete();
                }
            }
        }

        // Adicionar novas imagens à galeria
        if ($request->hasFile('newGallery')) {
            foreach ($request->file('newGallery') as $file) {
                $path = $file->store('gallery');
                $category->photos()->create(['photo_path' => $path]);
            }
        }

        return redirect()->route('portfolio.categories.index')->with('success', 'Categoria salva com sucesso!');
    }

    public function update(Request $request, $id)
    {
        try {
            // Encontrar a categoria existente
            $category = PortfolioCategory::findOrFail($id);

            // Validação dos dados recebidos
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'reference' => 'nullable|string',
                'label' => 'nullable|string',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'new_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'removedGallery' => 'nullable|json', // Atualizado para corresponder ao frontend
            ]);

            // Atualizar campos básicos
            $category->name = $validated['name'];
            $category->subtitle = $validated['subtitle'];
            $category->description = $validated['description'];

            // Atualizar imagem principal, se fornecida
            if ($request->hasFile('img')) {
                // Remover imagem antiga, se existir
                if ($category->img) {
                    Storage::delete('public/' . $category->img);
                }
                // Armazenar a nova imagem
                $path = $request->file('img')->store('categories', 'public');
                $category->img = $path;
            }

            $category->save();

            // Processar imagens existentes que devem ser removidas
            if ($request->filled('removedGallery')) {
                $removedIds = json_decode($request->removedGallery, true);
                if (is_array($removedIds)) {
                    foreach ($removedIds as $photoId) {
                        $photo = CategoryPhoto::find($photoId);
                        if ($photo) {
                            Storage::delete('public/' . $photo->photo_path);
                            $photo->delete();
                        }
                    }
                }
            }

            // Adicionar novas imagens à galeria
            if ($request->hasFile('new_gallery')) {
                foreach ($request->file('new_gallery') as $file) {
                    $path = $file->store('categories/gallery', 'public');
                    $category->photos()->create(['photo_path' => $path]);
                }
            }

            return response()->json(['success' => 'Categoria atualizada com sucesso!'], 200);
        } catch (\Exception $e) {
            // Registrar o erro nos logs
            \Log::error('Erro ao atualizar categoria: ' . $e->getMessage());

            // Retornar resposta de erro
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
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
