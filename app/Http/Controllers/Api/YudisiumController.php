<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class YudisiumController extends Controller
{
    public function checkStatus(Request $request)
    {
        // 1. Validasi Input
        $npm = $request->query('npm');

        if (!$npm) {
            return response()->json([
                "status" => "error",
                "message" => "Parameter NPM tidak ditemukan"
            ], 400);
        }

        // 2. Logika substr seperti di kode asli
        $npm2 = substr($npm, 2);

        // 3. Query ke tabel tbyudisium
        $data = DB::table('tbyudisium')
            ->select('NPM', 'nama', 'status_verifikasi')
            ->where('NPM', $npm)
            ->orWhere('NPM', $npm2)
            ->orderBy('status_verifikasi', 'desc')
            ->first();

        if ($data) {
            return response()->json([
                "status" => "success",
                "data" => $data
            ]);
        }

        // 4. Jika tidak ada, Query ke tabel tbd4
        $dataD4 = DB::table('tbd4')
            ->select('NPM', 'nama', 'status_verifikasi')
            ->where('NPM', $npm)
            ->first();

        if ($dataD4) {
            return response()->json([
                "status" => "success",
                "data" => $dataD4
            ]);
        }

        // 5. Jika benar-benar tidak ada
        return response()->json([
            "status" => "not_found",
            "message" => "Data tidak ditemukan"
        ], 404);
    }
}
