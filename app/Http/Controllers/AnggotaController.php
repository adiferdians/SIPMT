<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::orderByDesc('id')->paginate(10);

        return view('content.anggota.anggota', [
            'anggota' => $anggota
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAnggota()
    {
        return view("content.anggota.createAnggota");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama'   => 'required',
            'nip'   => 'required',
            'telepon'   => 'required',
            'status'   => 'required',
            'role'   => 'required',
            'pangkat'   => 'required',
            'jk'   => 'required',
            'jabatan'   => 'required',
            'email'   => 'required',
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
// dd($request->all());
        DB::beginTransaction();
        try {
            $data = [
                'nama' => $request->nama,
                'nip' => $request->nip,
                'telepon' => $request->telepon,
                'status' => $request->status,
                'role' => $request->role,
                'pangkat_golongan' => $request->pangkat,
                'jk' => $request->jk,
                'email' => $request->email,
                'jabatan' => $request->jabatan,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];

            $request->id ? Anggota::where('id', $request->id)->update($data) : Anggota::insert($data);
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
    public function showAnggota($id)
    {
        $anggota = Anggota::where('id', $id)->get();
        return view('content.anggota.viewAnggota', [
            'anggota' => $anggota
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editAnggota($id)
    {
        $anggota = Anggota::where('id', $id)->get();
        return view('content.anggota.updateAnggota', [
            'anggota' => $anggota
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAnggota($id)
    {
        $data = new Anggota();
        $data->where('id', $id)->delete();
    }
}
