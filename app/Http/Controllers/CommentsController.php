<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'comment_info' => ['bail', 'required', 'string'],
        'post_id' => ['required']
    ]);

    if ($validated) {
        Comment::create([
            'comment_info' => $request->comment_info,
            'user_id' => auth('sanctum')->user()->id,
            'post_id' => $request->post_id,
        ]);

        return redirect()->back()->with('Success','Comment Created');
    } else {
        return redirect()->back()->withErrors(['Error' => 'Comment is not Created']);
    }
}



    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
