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
        $dalamProses = Risalah::whereIn('status', ['Perekaman', 'Pengeditan', 'Transkripsi'])->count();
        $selesai = Risalah::where('status', 'Risalah OK')
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

            // 2. Tentukan warna berdasarkan status (sesuai kartu statistik Anda)
            $color = '#777777'; // Warna default (abu-abu)
            $textColor = '#fff'; // Teks putih

            if ($risalah->status == 'Belum Terlaksana') {
                // Biru (dari card-dark-blue)
                $color = '#0d6efd';
            } elseif (in_array($risalah->status, ['Perekaman', 'Risalah Sementara', 'Transkripsi'])) {
                // Kuning (dari card-warning)
                $color = '#ffc107';
                $textColor = '#000'; // Teks hitam agar terbaca di kuning
            } elseif ($risalah->status == 'Risalah Validasi') {
                // Hijau (dari card-success)
                $color = '#198754';
            }

            $events[] = [
                // TAMBAHKAN 'id' DI SINI
                'id'    => $risalah->id,

                'title' => $risalah->rapat, // Asumsi nama kolom
                'start' => $risalah->tgl, // Asumsi nama kolom

                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => $textColor
            ];
        }

        return response()->json($events);
    }
}
