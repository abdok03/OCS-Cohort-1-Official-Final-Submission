<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

public function index(Request $request)
{

   $query = User::query();

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('first_name', 'like', "%{$request->search}%")
              ->orWhere('last_name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }

    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    $users = $query->latest()->paginate(2)->withQueryString();

    $stats = [
        'total' => User::count(),
        'active' => User::where('active', 1)->count(),
        'pending' => User::where('active', 0)->count(),
        'suspended' => 0,
    ];

    $totalUsers   = User::count();
    $activeUsers  = User::where('active', 1)->count();
    $pendingUsers = User::where('active', 0)->count();

    return view('pages.users', compact(
        'users',
        'totalUsers',
        'activeUsers',
        'pendingUsers'
    ));
}



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'role'       => 'required|string',
        'active'     => 'required|boolean',
    ]);

    // إنشاء المستخدم
    User::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'role'       => $request->role,
        'active'     => $request->active,
        'password'   => bcrypt('12345678'), // كلمة مرور افتراضية
    ]);

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           $user = User::findOrFail($id);
        $user->delete();
    return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
