<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardSlideController extends Controller
{
    public function index()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.slide.index', [
            'title' => 'Slide',
            'slide' => Slide::all()
        ]);
    }

    public function create()
    {
        Session::put('index', request()->fullUrl());
        return view('backend.slide.create', [
            'title' => 'Tambah Slide'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|file|max:2048',
            'keterangan' => 'max:50|nullable'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('slide');
        }

        Slide::create($validatedData);

        return redirect('/dashboard/slide')->with('berhasil', 'Slide has been added!');
    }

    public function update(Request $request, Slide $slide)
    {

        $rules = [
            'image' => 'image|file|max:2048',
            'keterangan' => 'max:50|nullable'
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('slide');
        }

        Slide::where('id', $slide->id)->update($validatedData);

        return redirect('/dashboard/slide')->with('berhasil', $request->keterangan . " has been updated!");
    }

    public function destroy(Slide $slide)
    {
        Slide::destroy($slide->id);

        return redirect('/dashboard/slide')->with('berhasil', "Slide has been deleted!");
    }
}
