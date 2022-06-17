<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Package;
use App\Models\PickUp;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('frontend.tracking.index', [
            'title' => 'Tracking',
            'packages' => Package::where('terima', 1)->filter(request(['search']))->get()
        ]);
    }

    public function show(Package $tracking)
    {
        return view('frontend.tracking.show', [
            'title' => $tracking->nama,
            'package' => $tracking,
            'courier' => Courier::all()->where('id', $tracking->courier_id)->first(),
            'pickup' => PickUp::all()->where('id', $tracking->pick_up_id)->first()
        ]);
    }
}
