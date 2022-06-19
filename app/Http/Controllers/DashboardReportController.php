<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardReportController extends Controller
{
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.report.index', [
            'title' => 'Laporan',
            'paket' => Package::where('terima', true)->where('diambil', true)->where('selesai', true)->latest()->paginate(20)->withQueryString()
        ]);
    }
}
