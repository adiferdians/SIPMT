<?php

namespace App\Http\Controllers;

use App\Models\Risalah;
use Illuminate\Http\Request;
use Carbon\Carbon;
class RisalahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Carbon::setLocale('id');
        $risalah = Risalah::orderByDesc('id')->paginate(10);
        return view('content.risalah.risalah', [
            'risalah' => $risalah
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showRisalah($id)
    {
        $risalah = Risalah::where('id', $id)->get();
        return view('content.risalah.viewRisalah', [
            'risalah' => $risalah
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Risalah $risalah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Risalah $risalah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyRisalah($id)
    {
        $data = new Risalah();
        $data->where('id', $id)->delete();
    }
}
