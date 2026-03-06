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
        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();

        return view('export.cetakbiodatawisudawan', [
            'data' => $yudisium,
            'periode_yudisium' => $this->periodeYudisium,
        ]);
    }

    public function cetakBiodataAlumni()
    {
        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();

        return view('export.cetakbiodataalumni', [
            'data' => $yudisium,
            'periode_yudisium' => $this->periodeYudisium,
        ]);
    }

    public function cetakBiodataVandel()
    {
        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();

        return view('export.cetakbiodatavandel', [
            'data' => $yudisium,
            'periode_yudisium' => $this->periodeYudisium,
        ]);
    }
}
