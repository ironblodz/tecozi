<?php

namespace App\Http\Controllers;

use App\Models\Material;
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
        $materials = Material::latest()->get();

        return Inertia::render('Backoffice/Materials/Index', [
            'materials' => $materials
        ]);
    }


    // Método create para exibir o formulário de criação
    public function create()
    {
        return Inertia::render('Backoffice/Materials/Create');
    }

    // Método store para armazenar os dados de um novo material
    public function store(Request $request)
    {
        $this->validateData($request);

        try {
            // Verifica se há uma foto e a armazena
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('materials', 'public');
            } else {
                $photoPath = null;
            }

            Material::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'photo' => $photoPath,
            ]);

            return redirect()->route('materials.index')->with('success', 'Material criado com sucesso!');
        } catch (\Exception $e) {
            return $this->returnError('Erro ao salvar o material: ' . $e->getMessage());
        }
    }


    // Método edit para exibir o formulário de edição de um material
    public function edit($id)
    {
        $material = Material::findOrFail($id);

        return Inertia::render('Backoffice/Materials/Edit', [
            'material' => $material
        ]);
    }

    // Método update para atualizar os dados de um material
    public function update(Request $request, $id)
    {

        $this->validateData($request);

        try {
            $material = Material::findOrFail($id);

            if ($request->hasFile('photo')) {
                if ($material->photo) {
                    Storage::delete("public/{$material->photo}");
                }
                $photoPath = $request->file('photo')->store('materials', 'public');
                $material->photo = $photoPath;
            }

            $material->title = $request->input('title');
            $material->description = $request->input('description');
            $material->save();

            return redirect()->route('materials.index')->with('success', 'Material atualizado com sucesso!');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o material: ' . $e->getMessage()], 500);
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
