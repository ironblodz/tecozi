<?php

namespace App\Http\Controllers\Portfolio;

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
        // Valida se a requisição possui uma imagem válida
        $validatedData = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = $request->file('file')->store('portfolios', 'public');
            $portfolioImage = PortfolioImage::create([
                'portfolio_id' => $request->portfolioId,
                'path' => $imagePath,
            ]);

            // Retorna o ID da imagem como 'imageId'
            return response()->json([
                'imageId' => $portfolioImage->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
