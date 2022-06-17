<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Package;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardCourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.courier.index', [
            'title' => 'Kurir',
            'couriers' => Courier::latest()->filter(request(['search']))->paginate(20)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.courier.create', [
            'title' => 'Buat Kurir Pengiriman',
            'users' => User::all()->where('is_mitra', 1)->where('partner_id', 1)->where('diterima', 1),
            'shipping' => Shipping::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'user_id' => 'required|numeric|min:1',
            'alamat' => 'required'
        ]);

        Courier::create($validatedData);

        return redirect('/dashboard/kurir')->with('berhasil', "Delivery Courier " . $request->nama . " has been created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Courier  $kurir
     * @return \Illuminate\Http\Response
     */
    public function show(Courier $kurir)
    {
        Session::put('kurir', request()->fullUrl());
        return view('backend.courier.show', [
            'title' => "Paket " . $kurir->nama,
            'kurir' => $kurir,
            'packages' => Package::where('courier_id', $kurir->id)->where('terima', 1)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Courier  $kurir
     * @return \Illuminate\Http\Response
     */
    public function edit(Courier $kurir)
    {
        return view('backend.courier.edit', [
            'title' => 'Ubah Kurir Pengiriman',
            'kurir' => $kurir,
            'users' => User::all()->where('is_mitra', 1)->where('partner_id', 1)->where('diterima', 1),
            'shipping' => Shipping::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Courier  $kurir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Courier $kurir)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'user_id' => 'required|numeric|min:1',
            'alamat' => 'required'
        ]);

        Courier::where('id', $kurir->id)->update($validatedData);

        return redirect(session('kurir'))->with('berhasil', "Delivery Courier " . $request->nama . " has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Courier  $kurir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Courier $kurir)
    {
        Courier::destroy($kurir->id);

        return redirect(session('index'))->with('berhasil', "Delivery " . $kurir->nama . " has been deleted!");
    }

    public function paket(Courier $paket)
    {
        Session::put('paket', request()->fullUrl());
        return view('backend.courier.paket', [
            'title' => "Courier " . $paket->nama,
            'kurir' => $paket,
            'packages' => Package::where('terima', 1)->where('courier_id', $paket->id)->get(),
            'paket' => Package::all()->where('terima', 1)->where('diambil', 1)->where('selesai', 0)->whereNull('courier_id')
        ]);
    }

    public function tambahpaket(Request $request, Courier $paket)
    {
        if ($request->id) {
            Package::where('id', $request->id)->update(['courier_id' => $paket->id]);

            return redirect(session('paket'))->with('berhasil', "Package has been added!");
        } else {
            return redirect(session('paket'))->with('gagal', "There is no package!");
        }
    }

    public function hapuspaket(Package $delete)
    {

        Package::where('id', $delete->id)->update(['courier_id' => null]);

        return redirect(session('paket'))->with('berhasil', "Package has been deleted!");
    }

    public function terimakurir(Request $request, Courier $kurir)
    {
        $cekpaket = Package::where('courier_id', $kurir->id)->where('diambil', 1)->where('selesai', 0)->get();
        if ($cekpaket->count()) {
            $validatedData = $request->validate([
                'titik1' => 'required'
            ]);

            Courier::where('id', $kurir->id)->update($validatedData);

            return redirect(session('paket'))->with('berhasil', "Delivery Courier " . $kurir->nama . " has been updated!");
        } else {
            return redirect(session('paket'))->with('gagal', "Tidak ada paket atau Paket telah ada yang selesai!");
        }
    }

    public function selesai(Request $request, Courier $selesai)
    {
        $validatedData = $request->validate([
            'selesai' => 'required'
        ]);

        Courier::where('id', $selesai->id)->update($validatedData);

        return redirect('/dashboard/kurir')->with('berhasil', "Delivery Courier " . $selesai->nama . " has been finished!");
    }
}
