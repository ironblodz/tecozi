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
    public function validateData($request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|integer|exists:portfolio_categories,id'
        ]);
    }

    public function index(Request $request)
    {
        $showArchived = $request->get('show_archived', false);

        $portfolios = Portfolio::with('images')->when(!$showArchived, function ($query) {
            $query->where('archived', false);
        })->latest()->get();

        return Inertia::render('Backoffice/Portfolio/Index', [
            'portfolios' => $portfolios
        ]);
    }


    public function getPortfolios(Request $request)
    {
        $showArchived = $request->get('show_archived', false);

        $portfolios = Portfolio::with('images')->when(!$showArchived, function ($query) {
            $query->where('archived', false);
        })->latest()->get();

        return response()->json($portfolios);
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
            // Upload da imagem principal
            if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
                $path = $request->file('main_image')->store('portfolios', 'public');
                $validatedData['main_image'] = $path;
            }

            // Cria o portfólio com as informações validadas
            $portfolio = Portfolio::create($validatedData);

            // Upload das imagens da galeria
            if ($request->hasFile('gallery_photos')) {
                foreach ($request->file('gallery_photos') as $image) {
                    $imagePath = $image->store('portfolios/gallery', 'public');
                    $portfolio->images()->create(['path' => $imagePath]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Portfólio criado com sucesso.',
                'data' => $portfolio->load('images'), // Carrega as imagens associadas
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar portfólio: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
{
    $portfolio = Portfolio::with('images')->findOrFail($id);

    return Inertia::render('Backoffice/Portfolio/Edit', [
        'portfolio' => [
            'id' => $portfolio->id,
            'title' => $portfolio->title,
            'short_description' => $portfolio->short_description,
            'description' => $portfolio->description,
            'category_id' => $portfolio->category_id,
            'main_image' => $portfolio->main_image ? "/storage/" . $portfolio->main_image : null,
            'gallery' => $portfolio->images->map(fn($image) => "/storage/" . $image->path)->toArray(),
        ]
    ]);
}


public function update(Request $request)
{
    $portfolio = Portfolio::findOrFail($request->id);
    $validatedData = $this->validateData($request);

    try {
        // Atualizar a imagem principal apenas se uma nova for enviada
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
            if ($portfolio->main_image && Storage::disk('public')->exists($portfolio->main_image)) {
                Storage::disk('public')->delete($portfolio->main_image);
            }
            $path = $request->file('main_image')->store('portfolios', 'public');
            $validatedData['main_image'] = $path;
        } else {
            // Se nenhuma nova imagem principal for enviada, mantém a existente
            $validatedData['main_image'] = $portfolio->main_image;
        }

        // Processar imagens da galeria
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($portfolio->images as $image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            }

            foreach ($request->file('gallery_images') as $image) {
                $imagePath = $image->store('portfolios/gallery', 'public');
                $portfolio->images()->create(['path' => $imagePath]);
                $galleryPaths[] = "/storage/" . $imagePath;
            }
        } else {
            $galleryPaths = $portfolio->images()->pluck('path')->map(fn($path) => "/storage/" . $path)->toArray();
        }

        $portfolio->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Portfólio atualizado com sucesso.',
            'data' => [
                'main_image' => $portfolio->main_image ? "/storage/" . $portfolio->main_image : null,
                'gallery' => $galleryPaths,
            ],
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao atualizar portfólio: ' . $e->getMessage()], 500);
    }
}




    public function getFeaturedPortfolios()
    {
        $portfolios = Portfolio::with(['images', 'category'])
            ->where('highlighted', true)
            ->latest()
            ->get();

        return response()->json($portfolios);
    }


    public function destroy(Request $request)
    {
        try {
            $portfolio = Portfolio::findOrFail($request->id);

            // Remover as imagens da galeria do storage
            foreach ($portfolio->images as $image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            }

            // Remover a imagem principal
            if ($portfolio->main_image && Storage::disk('public')->exists($portfolio->main_image)) {
                Storage::disk('public')->delete($portfolio->main_image);
            }

            $portfolio->delete();

            return response()->json(['success' => true, 'message' => 'Portfólio excluído com sucesso.']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir portfólio: ' . $e->getMessage()], 500);
        }
    }

}
