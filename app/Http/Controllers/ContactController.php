<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Contact;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function validateData($request) {
        return $request->validate([
            'first_name' => 'required|string|max:100',
            'nickname' => 'required|string|max:100',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|regex:/^\+?[0-9\s\-]{7,15}$/',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:255',
            'recaptcha_token' => 'required|string',
        ]);
    }

    public function index(Request $request)
    {
        $contacts = Contact::latest()->get();

        return Inertia::render('Backoffice/Contact/Index', [
            'contacts' => $contacts
        ]);
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
    unset($validatedData['recaptcha_token']);

    try {
        // Guardar o contacto na base de dados
        $contact = Contact::create($validatedData);

        // Enviar o e-mail ao dono do site
        Mail::to('naylestorm12@gmail.com')->send(new ContactFormMail($validatedData));

        return redirect()->route('contacts.index')->with('success', 'Contato criado e email enviado com sucesso.');
    } catch (\Exception $e) {
        return back()->with('error', 'Erro ao criar o contato ou enviar email: ' . $e->getMessage());
    }
}


    /**
     * Verifica o reCAPTCHA ignorando a validação de SSL
     */
    private function verifyRecaptcha($recaptchaToken)
    {
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        $response = Http::asForm()
            ->withoutVerifying() // Ignora a verificação SSL
            ->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptchaToken,
            ]);

        return $response->json();
    }

    public function update(Request $request, Contact $contact)
    {
        $validatedData = $this->validateData($request);

        try {
            $contact->update($validatedData);
            return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar contato: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            Contact::where('id', $request->id)->delete();
            return back()->with('success', 'Contato excluído com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir contato: ' . $e->getMessage());
        }
    }
}
