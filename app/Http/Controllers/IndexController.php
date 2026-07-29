<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Risalah;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        $risalah = Risalah::all();
        $cuti = Anggota::where('status', 'cuti')->count();
        $anggota = Anggota::count();
        $akanDatang = Risalah::whereDate('tgl', '=', Carbon::today())->count();
        $dalamProses = Risalah::whereIn('status', ['Perekaman', 'Rislah Sementara', 'Transkripsi'])->count();
        $selesai = Risalah::where('status', 'Risalah Validasi')
            ->where('tgl', '>=', Carbon::now()->subDays(30))
            ->count();
        return view('index', [
            'risalah' => $risalah,
            'cuti' => $cuti,
            'anggota' => $anggota,
            'akanDatang' => $akanDatang,
            'dalamProses' => $dalamProses,
            'selesai' => $selesai,
        ]);
    }

    public function getAgenda(Request $request)
    {
        $data = Risalah::whereBetween('tgl', [$request->start, $request->end])->get();
        $events = [];

        foreach ($data as $risalah) {

            $color = '#777777';
            $textColor = '#fff';

            if ($risalah->status == 'Belum Terlaksana') {
                $color = '#0d6efd';
            } elseif (in_array($risalah->status, ['Perekaman', 'Risalah Sementara', 'Transkripsi'])) {
                $color = '#ffc107';
                $textColor = '#000';
            } elseif ($risalah->status == 'Risalah Validasi') {
                $color = '#198754';
            }

            $events[] = [
                'id'    => $risalah->id,
                'title' => $risalah->rapat,
                'start' => $risalah->tgl,

                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => $textColor
            ];
        }

        return response()->json($events);
    }
}
