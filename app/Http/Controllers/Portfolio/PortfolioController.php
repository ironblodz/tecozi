<?php

namespace App\Http\Controllers\Portfolio;

use Inertia\Inertia;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    //
    public function validateData($request) {
        return $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|integer|exists:portfolio_categories,id'
        ]);
    }

    public function index(Request $request)
    {
        // Verifica se a requisição tem o parâmetro 'show_archived' e filtra accordingly
        $showArchived = $request->get('show_archived', false);

        $portfolios = Portfolio::when(!$showArchived, function ($query) {
            // Se não for para mostrar arquivados, filtra para mostrar apenas portfólios não arquivados
            $query->where('archived', false);
        })->latest()->get();

        if ($portfolios) {
            return Inertia::render('Backoffice/Portfolio/Index', [
                'portfolios' => $portfolios
            ]);
        }

        $this->returnError($request, 'Algo deu errado!');
    }


    public function getPortfolios(Request $request)
{
    // Verifica se a requisição tem o parâmetro 'show_archived' e filtra accordingly
    $showArchived = $request->get('show_archived', false);

    $portfolios = Portfolio::when(!$showArchived, function ($query) {
        // Se não for para mostrar arquivados, filtra para mostrar apenas portfólios não arquivados
        $query->where('archived', false);
    })->latest()->get();

    // Retorna os dados como JSON
    if ($portfolios) {
        return response()->json($portfolios);
    }

    return response()->json(['error' => 'Algo deu errado!'], 500);
}


    public function toggleHighlight(Request $request)
    {
        try {
            $portfolio = Portfolio::findOrFail($request->id);
            $portfolio->highlighted = !$portfolio->highlighted; // Toggle the highlighted status
            $portfolio->save();

            // Verificar se a imagem existe e gerar a URL pública
            $imageUrl = $portfolio->main_image ? Storage::url($portfolio->main_image) : null;

            return response()->json([
                'success' => true,
                'message' => 'Status do portfólio atualizado com sucesso.',
                'data' => $portfolio,
                'image_url' => $imageUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o status: ' . $e->getMessage()], 500);
        }
    }

    public function toggleArchive(Request $request)
{
    try {
        // Tenta encontrar o portfólio pelo ID fornecido
        $portfolio = Portfolio::findOrFail($request->id);

        // Alterna o estado do arquivamento
        $portfolio->archived = !$portfolio->archived;
        $portfolio->save();

        // Define a mensagem de sucesso dependendo do estado do arquivamento
        $message = $portfolio->archived ? 'Portfólio arquivado com sucesso.' : 'Portfólio desarquivado com sucesso.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $portfolio, // Envia o objeto do portfólio com o novo estado
            'archived' => $portfolio->archived // Inclui o estado 'archived' no retorno para facilitar o frontend
        ]);
    } catch (\Exception $e) {
        // Caso haja um erro, retornamos uma mensagem de erro
        return response()->json([
            'error' => 'Erro ao atualizar status de arquivamento: ' . $e->getMessage()
        ], 500);
    }
}

    public function create()
    {
        $categories = PortfolioCategory::all();

        return Inertia::render('Backoffice/Portfolio/Create', [
            'categories' => $categories, // Passa as categorias para a página
        ]);
    }


    public function store(Request $request)
{
    $validatedData = $this->validateData($request);

    try {
        // Verifica se a imagem foi enviada e faz o upload
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
            $path = $request->file('main_image')->store('portfolios', 'public');
            $validatedData['main_image'] = $path;
        }

        $portfolio = Portfolio::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Portfólio criado com sucesso.',
            'data' => $portfolio,
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao criar portfólio: ' . $e->getMessage()], 500);
    }
}


    public function edit($id)
    {
        $portfolio = Portfolio::with('images')->findOrFail($id);

        return Inertia::render('Backoffice/Portfolio/Edit', [
            'portfolio' => $portfolio
        ]);
    }

    public function update(Request $request)
    {
        $portfolio = Portfolio::findOrFail($request->id); // Buscar portfolio pelo ID
        $validatedData = $this->validateData($request);

        try {
            // Verificar se uma nova imagem foi enviada e é válida
            if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
                // Excluir a imagem antiga, se existir
                if ($portfolio->main_image && Storage::disk('public')->exists($portfolio->main_image)) {
                    Storage::disk('public')->delete($portfolio->main_image);
                }

                // Armazenar a nova imagem e atualizar o caminho no banco de dados
                $path = $request->file('main_image')->store('portfolios', 'public');
                $validatedData['main_image'] = $path;
            }

            // Atualizar o registro existente no banco de dados
            $portfolio->update($validatedData);

            $this->returnSuccess('Portfólio atualizado com sucesso.');

        } catch (\Exception $e) {
            $this->returnError('Erro ao atualizar portfólio: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {

            Portfolio::where('id', $request->id)->delete();
            $this->returnSuccess ($request, 'Portfolio excluido com sucesso.');

        } catch (\Exception $e) {

            $this->returnError ($request, 'Erro ao excluir portfolio: ' . $e->getMessage());

        }
    }
}
