<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DashboardRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('Index', request()->fullUrl());
        return view('backend.registration.index', [
            'title' => 'Registration',
            'partners' => User::where('is_admin', 0)->where('diterima', 0)->where('is_mitra', 0)->latest()->filter(request(['search']))->paginate(20)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(User $registration)
    {
        Session::put('registrasi', request()->fullUrl());
        return view('backend.registration.show', [
            'title' => 'Partner',
            'partner' => $registration
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(User $registration)
    {
        return view('backend.registration.edit', [
            'title' => 'Edit',
            'partner' => $registration,
            'partners' => Partner::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $registration)
    {
        Validator::extend('tanpa_spasi', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $nomor = Str::of($request->no_hp)->ltrim('0');
        $rules = [
            'partner_id' => 'required',
            'name' => 'required|max:255',
            'no_hp' => ['required', 'digits_between:8,15', 'numeric'],
            'ktp_sim' => 'required|digits:16|numeric',
            'email' => 'required|email:dns',
            'username' => 'required|min:8|tanpa_spasi',
            'image' => 'image|file|max:2024'
        ];

        if ($request->slug != $registration->slug) {
            $rules['slug'] = 'required|unique:users';
        }

        // Keterangan Koding
        // Apabila request is_mitra ada/telah ditekan(checkbox di tekan) dan akan menghasilkan nilai true (1), pertama di cek terlebih dahulu. apakah nilainya sama seperti yang ada
        // Jika beda.. rules is_mitra akan aktif
        // Jika tidak ada request is_mitra, maka otomatis nilainya adalah 0, menggunakan collect merge untuk mengubah nilainya.
        // lalu di cek kembali. jika nilainya berbeda. maka rules is_mitra aktif
        if (isset($request->is_mitra)) {
            $rules2 = [
                'user_id' => 'required'
            ];

            if ($request->is_mitra != $registration->is_mitra) {
                $rules['is_mitra'] = 'required';
            }

            $validatedData = $request->validate($rules);
            $validatedData2 = $request->validate($rules2);

            $validatedData['no_hp'] = $nomor;
            $validatedData['diterima'] = 1;

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('mitra-images');
            }

            Account::create($validatedData2);
            User::where('id', $registration->id)->update($validatedData);

            return redirect('/dashboard/partner')->with('berhasil', "User " . $validatedData['name'] . " has been added!");
        } else {
            $request->merge([
                'is_mitra' => 0
            ]);
            if ($request->is_mitra != $registration->is_mitra) {
                $rules['is_mitra'] = 'required';
            }

            $validatedData = $request->validate($rules);

            $validatedData['no_hp'] = $nomor;

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('mitra-images');
            }

            User::where('id', $registration->id)->update($validatedData);

            return redirect(session('Index'))->with('berhasil', "User " . $validatedData['name'] . " has been updated!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $registration)
    {
        User::destroy($registration->id);

        return redirect(session('Index'))->with('berhasil', "User " . $registration['name'] . " has been deleted!");
    }
}
