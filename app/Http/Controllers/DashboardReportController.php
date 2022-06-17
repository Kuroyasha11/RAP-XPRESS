<?php

namespace App\Http\Controllers;

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
            'kurir' => User::where('is_mitra', true)->where('partner_id', 1)->where('diterima', true)->get()
        ]);
    }
}
