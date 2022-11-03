<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Login\EmailChecker;
use App\Rules\Login\PasswordChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $messages = [
            'email.required' => 'Email Tidak Boleh Kosong!',
            'email.email' => 'Format Email Salah!',
            'email.unique' => 'Email Tidak Boleh Sama!',
            'nama.required' => 'Nama Lengkap Tidak Boleh Kosong!',
            'nama.max' => 'Nama Lengkap Maksimal Terdiri dari 100 karakter!',
            'telepon.numeric' => 'Nomor Telepon Hanya Boleh Berupa Angka!',
            'telepon.max_digits' => 'Nomor Telepon Maksimal Terdiri dari 15 Digit Angka!',
            'password.required' => 'Password Tidak Boleh Kosong!',
            'password.min' => 'Password Minimal Terdiri dari 6 karakter!',
            'password.max' => 'Password Maximal Terdiri dari 20 karakter!',
            'password.confirmed' => 'Konfirmasi Password Tidak Sama Dengan Password!',
            'password_confirmation.required' => 'Konfirmasi Password Tidak Boleh Kosong!',
        ];
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:users',
            'nama' => 'required|string|max:100',
            'telepon' => 'numeric|max_digits:15',
            'password' => 'required|string|min:6|max:20|confirmed',
            'password_confirmation' => 'required',
        ], $messages);
        //min_digits:6|max_digits:15
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $user = User::create([
            'email' => $request->email,
            'name' => $request->nama,
            'phone' => $request->telepon,
            'password' => Hash::make($request->password),
        ]);

        $response = [
            'status' => 201,
            'success'=> true,
            'message'=> 'User Berhasil Terdaftar',
            'data'   => [
                'token' => $user->createToken('MyApp')->plainTextToken,
                'name' => $user->name,
                'email' => $user->email
            ]
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $messages = [
            'email.required' => 'Email Tidak Boleh Kosong!',
            'password.required' => 'Password Tidak Boleh Kosong!',
        ];
        $validation = Validator::make($request->all(), [
            'email' => ['required', new EmailChecker()],
            'password' => ['required', new PasswordChecker($request->email)],
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }
        
        $dataId = "";
        $dataEmail = "";
        $dataNama = "";
        $dataJabatan = "";
        $dataUser = new User();
        $userDitemukan = $dataUser->getDataUsersByEmail($request->email);

        foreach ($userDitemukan as $key) {
            $dataId = $key->id;
            $dataEmail = $key->email;
            $dataNama = $key->name;
            $dataJabatan = $key->jabatan;
        }
        if($dataEmail != ""){
            $response = [
                'status' => 200,
                'success'=> true,
                'message'=> 'Data Ditemukan',
                'data'   => [
                    'id' => $dataId,
                    'email'=> $dataEmail,
                    'nama' => $dataNama,
                    'jabatan' => $dataJabatan,
                ]
            ];
            return response()->json($response, 200);
        }
    }
}   
