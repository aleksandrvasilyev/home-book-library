<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function destroy($commentId)
    {
//        dd($commentId);
        $comment = DB::table('libreviews')->where('id', $commentId)->first();
//        dd($comment);
        $this->authorize('deleteComment', $comment);
        DB::table('libreviews')->where('id', $commentId)->delete();

        return back()->with('message', 'Комментарий удален');
    }

    public function abuse($commentId)
    {
        $validatedData = request()->validate([
            'complaint' => 'required|string|max:2000',
        ]);

        $cleanText = $this->clean($validatedData['complaint']);

        DB::table('abuse')->insert([
            'user_id' => auth()->user()->id ?? '',
            'comment_id' => $commentId,
            'text' => $cleanText,
            'date' => now(),
        ]);

        return back()->with('message', 'Жалоба отправлена');

    }

    public function edit($commentId)
    {
        $comment = DB::table('libreviews')->where('id', $commentId)->first();
        $this->authorize('editComment', $comment->user_id);

        $validatedData = request()->validate([
            'text' => 'required|string|max:2000',
        ]);

        $cleanText = $this->clean($validatedData['text']);

        DB::table('libreviews')
            ->where('id', $commentId)
            ->update([
                'Text' => $cleanText,
            ]);

        return back()->with('message', 'Комментарий изменен');

    }
}
