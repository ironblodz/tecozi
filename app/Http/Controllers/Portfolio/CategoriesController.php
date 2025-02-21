<?php

namespace App\Http\Controllers\Portfolio;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PortfolioCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Valida os dados da requisição.
     *
     * @param Request $request
     * @return void
     */
    public function validateData($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'nullable|string',
            'label' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'img.image' => 'A imagem de capa deve ser um arquivo de imagem.',
        ]);
    }

    /**
     * Exibe a lista de categorias.
     *
     * @param Request $request
     * @return \Inertia\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = PortfolioCategory::orderBy('order'); // Ordenar pelo campo 'order'

        // Aplicar filtros se necessário
        if ($request->input('visible_on_portfolio', false)) {
            $query->where('visible_on_portfolio', true);
        }

        $categories = $query->get();

        if ($request->wantsJson()) {
            return response()->json($categories);
        }

        return Inertia::render('Backoffice/Portfolio/Categories/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Reordena as categorias com base nos IDs fornecidos.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        $orderedIds = $request->input('orderedIds');

        foreach ($orderedIds as $index => $id) {
            PortfolioCategory::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['message' => 'Ordem atualizada com sucesso.'], 200);
    }

    /**
     * Alterna o status de arquivamento da categoria.
     *
     * @param Request $request
     * @param PortfolioCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleArchive(Request $request, PortfolioCategory $category)
    {
        $category->archived = !$category->archived;
        $category->save();

        return response()->json(['message' => 'Categoria atualizada com sucesso.']);
    }

    /**
     * Alterna a visibilidade da categoria nos materiais.
     *
     * @param Request $request
     * @param PortfolioCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleVisibility(Request $request, PortfolioCategory $category)
    {
        $category->visible_in_materials = !$category->visible_in_materials;
        $category->save();

        return response()->json(['message' => 'Visibilidade da categoria atualizada com sucesso.']);
    }

    /**
     * Alterna a visibilidade da categoria no portfólio.
     *
     * @param Request $request
     * @param PortfolioCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleVisibilityOnPortfolio(Request $request, PortfolioCategory $category)
    {
        $category->visible_on_portfolio = !$category->visible_on_portfolio;
        $category->save();

        return response()->json(['message' => 'Visibilidade no portfólio atualizada com sucesso.']);
    }

    /**
     * Obtém as categorias com limite definido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Exibe o formulário de criação da categoria.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Backoffice/Portfolio/Categories/Create');
    }

    /**
     * Armazena uma nova categoria ou atualiza uma existente.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida os dados da requisição
        $this->validateData($request);

        // Criação ou atualização da categoria
        $category = PortfolioCategory::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'reference' => $request->reference,
                'label' => $request->label,
                'img' => $request->hasFile('img') ? $request->file('img')->store('categories', 'public') : ($category->img ?? null),
                'visible_on_portfolio' => $request->input('visible_on_portfolio', false),
                'archived' => $request->input('archived', false),
            ]
        );

        return redirect()->route('portfolio.categories.index')->with('success', 'Categoria salva com sucesso!');
    }

    /**
     * Exibe o formulário de edição da categoria.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $category = PortfolioCategory::findOrFail($id);

        // Garante que a URL da imagem é acessível no frontend
        if ($category->img) {
            $category->img = asset('storage/' . $category->img);
        }

        return Inertia::render('Backoffice/Portfolio/Categories/Edit', [
            'category' => $category,
        ]);
    }



    /**
     * Atualiza uma categoria existente.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PortfolioCategory $category)
    {
        \Log::info('Recebendo dados no update:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'nullable|string',
            'label' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'visible_on_portfolio' => 'boolean',
            'archived' => 'boolean',
        ]);

        $category->update([
            'name' => $validated['name'],
            'reference' => $validated['reference'],
            'label' => $validated['label'],
            'visible_on_portfolio' => $validated['visible_on_portfolio'],
            'archived' => $validated['archived'],
        ]);

        if ($request->hasFile('img')) {
            if ($category->img && Storage::disk('public')->exists($category->img)) {
                Storage::disk('public')->delete($category->img);
            }

            $imagePath = $request->file('img')->store('categories', 'public');
            $category->img = $imagePath;
            $category->save();
        }

        return response()->json(['message' => 'Categoria atualizada com sucesso!', 'category' => $category]);
    }

    /**
     * Exclui uma categoria.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        \Log::info('Tentativa de eliminar categoria', ['id' => $id]);

        if (!$id) {
            return response()->json(['error' => 'ID não fornecido.'], 400);
        }

        try {
            $category = PortfolioCategory::findOrFail($id);
            $category->delete();

            return response()->json(['success' => true, 'message' => 'Categoria eliminada com sucesso.']);
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir categoria: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao excluir categoria!'], 500);
        }
    }

}
