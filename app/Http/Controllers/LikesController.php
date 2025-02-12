<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LikesController extends Controller
{

    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function toggleLike($postId)
    {

        $result = $this->likeService->toggleLike($postId);
        return response()->json($result);
    }


    public function index()
    {

    }


    public function create()
    {

    }
    public function store(Request $request)
    {

    }


    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
