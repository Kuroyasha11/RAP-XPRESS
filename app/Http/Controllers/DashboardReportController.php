<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardReportController extends Controller
{
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.report.index', [
            'title' => 'Laporan',
        ]);
    }
}
