<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;

class OlshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.olshop.index', [
            'title' => 'Olshop',
            'online_shop' => User::where('partner_id', 2)->where('is_admin', 0)->where('is_mitra', 1)->latest()->filter(request(['search']))->paginate(12)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $online_shop
     * @return \Illuminate\Http\Response
     */
    public function show(User $online_shop)
    {
        return view('frontend.olshop.show', [
            'title' => 'Olshop',
            'olshop' => $online_shop,
            'packages' => Package::where('user_id', $online_shop->id)->where('terima', 1)->latest()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $online_shop
     * @return \Illuminate\Http\Response
     */
    // public function edit(User $online_shop)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\User  $online_shop
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, User $online_shop)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\User  $online_shop
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(User $online_shop)
    // {
    //     //
    // }
}
