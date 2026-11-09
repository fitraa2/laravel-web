<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
            $data['users'] = User::all();
            return view('admin.user.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menggabungkan first_name dan last_name menjadi kolom 'name' bawaan tabel users
        $data['name'] = $request->first_name . ' ' . $request->last_name;
		$data['email'] = $request->email;
        $data['password'] = Hash::make('password123');

		User::create($data);

		return redirect()->route('user.index')->with('success','Penambahan Data Berhasil!');
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
        $data['dataUser'] = User::findOrFail($id);
        return view('admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Menyesuaikan pengubahan data dengan kolom tabel users bawaan
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;

        $user->save();
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
