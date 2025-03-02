<?php

namespace App\Http\Controllers\Portfolio;

use App\Models\CategoryPhoto;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PortfolioImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    //

    public function store(Request $request)
{
    // Validação
    $validatedData = $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'portfolioId' => 'required|integer'
    ]);

    try {
        // Salva o arquivo no disco 'public' dentro da pasta 'portfolios'
        $imagePath = $request->file('file')->store('portfolios', 'public');

        // Cria o registro no banco
        PortfolioImage::create([
            'portfolio_id' => $request->portfolioId,
            'path'         => $imagePath,
        ]);

        // Carrega todas as imagens do mesmo portfolio
        // (para retornar a lista completa após cada upload)
        $portfolioImages = PortfolioImage::where('portfolio_id', $request->portfolioId)->get();

        // Retorna todas as imagens desse portfolio
        return response()->json([
            'images' => $portfolioImages
        ], 201);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function deleteGalleryImage(Request $request)
{
    $imageId = $request->input('id');

    // Certifique-se de que o ID foi enviado
    if (!$imageId) {
        return response()->json(['error' => 'ID da imagem não fornecido.'], 400);
    }

    try {
        $image = CategoryPhoto::findOrFail($imageId);

        // Exclui o arquivo do armazenamento
        if (Storage::exists($image->path)) {
            Storage::delete($image->path);
        }

        // Remove o registro do banco de dados
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Imagem excluída com sucesso.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao excluir a imagem: ' . $e->getMessage()], 500);
    }
}


    public function remove(Request $request)
    {
        // Decodifique os dados JSON enviados pelo FilePond
        $data = $request->all();

        // Verifique se a chave "imageId" está presente
        if (!isset($data['imageId'])) {
            return response()->json(['error' => 'O id da imagem não fornecido'], 400);
        }

        try {
            $imageId = $data['imageId'];

            $portfolioImage = PortfolioImage::findOrFail($imageId);

            // Remova o arquivo físico
            Storage::disk('public')->delete($portfolioImage->path);

            // Remova o registro no banco
            $portfolioImage->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
