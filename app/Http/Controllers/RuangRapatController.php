<?php

namespace App\Http\Controllers;

use App\Models\RuangRapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RuangRapatController extends Controller
{
    public function index()
    {
        $ruang = RuangRapat::orderBy('id')->paginate(10);

        return view('content.ruangRapat.ruangRapat', [
            'ruang' => $ruang
        ]);
    }

    public function createRuangRapat()
    {
        return view("content.ruangRapat.createRuangRapat");
    }

    public function storeRuangRapat(Request $request, $id)
    {

        $validate = Validator::make($request->all(), [
            'nama'   => 'required',
            'lantai'   => 'required',
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
                'lantai' => $request->lantai,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];

            $request->id ? RuangRapat::where('id', $request->id)->update($data) : RuangRapat::insert($data);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Data berhasil diinputkan', 'data' => $data], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['success' => false, 'messages' => $e->getMessage()], 400);
        }
    }

    public function editRuangRapat($id)
    {
        $ruang = RuangRapat::where('id', $id)->get();
        return view('content.ruangRapat.updateRuangRapat', [
            'ruang' => $ruang
        ]);
    }

    public function destroyRuangRapat($id)
    {
        $data = new RuangRapat();
        $data->where('id', $id)->delete();
    }
}
