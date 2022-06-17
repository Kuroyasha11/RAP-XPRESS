<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PickUp;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardPickUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.pickup.index', [
            'title' => 'Kurir',
            'pickup' => PickUp::latest()->filter(request(['search']))->paginate(20)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pickup.create', [
            'title' => 'Buat Kurir Pengambilan Paket',
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

        PickUp::create($validatedData);

        return redirect('/dashboard/pickup')->with('berhasil', "Pick Up Courier " . $request->nama . " has been created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PickUp  $pickup
     * @return \Illuminate\Http\Response
     */
    public function show(PickUp $pickup)
    {
        Session::put('pickup', request()->fullUrl());
        return view('backend.pickup.show', [
            'title' => "Paket " . $pickup->nama,
            'pickup' => $pickup,
            'packages' => Package::where('pick_up_id', $pickup->id)->where('terima', 1)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PickUp  $pickup
     * @return \Illuminate\Http\Response
     */
    public function edit(PickUp $pickup)
    {
        return view('backend.pickup.edit', [
            'title' => 'Ubah Kurir Pengambilan Paket',
            'pickup' => $pickup,
            'users' => User::all()->where('is_mitra', 1)->where('partner_id', 1)->where('diterima', 1),
            'shipping' => Shipping::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PickUp  $pickup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PickUp $pickup)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'user_id' => 'required|numeric|min:1',
            'alamat' => 'required'
        ]);

        PickUp::where('id', $pickup->id)->update($validatedData);

        return redirect(session('pickup'))->with('berhasil', "Pick Up Courier " . $request->nama . " has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PickUp  $pickup
     * @return \Illuminate\Http\Response
     */
    public function destroy(PickUp $pickup)
    {
        PickUp::destroy($pickup->id);

        return redirect(session('index'))->with('berhasil', "Delivery " . $pickup->nama . " has been deleted!");
    }

    public function paket(PickUp $paket)
    {
        Session::put('paket', request()->fullUrl());
        return view('backend.pickup.paket', [
            'title' => "Courier " . $paket->nama,
            'pickup' => $paket,
            'packages' => Package::where('terima', 1)->where('pick_up_id', $paket->id)->get(),
            'paket' => Package::all()->where('terima', 1)->where('diambil', 0)->where('selesai', 0)->whereNull('pick_up_id')
        ]);
    }

    public function tambahpaket(Request $request, PickUp $paket)
    {
        if ($request->id) {
            Package::where('id', $request->id)->update(['pick_up_id' => $paket->id]);

            return redirect(session('paket'))->with('berhasil', "Package has been added!");
        } else {
            return redirect(session('paket'))->with('gagal', "There is no package!");
        }
    }

    public function hapuspaket(Package $delete)
    {

        Package::where('id', $delete->id)->update(['pick_up_id' => null]);

        return redirect(session('paket'))->with('berhasil', "Package has been deleted!");
    }

    public function terimakurir(Request $request, PickUp $kurir)
    {
        $cekpaket = Package::where('pick_up_id', $kurir->id)->where('diambil', 0)->where('selesai', 0)->get();
        if ($cekpaket->count()) {
            $validatedData = $request->validate([
                'titik1' => 'required'
            ]);

            PickUp::where('id', $kurir->id)->update($validatedData);

            return redirect(session('paket'))->with('berhasil', "Pick Up Courier " . $kurir->nama . " has been updated!");
        } else {
            return redirect(session('paket'))->with('gagal', "Tidak ada paket atau Paket telah ada yang selesai!");
        }
    }

    public function selesai(Request $request, PickUp $selesai)
    {
        $validatedData = $request->validate([
            'selesai' => 'required'
        ]);

        PickUp::where('id', $selesai->id)->update($validatedData);

        return redirect('/dashboard/pickup')->with('berhasil', "Pick Up Courier " . $selesai->nama . " has been finished!");
    }
}
