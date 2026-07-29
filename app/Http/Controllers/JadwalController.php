<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risalah;


class JadwalController extends Controller
{
    public function viewAllData(Request $request)
    {

        return view('content.dataTable.allData');
    }

    public function allData()
    {
        $data = Risalah::orderByDesc('tgl')->get();
        return response()->json($data);
    }
}
