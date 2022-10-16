<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //$request->authenticate();
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);
        $nama_pegawai = "";
        $password = "";
        $telp = "";
        $jabatan = "";
        $pegawai = new User();
        $data_pegawai = $pegawai->getDataByEmail($request->email);
        foreach ($data_pegawai as $value) {
            $nama_pegawai = $value->name;
            $password = $value->password;
            $telp = $value->nomor_telepon_pegawai;
            $jabatan = $value->jabatan;
        }
        if($nama_pegawai != ""){
            if(Hash::check($request->password, $password)){
                return redirect('/dashboard');
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
        //dd($data_pegawai->);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Auth::guard('web')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/');
    }
}
