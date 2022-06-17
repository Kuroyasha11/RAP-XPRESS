<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardCourierDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.courier_delivery.index', [
            'title' => 'Pengiriman Paket',
            'couriers' => Courier::where('user_id', auth()->user()->id)->latest()->filter(request(['search']))->paginate(20)->withQueryString()
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
     * @param  \App\Models\Courier  $pengiriman_paket
     * @return \Illuminate\Http\Response
     */
    public function show(Courier $pengiriman_paket)
    {
        Session::put('cek', request()->fullUrl());
        return view('backend.courier_delivery.show', [
            'title' => "Cek " . $pengiriman_paket->nama,
            'kurir' => $pengiriman_paket,
            'packages' => Package::where('terima', 1)->where('courier_id', $pengiriman_paket->id)->get(),
            'paket' => Package::all()->where('terima', 1)->whereNotNull('pick_up_id')->whereNull('courier_id')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Courier  $pengiriman_paket
     * @return \Illuminate\Http\Response
     */
    public function edit(Courier $pengiriman_paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Courier  $pengiriman_paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Courier $pengiriman_paket)
    {
        $validatedData = $request->validate([
            'titik2' => 'required'
        ]);
        $cek = Package::all()->where('courier_id', $pengiriman_paket->id);
        foreach ($cek as $c) {
            if ($c->selesai == 0) {
                return redirect(session('cek'))->with('gagal', "Barang masih ada yang belum diantar!");
            }
        }

        Courier::where('id', $pengiriman_paket->id)->update($validatedData);

        return redirect(session('cek'))->with('berhasil', "Kurir Pengantar " . $pengiriman_paket->nama . " telah selesai, silahkan datang ke kantor untuk laporan ke admin!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Courier  $pengiriman_paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Courier $pengiriman_paket)
    {
        //
    }

    public function paket(Package $paket)
    {
        Session::put('paket', request()->fullUrl());
        return view('backend.courier_delivery.paket', [
            'title' => "Cek " . $paket->nama,
            'paket' => $paket,
            'courier' => Courier::all()->where('id', $paket->courier_id)->first()
        ]);
    }

    public function selesai(Request $request, Package $paket)
    {
        if ($request->file('image')) {
            $validatedData = $request->validate([
                'selesai' => 'required',
                'image' => 'image|file|max:2048',
            ]);

            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('paket-images');

            Package::where('id', $paket->id)->update($validatedData);

            return redirect(session('paket'))->with('berhasil', "Package " . $paket->nama . " has been finished!");
        } else {
            return redirect(session('paket'))->with('gagal', "Masukkan foto bukti kostumer telah menerima paket!!");
        }
    }
}
