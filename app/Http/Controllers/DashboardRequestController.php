<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class DashboardRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.request.index', [
            'title' => 'Request Kurir',
            'requests' => Package::latest()->where('selesai', 0)->where('terima', 0)->filter(request(['search']))->paginate(20)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.request.create', [
            'title' => 'Request Kurir',
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
        $nomor = Str::of($request->no_hp)->ltrim('0');

        $validatedData = $request->validate([
            'namapemohon' => 'required|min:3|max:25',
            'telepon' => 'required|digits_between:8,15|numeric',
            'namapenerima' => 'required|min:3|max:25',
            'no_hp' => 'required|digits_between:8,15|numeric',
            'nama' => 'required|min:3|max:25',
            'jumlah' => 'required|numeric|min:1',
            'alamat' => 'required|min:5|max:100',
            'keterangan' => 'nullable|max:50',
            'shipping_id' => 'required|numeric|min:1',
            'hargapaket' => 'required|numeric|min:0',
            'cod' => 'numeric'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $validatedData['no_hp'] = $nomor;

        Package::create($validatedData);

        return redirect('/dashboard/permintaan')->with('berhasil', "Request " . $request->nama . " has been created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function show(Package $permintaan)
    {
        Session::put('permintaan', request()->fullUrl());
        return view('backend.request.show', [
            'title' => "Request Kurir Paket",
            'request' => $permintaan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $permintaan)
    {
        return view('backend.request.edit', [
            'title' => " Ubah Permintaan Paket ",
            'shipping' => Shipping::all(),
            'request' => $permintaan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $permintaan)
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
            'keterangan' => 'nullable|max:100',
            'shipping_id' => 'required|numeric|min:1',
            'hargapaket' => 'required|numeric|min:0'
        ];

        if (isset($request->cod)) {
            if ($request->cod != $permintaan) {
                $rules['cod'] = 'required';
            }

            $validatedData = $request->validate($rules);

            $validatedData['no_hp'] = $nomor;

            Package::where('id', $permintaan->id)->where('user_id', $permintaan->user_id)->update($validatedData);

            return redirect(session('permintaan'))->with('berhasil', "Request " . $permintaan->nama . " has been updated!");
        } else {
            $request->merge([
                'cod' => 0
            ]);

            if ($request->cod != $permintaan->cod) {
                $rules['cod'] = 'required';
            }

            $validatedData = $request->validate($rules);

            $validatedData['no_hp'] = $nomor;

            Package::where('id', $permintaan->id)->where('user_id', $permintaan->user_id)->update($validatedData);

            return redirect(session('permintaan'))->with('berhasil', "Request " . $permintaan->nama . " has been updated!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $permintaan)
    {
        Package::destroy($permintaan->id);

        return redirect(session('index'))->with('berhasil', "Request Package " . $permintaan->nama . " has been deleted!");
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Package::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);
    }

    public function terima(Request $request, Package $terima)
    {
        $validatedData = $request->validate([
            'terima' => 'required|min:1|max:1',
            'slug' => 'required|unique:packages'
        ]);

        if ($terima->author->is_admin) {
            $validatedData['diambil'] = true;
        }

        Package::where('id', $terima->id)->where('user_id', $terima->user_id)->update($validatedData);

        return redirect(session('index'))->with('berhasil', "Request " . $terima->nama . " has been accepted!");
    }
}
