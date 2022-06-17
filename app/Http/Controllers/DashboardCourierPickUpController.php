<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PickUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardCourierPickUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.courier_pickup.index', [
            'title' => 'Pengambilan Paket',
            'pickup' => PickUp::where('user_id', auth()->user()->id)->latest()->filter(request(['search']))->paginate(20)->withQueryString()
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
     * @param  \App\Models\PickUp  $pengambilan_paket
     * @return \Illuminate\Http\Response
     */
    public function show(PickUp $pengambilan_paket)
    {
        Session::put('cek', request()->fullUrl());
        return view('backend.courier_pickup.show', [
            'title' => "Cek " . $pengambilan_paket->nama,
            'pickup' => $pengambilan_paket,
            'packages' => Package::where('terima', 1)->where('pick_up_id', $pengambilan_paket->id)->get(),
            'paket' => Package::all()->where('terima', 1)->whereNull('pick_up_id')->whereNull('courier_id')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PickUp  $pengambilan_paket
     * @return \Illuminate\Http\Response
     */
    public function edit(PickUp $pengambilan_paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PickUp  $pengambilan_paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PickUp $pengambilan_paket)
    {
        $validatedData = $request->validate([
            'titik2' => 'required'
        ]);
        $cek = Package::all()->where('pick_up_id', $pengambilan_paket->id);
        foreach ($cek as $c) {
            if ($c->diambil == 0) {
                return redirect(session('cek'))->with('gagal', "Barang masih ada yang belum diambil!");
            }
        }

        PickUp::where('id', $pengambilan_paket->id)->update($validatedData);

        return redirect(session('cek'))->with('berhasil', "Kurir Pick Up " . $pengambilan_paket->nama . " telah selesai, silahkan bawa paketnya ke kantor!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PickUp  $pengambilan_paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(PickUp $pengambilan_paket)
    {
        //
    }

    public function paket(Package $paket)
    {
        Session::put('paket', request()->fullUrl());
        return view('backend.courier_pickup.paket', [
            'title' => "Cek " . $paket->nama,
            'paket' => $paket,
            'pickup' => PickUp::all()->where('id', $paket->pick_up_id)->first(),
            'user' => User::all()->where('id', $paket->user_id)->first()
        ]);
    }

    public function selesai(Request $request, Package $paket)
    {
        if ($request->file('foto')) {
            $validatedData = $request->validate([
                'diambil' => 'required',
                'foto' => 'required|image|file|max:2048',
            ]);

            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['foto'] = $request->file('foto')->store('paket-foto');

            Package::where('id', $paket->id)->update($validatedData);

            return redirect(session('paket'))->with('berhasil', "Package " . $paket->nama . " has been finished!");
        } else {
            return redirect(session('paket'))->with('gagal', "Masukkan foto bukti paket telah diambil dari Olshop!!");
        }
    }
}
