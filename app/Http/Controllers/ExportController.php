<?php

namespace App\Http\Controllers;

use App\Models\Yudisium;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public $periodeYudisium;

    public function __construct()
    {
        $this->periodeYudisium = DB::table('tbsetyudisium')->first()->periode_yudisium;
    }

    public function cetakBiodataWisudawan()
    {
        if (!Auth::user()->mahasiswa) {
            abort(403, 'Akun Anda tidak terhubung dengan data mahasiswa.');
        }

        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();
        if (!$yudisium || intval($yudisium->status_verifikasi) !== 2) {
            abort(403, 'Akses Ditolak: Berkas Anda belum disetujui.');
        }

        return view('export.cetakbiodatawisudawan', [
            'data' => $yudisium,
            'periode_yudisium' => $this->periodeYudisium,
        ]);
    }

    public function cetakBiodataAlumni()
    {
        if (!Auth::user()->mahasiswa) {
            abort(403, 'Akun Anda tidak terhubung dengan data mahasiswa.');
        }

        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();
        if (!$yudisium || intval($yudisium->status_verifikasi) !== 2) {
            abort(403, 'Akses Ditolak: Berkas Anda belum disetujui.');
        }

        return view('export.cetakbiodataalumni', [
            'data' => $yudisium,
            'periode_yudisium' => $this->periodeYudisium,
        ]);
    }

    public function cetakBiodataVandel()
    {
        if (!Auth::user()->mahasiswa) {
            abort(403, 'Akun Anda tidak terhubung dengan data mahasiswa.');
        }

        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();
        if (!$yudisium || intval($yudisium->status_verifikasi) !== 2) {
            abort(403, 'Akses Ditolak: Berkas Anda belum disetujui.');
        }

        return view('export.cetakbiodatavandel', [
            'data' => $yudisium,
            'periode_yudisium' => $this->periodeYudisium,
        ]);
    }
}
