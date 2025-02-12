<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\FriendStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Validator;


class FriendsApiController extends Controller
{

    public function index()
    {
        $user = auth('sanctum')->user();
        $friends = $user->friends;
        if($friends)
        {
            return response()->json(
                [
                    'message' => 'success',
                    'friends' => $friends
                ],
                200
            );
        }
        else
        {
            return response()->json(['message' => 'you have no friends go ahead and add some friends!'], 404);
        }
        }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
           'user_id' => ['required'],
            'friend_id' => ['required'],
            'status' => [new Enum(FriendStatus::class)],
        ]);

        if ($validator->fails()) {

                return response()->json(
                    $validator->errors(),403);


            }


            else
            {
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

                        ]
                        ,200
                    );


            }

            //event for the Friend request
    }
    public function show(Friend $friend)
    {
        return response()->json([
            'friend' => $friend,

        ],   200);
    }


    public function update(Request $request, Friend $friend)
    {

        $validator = Validator::make($request->all(),
        [
            'status' => [
                        new Enum(FriendStatus::class)
                        ]
        ]);


        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),403);
            }
            else
            {
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

    }
    public function destroy(Friend $friend)
    {

        $friend_delete = Friend::find($friend->id);
        if(auth('sanctum')->user()->id == $friend_delete->friend_id || auth('sanctum')->user()->id == $friend_delete->user_id)
        {
            $friend_delete->delete();

            return response()->json(
                [
                    'message' => 'success',
                    'status' => 200,
                ]
            );
        }
        else
        {
            return response()->json(['message' => 'unautorized']);
        }

    }


}
