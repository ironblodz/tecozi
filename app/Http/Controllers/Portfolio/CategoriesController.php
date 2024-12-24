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
    public function validateData($request) {
        return $request->validate([
            'name' => 'required|string|max:255'
        ]);
    }

    public function index(Request $request)
{
    $categories = PortfolioCategory::latest()->get();

    // Verifica se a requisição é feita via AJAX ou se é uma requisição API
    if ($request->wantsJson()) {
        return response()->json($categories);  // Retorna as categorias como JSON
    }

    // Caso contrário, renderiza a página Inertia (se for uma requisição normal)
    return Inertia::render('Backoffice/Portfolio/Categories/Index', [
        'categories' => $categories
    ]);
}

public function getCategories(Request $request)
{

    $limit = 5;

    // Recupera os portfolios mais recentes, limitados pelo número definido
    $categories = PortfolioCategory::latest()->take($limit)->get();

    // Retorna os dados como JSON
    if ($categories) {
        return response()->json($categories);
    }

    return response()->json(['error' => 'Algo deu errado!'], 500);
}

    public function edit($id)
    {
        $category = PortfolioCategory::findOrFail($id);

        return Inertia::render('Backoffice/Portfolio/Categories/Edit', [
            'category' => $category
        ]);
    }

    public function create()
    {
        return Inertia::render('Backoffice/Portfolio/Categories/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateData($request);

        try {
            // Verifica se a imagem foi enviada e faz o upload
            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                $path = $request->file('img')->store('categories', 'public');
                $validatedData['img'] = $path; // Armazena o caminho da imagem no banco
            }

            PortfolioCategory::create($validatedData);

            $this->returnSuccess('Categoria criada com sucesso.');

        } catch (\Exception $e) {
            $this->returnError('Erro para criar a categoria: ' . $e->getMessage());
        }
    }


    public function update(Request $request)
    {
        $category = PortfolioCategory::findOrFail($request->id); // Buscar a categoria pelo ID
        $validatedData = $this->validateData($request);

        try {
            // Verificar se uma nova imagem foi enviada e é válida
            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                // Excluir a imagem antiga, se existir
                if ($category->img && Storage::disk('public')->exists($category->img)) {
                    Storage::disk('public')->delete($category->img);
                }

                // Armazenar a nova imagem e atualizar o caminho no banco de dados
                $path = $request->file('img')->store('categories', 'public');
                $validatedData['img'] = $path;
            }

            // Atualizar o registro existente no banco de dados
            $category->update($validatedData);

            $this->returnSuccess('Categoria atualizada com sucesso.');

        } catch (\Exception $e) {
            $this->returnError('Erro ao atualizar categoria: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            // Buscar a categoria pelo ID
            $category = PortfolioCategory::findOrFail($request->id);

            // Verificar se existe uma imagem associada
            if ($category->img) {
                Storage::disk('public')->delete($category->img); // Use o disco correto
            }

            // Excluir a categoria do banco de dados
            $category->delete();

            return $this->returnSuccess('Categoria excluída com sucesso.');

        } catch (\Exception $e) {
            return $this->returnError('Erro ao excluir categoria: ' . $e->getMessage());
        }
    }
}
