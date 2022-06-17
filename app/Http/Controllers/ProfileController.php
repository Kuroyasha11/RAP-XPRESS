<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show(User $profile)
    {
        Session::put('profile', request()->fullUrl());
        return view('backend.profile.show', [
            'title' => 'Profile',
            'profile' => $profile
        ]);
    }

    public function update(Request $request, User $profile)
    {
        Validator::extend('tanpa_spasi', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $nomor = Str::of($request->no_hp)->ltrim('0');
        $nomor2 = Str::of($request->wa)->ltrim('0');

        $rules = [
            'name' => 'required|max:255',
            'no_hp' => ['required', 'digits_between:8,15', 'numeric'],
            // 'username' => 'required|min:8|tanpa_spasi',
            'image' => 'image|file|max:2048',
            // 'password' => 'min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
        ];

        $rules2 = [
            'wa' => 'nullable|numeric|digits_between:8,15',
            'ig' => 'nullable',
            'fb' => 'nullable',
            'alamat' => 'required',
            'jenistoko' => 'required'
        ];

        if (!$request->alamat) {
            return redirect(session('profile'))->with('gagal', 'alamat tidak boleh kosong');
        }
        if (!$request->jenistoko) {
            return redirect(session('profile'))->with('gagal', 'jenis toko tidak boleh kosong');
        }

        if ($request->slug != $profile->slug) {
            $rules['slug'] = 'required|unique:users';
        }

        if ($request->no_hp != $profile->no_hp) {
            $rules['no_hp'] = ['required', 'digits_between:8,15', 'numeric', 'unique:users'];
        }

        // if ($request->username != $profile->username) {
        //     $rules['username'] = 'required|min:8|unique:users|tanpa_spasi';
        // }

        if ($request->wa != $profile->account->wa) {
            $rules2['wa'] = ['required', 'digits_between:8,15', 'numeric', 'unique:accounts'];
        }

        if ($request->ig != $profile->account->ig) {
            $rules2['ig'] = 'required|unique:accounts';
        }

        if ($request->fb != $profile->account->fb) {
            $rules2['fb'] = 'required|unique:accounts';
        }

        $validatedData = $request->validate($rules);
        $validatedData2 = $request->validate($rules2);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('mitra-images');
        }

        // $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['no_hp'] = $nomor;
        $validatedData2['wa'] = $nomor2;

        $cekaccount = Account::where('user_id', auth()->user()->id);
        if ($cekaccount) {
            Account::where('user_id', auth()->user()->id)->update($validatedData2);
        } else {
            Account::created($validatedData2);
        }

        User::where('id', $profile->id)->update($validatedData);

        return redirect('/dashboard')->with('berhasil', 'Profile has been updated!');
    }

    public function password(User $password)
    {
        Session::put('password', request()->fullUrl());
        return view('backend.profile.password', [
            'title' => 'Ubah Password',
            'password' => $password
        ]);
    }

    public function change(Request $request, User $password)
    {
        if (Hash::check($request->old_password, $password->password)) {
            $rules = [
                'password' => 'required|min:8|confirmed'
            ];

            $validatedData = $request->validate($rules);

            $validatedData['password'] = Hash::make($validatedData['password']);

            User::where('id', $password->id)->update($validatedData);

            return redirect('/dashboard')->with('berhasil', 'Password has been updated!');
        } else {
            return redirect(session('password'))->with('gagal', 'Old passwords are not the same!');
        }
    }
}
