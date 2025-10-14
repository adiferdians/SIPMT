<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unit = UnitKerja::orderBy('id')->paginate(10);

        return view('content.unitKerja.unitKerja', [
            'unit' => $unit
        ]);
    }

    public function createUnitKerja()
    {
        return view("content.unitKerja.createUnitKerja");
    }

    public function storeUnitKerja(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'nama'   => 'required',
            'deskripsi'   => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'Validasi gagal!!',
                    'details' => $validate->errors()->all()
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            $data = [
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];

            $request->id ? UnitKerja::where('id', $request->id)->update($data) : UnitKerja::insert($data);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Data berhasil diinputkan', 'data' => $data], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['success' => false, 'messages' => $e->getMessage()], 400);
        }
    }

    public function editUnitKerja($id)
    {
        $unit = UnitKerja::where('id', $id)->get();
        return view('content.unitKerja.updateUnitKerja', [
            'unit' => $unit
        ]);
    }

    public function destroyUnitKerja($id)
    {
        $data = new UnitKerja();
        $data->where('id', $id)->delete();
    }
}
