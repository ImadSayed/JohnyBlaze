<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Http\Resources\LevelResource;
use App\Models\User;
use App\Models\Level;

class UsersController extends Controller
{
    public function index()
    {
        $users = UserResource::collection(User::all());
        $levels = LevelResource::collection(Level::all());
        $userLevels = $levels->mapWithKeys(function ($level) {
            return [$level->id => $level->name];
        });
        $isAdmin = $this->isAdmin();
        return Inertia::render('Users/Index', [
            'users' => $users,
            'userLevels' => $userLevels,
            'authUser' => new UserResource(Auth::user()),
            'isAdmin' => $isAdmin,
        ]);
    }

    public function edit($id)
    {
        $user = UserResource::make(User::find($id));
        $levels = LevelResource::collection(Level::all());
        $isAdmin = $this->isAdmin();
        $userLevels = $levels->mapWithKeys(function ($level) {
            return [$level->id => $level->name];
        });
        return Inertia::render('Users/Edit', [
            'user' => $user,
            'userLevels' => $userLevels,
            'isAdmin' => $isAdmin
        ]);
    }

    public function update(Request $request)
    {
        User::whereId($request->user_id)->update([
            'level_id' => $request->level_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User level updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    private function isAdmin()
    {
        $loggedInUserId = Auth::user()->id;
        $loggedInUser = User::find($loggedInUserId);
        return $loggedInUser->level_id > 1;
    }
}
