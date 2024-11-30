<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
   
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

  
  public function store(Request $request)
{
    // Validate request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    // encrypt password
    $validatedData['password'] = bcrypt($validatedData['password']);
    $user = User::create($validatedData);

    //  token
    $token = $user->createToken('authToken')->accessToken;

    // Return token
    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ], 201);
}

public function show($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    return response()->json($user);
}

public function update(Request $request, $id)
{
    // Validate  data
    $validatedData = $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $updateData = $request->only(['name', 'email']);
    
    if ($request->filled('password')) {
        $updateData['password'] = bcrypt($request->password);
    }

    $user->update($updateData);

    return response()->json($user);
}

public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}

}
