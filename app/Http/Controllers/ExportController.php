<?php

namespace App\Http\Controllers;

use App\Models\Yudisium;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function cetakBiodataWisudawan()
    {
        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();

        return view('export.cetakbiodatawisudawan', [
            'data' => $yudisium
        ]);
    }

    public function cetakBiodataAlumni()
    {
        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();

        return view('export.cetakbiodataalumni', [
            'data' => $yudisium
        ]);
    }

    public function cetakBiodataVandel()
    {
        $yudisium = Yudisium::where('NPM', Auth::user()->mahasiswa->NPM)->first();

        return view('export.cetakbiodatavandel', [
            'data' => $yudisium
        ]);
    }
}
