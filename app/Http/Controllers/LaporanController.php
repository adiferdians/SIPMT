<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query();

        // 🔍 Filter berdasarkan pencarian teks
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('tugas', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // 📅 Filter berdasarkan tanggal (format: yyyy-mm-dd)
        if ($request->filled('tanggal')) {
            $query->whereDate('tgl', $request->tanggal);
        }

        // ⏰ Urutkan dari tanggal terbaru
        $laporan = $query->orderByDesc('tgl')
            ->paginate(10)
            ->withQueryString();

        return view('content.laporan.laporan', compact('laporan'));
    }
}
