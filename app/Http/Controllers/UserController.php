<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserController extends Controller
{
    public function index(){
        if (!Auth::check()){
            return redirect()->route('login')->withErrors([
                'email'=>'Please Login to acces the dashboard.',
            ])->onlyInput('email');

        }
        $users = User::get();
        return view('users')->with('userss', $users);
    }
    public function destroy(string $id)
    {
        $user = User::find($id);
        $file = public_path() . '/storage/' . $user->photo;
        try {
            if (File::exists($file)){
                File::delete($file);
                $user->delete();
            }

        }catch (\Throwable $th){
            return redirect('users')->with('error', 'Gagal hapus data');

        }return redirect('users')->with('succes', 'Berhasil hapus data');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($user->photo) {
                File::delete(public_path('storage/' . $user->photo));
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
