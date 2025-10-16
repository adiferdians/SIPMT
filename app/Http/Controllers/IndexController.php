<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Risalah;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    public function index()
    {
        $cuaca = $this->getWeather();
        // dd($cuaca);
        $cuti = Anggota::where('status', 'cuti')->count();
        $anggota = Anggota::count();
        $akanDatang = Risalah::where('status', 'Belum Terlaksana')->count();
        $dalamProses = Risalah::whereIn('status', ['Perekaman', 'Pengeditan', 'Transkripsi'])->count();
        $selesai = Risalah::where('status', 'Risalah OK')->count();
        return view('index', [
            'cuti' => $cuti,
            'anggota' => $anggota,
            'akanDatang' => $akanDatang,
            'dalamProses' => $dalamProses,
            'selesai' => $selesai,
            'cuaca' => $cuaca,
        ]);
    }

    public function getWeather()
    {
        $apiKey = env('OPEN_WEATHER_MAP_KEY');
        $cityName = 'Jakarta';

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$cityName}&appid={$apiKey}&units=metric");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
