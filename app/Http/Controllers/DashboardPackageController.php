<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Package;
use App\Models\PickUp;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class DashboardPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.package.index', [
            'title' => 'Paket',
            'packages' => Package::where('user_id', auth()->user()->id)->latest()->filter(request(['search']))->paginate(20)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.package.create', [
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

        if (auth()->user()->partner_id == 2) {
            $user = User::where('id', auth()->user()->id)->first();
            if (!$user->account->alamat || !$user->account->wa || !$user->account->jenistoko) {
                return redirect('/dashboard/profile/' . auth()->user()->slug)->with('gagal', 'Silahkan lengkapi profil anda!');
            } else {
                $validatedData = $request->validate([
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

                $validatedData['namapemohon'] = auth()->user()->name;

                $validatedData['telepon'] = auth()->user()->no_hp;

                Package::create($validatedData);

                return redirect('/dashboard/paket')->with('berhasil', "Request " . $request->nama . " has been successed!");
            }
        } else {
            User::where('id', auth()->user()->id)->update(['is_mitra' => false]);
            return redirect('/dashboard')->with('gagal', "KAMU TELAH MENCOBA HACK WEBSITE INI, AKUN MU AKAN DIBEKUKAN!!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $paket
     * @return \Illuminate\Http\Response
     */
    public function show(Package $paket)
    {
        Session::put('paket', request()->fullUrl());
        return view('backend.package.show', [
            'title' => "Paket " . $paket->nama,
            'package' => $paket,
            'courier' => Courier::all()->where('id', $paket->courier_id)->first(),
            'pickup' => PickUp::all()->where('id', $paket->pick_up_id)->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $paket
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $paket)
    {
        if ($paket->terima == 0 && $paket->selesai == 0) {
            return view('backend.package.edit', [
                'title' => " Ubah Paket",
                'shipping' => Shipping::all(),
                'package' => $paket
            ]);
        } else {
            return redirect(session('index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $paket)
    {
        $nomor = Str::of($request->no_hp)->ltrim('0');

        if (auth()->user()->partner_id == 2) {
            $rules = [
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
                if ($request->cod != $paket->cod) {
                    $rules['cod'] = 'required';
                }

                $validatedData = $request->validate($rules);

                $validatedData['no_hp'] = $nomor;

                $validatedData['namapemohon'] = auth()->user()->name;

                $validatedData['telepon'] = auth()->user()->no_hp;

                Package::where('id', $paket->id)->where('user_id', $paket->user_id)->update($validatedData);

                return redirect(session('paket'))->with('berhasil', "Request " . $paket->nama . " has been updated!");
            } else {
                $request->merge([
                    'cod' => 0
                ]);

                if ($request->cod != $paket->cod) {
                    $rules['cod'] = 'required';
                }

                $validatedData = $request->validate($rules);

                $validatedData['no_hp'] = $nomor;

                $validatedData['namapemohon'] = auth()->user()->name;

                $validatedData['telepon'] = auth()->user()->no_hp;

                Package::where('id', $paket->id)->where('user_id', $paket->user_id)->update($validatedData);

                return redirect(session('paket'))->with('berhasil', "Request " . $paket->nama . " has been updated!");
            }
        } else {
            User::where('id', auth()->user()->id)->update(['is_mitra' => false]);
            return redirect('/dashboard')->with('gagal', "KAMU TELAH MENCOBA HACK WEBSITE INI, AKUN MU AKAN DIBEKUKAN!!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $paket)
    {
        if (auth()->user()->partner_id == 2) {
            Package::destroy($paket->id);

            return redirect(session('index'))->with('berhasil', "Package " . $paket->nama . " has been deleted!");
        } else {
            User::where('id', auth()->user()->id)->update(['is_mitra' => false]);
            return redirect('/dashboard')->with('gagal', "KAMU TELAH MENCOBA HACK WEBSITE INI, AKUN MU AKAN DIBEKUKAN!!");
        }
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Package::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);
    }

    public function resi(Package $resi)
    {
        $package = Package::all()->where('id', $resi->id)->first();
        $user = User::all()->where('id', $resi->user_id)->first();

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'times']);

        $pdf = PDF::loadView('backend.package.resi', compact([
            'package',
            'user'
        ]))->setPaper('a6', 'portrait');

        return $pdf->download($resi->slug . ".pdf");
    }
}
