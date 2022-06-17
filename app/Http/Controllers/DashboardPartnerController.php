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

class DashboardPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('Index', request()->fullUrl());
        return view('backend.partner.index', [
            'title' => 'Partner',
            'partners' => User::where('is_admin', 0)->where('diterima', 1)->latest()->filter(request(['search']))->paginate(20)->withQueryString()
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
     * @param  \App\Models\User  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(User $partner)
    {
        Session::put('partner', request()->fullUrl());
        return view('backend.partner.show', [
            'title' => 'Partner',
            'partner' => $partner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(User $partner)
    {
        return view('backend.partner.edit', [
            'title' => 'Edit',
            'partner' => $partner,
            'partners' => Partner::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $partner)
    {
        Validator::extend('tanpa_spasi', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $nomor = Str::of($request->no_hp)->ltrim('0');
        $nomor2 = Str::of($request->wa)->ltrim('0');

        $rules = [
            'partner_id' => 'required',
            'name' => 'required|max:255',
            'no_hp' => ['required', 'digits_between:8,15', 'numeric'],
            'ktp_sim' => 'required|digits:16|numeric',
            'email' => 'required|email:dns',
            'username' => 'required|min:8|tanpa_spasi',
            'image' => 'image|file|max:2048'
        ];

        $rules2 = [
            'wa' => 'nullable|numeric|digits_between:8,15',
            'ig' => 'nullable',
            'fb' => 'nullable',
            'alamat' => 'nullable',
            'jenistoko' => 'nullable'
        ];

        if ($request->slug != $partner->slug) {
            $rules['slug'] = 'required|unique:users';
        }

        if ($request->no_hp != $partner->no_hp) {
            $rules['no_hp'] = ['required', 'digits_between:8,15', 'numeric', 'unique:users'];
        }

        if ($request->username != $partner->username) {
            $rules['username'] = 'required|min:8|unique:users|tanpa_spasi';
        }

        if ($request->wa != $partner->account->wa) {
            $rules2['wa'] = ['required', 'digits_between:8,15', 'numeric', 'unique:accounts'];
        }

        if ($request->ig != $partner->account->ig) {
            $rules2['ig'] = 'required|unique:accounts';
        }

        if ($request->fb != $partner->account->fb) {
            $rules2['fb'] = 'required|unique:accounts';
        }

        if ($request->alamat != $partner->account->alamat) {
            $rules2['alamat'] = 'required';
        }
        if ($request->jenistoko != $partner->account->jenistoko) {
            $rules2['jenistoko'] = 'required';
        }

        // Keterangan Koding
        // Apabila request is_mitra ada/telah ditekan(checkbox di tekan) dan akan menghasilkan nilai true (1), pertama di cek terlebih dahulu. apakah nilainya sama seperti yang ada
        // Jika beda.. rules is_mitra akan aktif
        // Jika tidak ada request is_mitra, maka otomatis nilainya adalah 0, menggunakan collect merge untuk mengubah nilainya.
        // lalu di cek kembali. jika nilainya berbeda. maka rules is_mitra aktif
        if (isset($request->is_mitra)) {
            if ($request->is_mitra != $partner->is_mitra) {
                $rules['is_mitra'] = 'required';
            }

            $validatedData = $request->validate($rules);
            $validatedData2 = $request->validate($rules2);

            $validatedData['no_hp'] = $nomor;
            $validatedData2['wa'] = $nomor2;

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('mitra-images');
            }

            User::where('id', $partner->id)->update($validatedData);
            Account::where('user_id', $partner->id)->update($validatedData2);

            return redirect(session('Index'))->with('berhasil', "User " . $validatedData['name'] . " has been updated!");
        } else {
            $request->merge([
                'is_mitra' => 0
            ]);
            if ($request->is_mitra != $partner->is_mitra) {
                $rules['is_mitra'] = 'required';
            }

            $validatedData = $request->validate($rules);
            $validatedData2 = $request->validate($rules2);

            $validatedData['no_hp'] = $nomor;
            $validatedData2['wa'] = $nomor2;

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('mitra-images');
            }

            User::where('id', $partner->id)->update($validatedData);
            Account::where('user_id', $partner->id)->update($validatedData2);

            return redirect(session('Index'))->with('berhasil', "User " . $validatedData['name'] . " has been deactivited!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $partner)
    {
        User::destroy($partner->id);
        Account::where('user_id', $partner->id)->delete();

        return redirect(session('Index'))->with('berhasil', "User " . $partner['name'] . " has been deleted!");
    }
}
