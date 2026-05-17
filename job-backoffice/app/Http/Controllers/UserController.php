<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        if($request->input('archived') == true) {
            $query->onlyTrashed();
        }

        $users = $query->paginate(5)->onEachSide(2);

        return view('user.index', compact('users'));
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Only update the password if a new one is provided
        if($validated['password']) {
            $userData['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($userData);

        return to_route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(User $user)
    {
        $user->restore();
        return to_route('users.index', ['archived' => true])->with('success', 'User restored successfully.');
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete(User $user)
    {
        $user->forceDelete();
        return to_route('users.index', ['archived' => true])->with('success', 'User permanently deleted successfully.');
    }
}
