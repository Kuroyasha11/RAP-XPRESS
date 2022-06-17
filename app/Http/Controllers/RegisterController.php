<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'partners' => Partner::all()
        ]);
    }

    public function store(Request $request)
    {
        $nomor = Str::of($request->no_hp)->ltrim('0');

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'no_hp' => ['required', 'unique:users', 'digits_between:8,15', 'numeric'],
            'ktp_sim' => 'required|unique:users|digits:16|numeric',
            'slug' => 'required|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'min:8|max:255',
            'partner_id' => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['no_hp'] = $nomor;

        User::create($validatedData);

        return redirect('/register')->with('berhasil', 'Pendaftaran telah berhasil, silahkan siapkan data - data yang dibutuhkan dan bawa ke kantor RAP-XPRESS.');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(User::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
