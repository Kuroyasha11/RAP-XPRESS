<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Package;
use App\Models\PickUp;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DashboardDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.delivery.index', [
            'title' => 'Request Kurir',
            'requests' => Package::latest()->where('terima', 1)->filter(request(['search']))->paginate(20)->withQueryString()
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
     * @param  \App\Models\Package  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function show(Package $pengiriman)
    {
        Session::put('permintaan', request()->fullUrl());
        return view('backend.delivery.show', [
            'title' => "Request Kurir Paket",
            'request' => $pengiriman,
            'courier' => Courier::all()->where('id', $pengiriman->courier_id)->first(),
            'pickup' => PickUp::all()->where('id', $pengiriman->pick_up_id)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $pengiriman)
    {
        if ($pengiriman->terima == 1 && $pengiriman->selesai == 0) {
            return view('backend.delivery.edit', [
                'title' => " Ubah Permintaan Paket",
                'shipping' => Shipping::all(),
                'request' => $pengiriman
            ]);
        } else {
            return redirect(session('index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $pengiriman)
    {
        $nomor = Str::of($request->no_hp)->ltrim('0');

        $rules = [
            'namapemohon' => 'required|min:3|max:25',
            'telepon' => 'required|digits_between:8,15|numeric',
            'namapenerima' => 'required|min:3|max:25',
            'no_hp' => 'required|digits_between:8,15|numeric',
            'nama' => 'required|min:3|max:25',
            'jumlah' => 'required|numeric|min:1',
            'alamat' => 'required|min:5|max:100',
            'keterangan' => 'nullable|max:50',
            'shipping_id' => 'required|numeric|min:1',
            'hargapaket' => 'required|numeric|min:0'
        ];

        if (isset($request->cod)) {
            if ($request->cod != $pengiriman->cod) {
                $rules['cod'] = 'required';
            }

            $validatedData = $request->validate($rules);

            $validatedData['no_hp'] = $nomor;

            Package::where('id', $pengiriman->id)->where('user_id', $pengiriman->user_id)->update($validatedData);

            return redirect(session('permintaan'))->with('berhasil', "Request " . $pengiriman->nama . " has been updated!");
        } else {
            $request->merge([
                'cod' => 0
            ]);

            if ($request->cod != $pengiriman->cod) {
                $rules['cod'] = 'required';
            }

            $validatedData = $request->validate($rules);

            $validatedData['no_hp'] = $nomor;

            Package::where('id', $pengiriman->id)->where('user_id', $pengiriman->user_id)->update($validatedData);

            return redirect(session('permintaan'))->with('berhasil', "Request " . $pengiriman->nama . " has been updated!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $pengiriman)
    {
        Package::destroy($pengiriman->id);

        return redirect(session('index'))->with('berhasil', "Delivery " . $pengiriman->nama . " has been deleted!");
    }
}
