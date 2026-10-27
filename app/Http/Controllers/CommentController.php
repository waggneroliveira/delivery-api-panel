<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use HTMLPurifier;
use HTMLPurifier_Config;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::guard('client')->check()) {
            return response()->json(['message' => 'Você precisa estar logado para comentar.'], 401);
        }

        $validated = $request->validate([
            'comment' => ['required', 'max:10000', 'string', function ($attribute, $value, $fail) {
                $clean = trim(strip_tags($value));
                if ($clean === '') {
                    $fail('O campo comentário não pode ficar vazio ou conter somente espaços.');
                }
            }],
            'blog_id' => 'required|exists:blogs,id',
        ]);


        try {
            // Configuração padrão do HTMLPurifier
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);

            // Purifica o comentário
            $cleanComment = $purifier->purify($validated['comment']);

            DB::beginTransaction();

            Comment::create([
                'comment' => $cleanComment,
                'blog_id' => $validated['blog_id'],
                'client_id' => Auth::guard('client')->id(),
                'active' => 0,
            ]);

            DB::commit();

            return response()->json(['message' => 'Seu comentário foi enviado com sucesso e está aguardando moderação.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erro ao salvar comentário.'], 500);
        }
    }

    public function activeComment(Request $request, Comment $comment){
        $data['active'] = 1;

        try {
            DB::beginTransaction();
                $comment->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('success', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }
    public function desactiveComment(Request $request, Comment $comment){
        $data['active'] = 0;

        try {
            DB::beginTransaction();
                $comment->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('success', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        session()->flash('success', __('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
