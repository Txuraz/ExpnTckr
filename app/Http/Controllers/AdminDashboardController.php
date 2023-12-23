<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {

        Auth::user();
        $total_categories = Category::count();
        $total_roles = Role::count();
        $user = User::with('roles')->get();
        $total_user = User::count();
        return view('pages.admin_dashboard', compact('user', 'total_user', 'total_categories', 'total_roles'));
    }

    public function UserDetails()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('pages.userDetails', compact('users', 'roles'));

    }

    public function UpdateUser(Request $request, $id)
    {
        $userdata = User::findorfail($id);

        $userdata->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($request->has('role_id')) {
            $userdata->roles()->sync([$request->input('role_id')]);
        }

        return redirect()->back()->with('message', 'Saved Successfully');
    }



    public function DeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->delete();

        return redirect()->back();
    }

    public function permissions()
    {
        $permissions = Permission::all();
        return view('pages.rolesandpermission', compact('permissions'));
    }




}
