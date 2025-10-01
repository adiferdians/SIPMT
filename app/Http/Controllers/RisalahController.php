<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Risalah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RisalahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $risalah = Risalah::orderByDesc('id')->paginate(10);
        return view('content.risalah.risalah', [
            'risalah' => $risalah
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createRisalah()
    {
        $anggota = Anggota::orderBy('nama')->get();
        return view('content.risalah.createRisalah', [
            'anggota' => $anggota
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'unit_kerja'   => 'required',
            'tgl'   => 'required',
            'jam'   => 'required',
            'tempat'   => 'required',
            'perekam_1'   => 'required',
            'rapat'   => 'required',
            'agenda'   => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'Validation Vailed!!',
                    'details' => $validate->errors()->all()
                ]
            ], 422);
        }
        DB::beginTransaction();
        try {
            $data = [
                'unit_kerja' => $request->unit_kerja,
                'tgl' => $request->tgl,
                'jam' => $request->jam,
                'tempat' => $request->tempat,
                'perekam_1' => $request->perekam_1,
                'perekam_2' => $request->perekam_2,
                'editor' => $request->editor,
                'rapat' => $request->rapat,
                'agenda' => $request->agenda,
                'status' => $request->status ? $request->status : "Belum Terlaksana",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];

            $request->id ? Risalah::where('id', $request->id)->update($data) : Risalah::insert($data);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Data berhasil diinputkan', 'data' => $data], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['success' => false, 'messages' => $e->getMessage()], 400);
        }
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
    public function editRisalah($id)
    {
        $anggota = Anggota::where('id', $id)->get();
        $risalah = Risalah::where('id', $id)->get();
        return view('content.risalah.editRisalah', [
            'anggota' => $anggota, 
            'risalah' => $risalah
        ]);
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
