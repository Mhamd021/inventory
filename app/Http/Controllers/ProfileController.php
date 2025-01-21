<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {

        $users = User::all();
        return view('profile.index', compact('users'));
    }

    public function edit( User $user)
    {

        if (Auth::user() == $user || Auth::user()->is_admin === 1) {
            return view(
                'profile.edit',
                [
                    'user' => $user,
                    'friends' => $user->friends->count()
                ]
            );
        } else {
            abort(403);
        }
    }
    //updating profile image
    public function uploadProfileImage(Request $request, User $user)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();
        if ($request->hasFile('profile_image')) {
            if ($user->user_image) {
                $this->imageService->delete($user->user_image);
            }
         $user->user_image = $this->imageService->upload($request->profile_image, 'uploads/profile_images');
            $user->save();
        }
        return redirect()->back();
    }
    //delete profile image
    public function removeProfileImage($id)
    {
        $user = User::findorfail($id);
        $this->imageService->delete($user->user_image);
        $user->user_image = Null;
        $user->save();
        return redirect()->back()->with('status', 'success');
    }
    //update cover image
    public function uploadCoverImage(Request $request, User $user)
    {
        $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();
        if ($request->hasFile('cover_image')) {
            if ($user->cover_image) {
                $this->imageService->delete($user->cover_image);
            }
            $user->cover_image = $this->imageService->upload($request->cover_image, 'uploads/cover_images', 1920, 1080);
            $user->save();
        }
        return redirect()->back();
    }

    public function removeCoverImage($id)
    {
        $user = User::findorfail($id);
        $this->imageService->delete($user->cover_image);
        $user->cover_image = Null;
        $user->save();
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required','confirmed','min:8']
        ]);

        if(!Hash::check($request->current_password,$request->user()->password))
        {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        $request->user()->password = Hash::make($request->password);
        $request->user()->save();

        return redirect()->back()->with('success', 'Password successfully updated!');

    }
    public function update(ProfileUpdateRequest $request)
    {

        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email'))
        {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        return redirect()->back();
    }
    public function show(User $user)
    {
        $friends = $user->friends->count();
        return view('profile.show', compact('user','friends'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'deletePassword' => 'required'
         ]);
         if(!Hash::check($request->deletePassword,$request->user()->password))
         {
            return redirect()->back()->withErrors(['deleteError' => 'the password you entered is incorrect']);
         }
         $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
