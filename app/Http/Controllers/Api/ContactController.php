<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // GET /contacts
    public function index()
    {
        return ContactResource::collection(Contact::latest()->paginate(10));
    }

    // POST /contacts
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:contact,slug',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'hours' => 'required|string',
            'map_embed' => 'required|string',
            'email' => 'required|email',
        ]);

        $contact = Contact::create($data);

        return new ContactResource($contact);
    }

    // GET /contacts/{id}
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    // PUT/PATCH /contacts/{id}
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:contact,slug,' . $contact->id,
            'address' => 'sometimes|string',
            'phone' => 'sometimes|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'hours' => 'sometimes|string',
            'map_embed' => 'sometimes|string',
            'email' => 'sometimes|email',
        ]);

        $contact->update($data);

        return new ContactResource($contact);
    }

    // DELETE /contacts/{id}
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}
