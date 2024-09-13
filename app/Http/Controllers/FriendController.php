<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use App\FriendStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Auth;
use App\Http\Resources\Friend as FriendResource;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(1);
        $friends = $user->friends;
        if($friends)
        {
            return response()->json(
                [
                    'message' => 'success',
                    'friends' => $friends
                ]
            );
        }
        else
        {
            return response()->json([
                "message" => "you have no friends go ahead and add some friends !"
            ]);
        }
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
            'user_id' => ['required'],
            'friend_id' => ['required'],
            'status' => [new Enum(FriendStatus::class)],

        ]);

        $friend = Friend::create(
            [
                'user_id' =>  $request->user_id,
                'friend_id' => $request->friend_id,
                'status' => $request->status
            ]
        );

        return response()->json(
            [
                'message' => 'success',
                'status' => 200
            ]
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(Friend $friend)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friend $friend)
    {
        $validated = $request->validate([
            'status' => [
                new Enum(FriendStatus::class)
            ],

        ]);




                $friend->status = $request->status;
                $friend->save();

        return response()->json(
            [
                'message' => 'success',
                'friend_status' => $friend,
                'status' => 200
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friend $friend)
    {
        $friend_delete = Friend::find($friend->id);
        $friend_delete->delete();

        return response()->json(
            [
                'message' => 'success',
                'status' => 200,
            ]
        );
    }
}
