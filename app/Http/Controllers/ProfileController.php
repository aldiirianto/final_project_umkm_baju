<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    //mau ngambil data user yang login
        $user = User::where('id', Auth::user()->id)->first();

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
       //validasi password
       $this->validate($request, [
           'password' => 'confirmed',
       ]);

       $user = User::where('id', Auth::user()->id)->first();

       if($user !== null){
           $user->name = $request->name;
           $user->email = $request->email;
           $user->no_hp = $request->no_hp;
           $user->alamat = $request->alamat;
           $user->password = Hash::make($request->password);
           $user->update();
       }

       Alert::success('User Sukses Diupdate', 'Success');
       return redirect('profile');

    }

    public function setPasswordAttribute($password)
    {
    $this->attributes['password'] = bcrypt($password);
    }

}
