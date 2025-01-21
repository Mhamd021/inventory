<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsProfileOwnerMiddleware
{

    public function handle(Request $request,Post $post, Closure $next): Response
    {
        if(auth()->user()->is_admin == 1 || auth()->user()->id == $post->user_id)
        {
            abort(403);
        }
        return $next($request);
    }
}
