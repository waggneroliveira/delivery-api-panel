<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function index(): JsonResponse
    {
        $contacts = Contact::query()
        ->orderBy('id')
        ->get([
            'id',
            'text',
            'whatsapp',
            'name_one',
            'address_one',
            'phone_one',
            'link_insta',
            'link_x',
            'link_youtube',
            'link_face',
            'link_tik_tok',
            'opening_hours',
        ]);

        return response()->json([
            'data' => $contacts,
        ]);
    }
}
