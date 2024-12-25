<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function validateData($request) {
        return $request->validate([
            'first_name' => 'required|string|max:100',
            'nickname' => 'required|string|max:100',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|regex:/^\+?[0-9\s\-]{7,15}$/',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:255',
        ]);
    }

    public function index(Request $request)
    {
        $contacts = Contact::latest()->get();

        if ($contacts) {
            return Inertia::render('Backoffice/Contact/Index', [
                'contacts' => $contacts
            ]);
        }

        $this->returnError ($request, 'Algo deu errado!');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return Inertia::render('Backoffice/Contact/Edit', [
            'contact' => $contact
        ]);
    }

    public function create()
    {
        return Inertia::render('Backoffice/Contact/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateData($request);

        try {
            Contact::create($validatedData);

            return response()->json(['message' => 'Contato criado com sucesso.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar contato.', 'error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, Contact $contact)
    {

        $validatedData = $this->validateData($request);

        try {
            $contact->where('id', $request->id)->update($validatedData);

            $this->returnSuccess ($request, 'Contato atualizado com sucesso.');

        } catch (\Exception $e) {

            $this->returnError ($request, 'Erro para atualizar contato: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {

            Contact::where('id', $request->id)->delete();
            $this->returnSuccess ($request, 'Contato excluido com sucesso.');

        } catch (\Exception $e) {

            $this->returnError ($request, 'Erro ao excluir contato: ' . $e->getMessage());

        }
    }
}
