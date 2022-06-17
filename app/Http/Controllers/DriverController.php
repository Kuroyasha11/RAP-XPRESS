<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.kurir.index', [
            'title' => 'Driver',
            'drivers' => User::where('partner_id', 1)->where('is_admin', 0)->where('is_mitra', 1)->latest()->filter(request(['search']))->paginate(12)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return ;
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \App\Http\Requests\StoreDriverRequest  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(StoreDriverRequest $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|min:3|max:255',
    //         'email' => ['required', 'email:dns', 'unique:drivers'],
    //         'no_hp' => ['required', 'unique:drivers', 'digits:10', 'numeric'],
    //         'ktp_sim' => 'required|unique:drivers|digits:10|numeric',
    //         'slug' => 'required|unique:drivers',
    //         'image' => 'image|file|max:2048'
    //     ]);

    //     if ($request->file('image')) {
    //         $validatedData['image'] = $request->file('image')->store('mitra-image');
    //     }

    //     Driver::create($validatedData);

    //     return redirect('/kurir')->with('success', 'New post has been added!');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $kurir
     * @return \Illuminate\Http\Response
     */
    public function show(User $kurir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $kurir
     * @return \Illuminate\Http\Response
     */
    // public function edit(Driver $kurir)
    // {
    //     return view('frontend.kurir.edit', [
    //         'title' => "Ubah Data"
    //     ]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \App\Http\Requests\UpdateDriverRequest  $request
    //  * @param  \App\Models\Driver  $kurir
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(UpdateDriverRequest $request, Driver $kurir)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Driver  $kurir
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Driver $kurir)
    // {
    //     //
    // }

    // berfungsi sebagai pembatas, siapa saja yang dapat melihat resource controller ini.
    // yang tidak login hanya dapat melihat index dan show. begitu jug sebaliknya
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['index', 'show', 'create', 'store']]);
    // }
}
