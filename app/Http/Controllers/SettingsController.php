<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRoles;
use App\Models\Department;


class SettingsController extends Controller
{

    public function index(){
        $users = User::all(['id', 'name', 'department', 'role', 'email']);
        $roles = Role::all();
        $departments = Department::all();
        // dd($users);

        return view('settings.index', compact('users', 'roles', 'departments'));
    }
    
    public function edit(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'department' => ['required', 'string'],
            'role' => ['required', 'string'],
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'department' => $request->input('department'),
            'role' => $request->input('role'),
        ]);

        return back()->with('success', 'Customer updated successfully.');
        // return view('settings.index', compact('users', 'roles'));
    }
   
   
    public function editDepartment(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string'],
            'role' => ['required', 'string'],
        ]);

        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->input('name'),
            'role' => $request->input('role'),
        ]);

        return back()->with('success', 'Customer updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
   
    public function deleteRole($id)
    {
        $user = Role::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Role deleted successfully.');
    }

    public function store(Request $request){
      
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'department' => ['required', 'string'],
            'role' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'department' => $validatedData['department'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // if($user->id){
        //     $id = UserRoles::create([
        //         'user_id' => $user->id,
        //         'role_id' => $validatedData['role'],
        //         'department' => $validatedData['department'],
        //     ]);
        // }
        
        return back()->with('success', 'User created successfully.');
    }
   
   
    public function upload_profile(Request $request, $id){
      
         // Validate the request
         $request->validate([
            'profile_photo_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $profileImagePath = $request->file('profile_photo_path')->store('profile_images', 'public');

        $user = User::findOrFail($id);

        $user->update([
            'profile_photo_path' => $profileImagePath,
        ]);
        
        return back()->with('success', 'User created successfully.');
    }
    
}
