<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialPhoto;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Storage;

class MaterialController extends Controller
{
    // Função de validação de dados
    public function validateData($request)
    {
        return $request->validate([
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }

    // Método index para listar os materiais
    public function index()
    {
        $materials = Material::with('photos')->latest()->get()->map(function ($material) {
            return [
                'id' => $material->id,
                'title' => $material->title,
                'description' => $material->description,
                'photo' => $material->photo ? asset("storage/{$material->photo}") : null,
                'gallery' => $material->photos ? $material->photos->map(function ($photo) {
                    return asset("storage/{$photo->photo}");
                }) : []
            ];
        });

        return Inertia::render('Backoffice/Materials/Index', [
            'materials' => $materials
        ]);
    }

    public function getMaterials()
    {
        $materials = Material::with('photos')->latest()->get()->map(function ($material) {
            return [
                'id' => $material->id,
                'title' => $material->title,
                'description' => $material->description,
                'photo' => $material->photo ? asset("storage/{$material->photo}") : null,
                'gallery' => $material->photos->map(function ($photo) {
                    return asset("storage/{$photo->photo}");
                })
            ];
        });

        return response()->json(['materials' => $materials]);
    }



    // Método create para exibir o formulário de criação
    public function create()
    {
        return Inertia::render('Backoffice/Materials/Create');
    }

    // Método store para armazenar os dados de um novo material
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery_photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validação para múltiplas imagens
        ]);

        try {
            // Salvar o material
            $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('materials', 'public') : null;
            $material = Material::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'photo' => $photoPath,
            ]);

            // Se houver imagens na galeria, salva-as
            if ($request->hasFile('gallery_photos')) {
                foreach ($request->file('gallery_photos') as $file) {
                    $path = $file->store('materials/gallery', 'public');
                    MaterialPhoto::create([
                        'material_id' => $material->id,
                        'photo' => $path,
                    ]);
                }
            }

            return response()->json(['message' => 'Material criado com sucesso!', 'material' => $material]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar o material: ' . $e->getMessage()], 500);
        }
    }

    // Método edit para exibir o formulário de edição de um material
    public function edit($id)
    {
        $material = Material::with('photos')->findOrFail($id);

        return Inertia::render('Backoffice/Materials/Edit', [
            'material' => [
                'id' => $material->id,
                'title' => $material->title,
                'description' => $material->description,
                'photo' => $material->photo ? asset("storage/{$material->photo}") : null,
                'gallery' => $material->photos ? $material->photos->map(function ($photo) {
                    return asset("storage/{$photo->photo}");
                }) : []
            ]
        ]);
    }


    // Método update para atualizar os dados de um material
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $material = Material::findOrFail($id);

            if ($request->hasFile('photo')) {
                if ($material->photo) {
                    Storage::delete("public/{$material->photo}");
                }
                $material->photo = $request->file('photo')->store('materials', 'public');
            }

            $material->title = $request->input('title');
            $material->description = $request->input('description');
            $material->save();

            // Atualizar galeria de fotos
            if ($request->hasFile('gallery_photos')) {
                // Remover fotos antigas
                MaterialPhoto::where('material_id', $id)->delete();

                // Salvar novas fotos
                foreach ($request->file('gallery_photos') as $file) {
                    $photoPath = $file->store('materials/gallery', 'public');
                    MaterialPhoto::create([
                        'material_id' => $material->id,
                        'photo' => $photoPath,
                    ]);
                }
            }

            return redirect()->route('materials.index')->with('success', 'Material atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar material: ' . $e->getMessage()]);
        }
    }

    // Método destroy para excluir um material
    public function destroy($id)
    {
        try {
            $material = Material::findOrFail($id);

            if ($material->photo) {
                Storage::delete("public/{$material->photo}");
            }

            $material->delete();

            return response()->json(['message' => 'Material excluído com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir o material: ' . $e->getMessage()], 500);
        }
    }

    // Exemplo de um método para lidar com erros
    public function returnError($message = 'Something went wrong!')
    {
        return response()->json(['error' => $message], 500);
    }
}
