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
            ->orderBy('day_of_week')
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
                'day_of_week',
                'open_time',
                'close_time',
                'is_closed',
            ]);

        return response()->json([
            'data' => $contacts,
        ]);
    }
}
