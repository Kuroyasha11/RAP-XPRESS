<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tanggal1 && $request->tanggal2) {

            $dari = new Carbon($request->tanggal1);
            $ke = new Carbon($request->tanggal2);

            Session::put('index', request()->fullUrl());
            return view('backend.report.index', [
                'title' => 'Laporan',
                'paket' => Package::where('terima', true)
                    ->where('diambil', true)
                    ->where('selesai', true)
                    ->WhereBetween('created_at', [$dari, $ke])
                    ->latest()
                    ->paginate(20)
                    ->withQueryString()
            ]);
        } else {
            Session::put('index', request()->fullUrl());
            return view('backend.report.index', [
                'title' => 'Laporan',
                'paket' => Package::where('terima', true)->where('diambil', true)->where('selesai', true)->latest()->paginate(20)->withQueryString()
            ]);
        }
    }
}
