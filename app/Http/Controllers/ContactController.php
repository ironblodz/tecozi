<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
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
            // Cria um novo contato com os dados validados
            Contact::create($validatedData);

            return redirect()->route('contacts.index')->with('success', 'Contato criado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar o contato: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Contact $contact)
    {
        $validatedData = $this->validateData($request);

        try {
            $contact->update($validatedData);  // Automatically uses the `$contact` instance
            return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro para atualizar contato: ' . $e->getMessage());
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
