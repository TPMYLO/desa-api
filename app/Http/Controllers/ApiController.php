<?php

namespace App\Http\Controllers;

use App\Models\Villages;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        try {
            $desas = Villages::all();
            $desas->makeHidden(['district_id', 'created_at', 'updated_at']);

            return response()->json([
                'status'  => 'true',
                'data'    => $desas
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 'false',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function show($id)
    {
        try {
            $desa = Villages::findOrFail($id);
            $desa->makeHidden(['created_at', 'updated_at']);

            return response()->json([
                'status'  => 'true',
                'message' => 'Data berhasil ditemukan',
                'data'    => $desa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'false',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'district_id' => 'required',
            'name' => 'required',
        ]);

        $cek  = Villages::where('name', $request->name)->first();
        if ($cek) {
            return response()->json([
                'message' => 'Data sudah ada',
                'data'    => $cek
            ], 201);
        }
        $desa = Villages::create($validatedData);
        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'data'    => $desa
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $desa = Villages::findOrFail($id);

            $validatedData = $request->validate([
                'district_id' => 'required',
                'name' => 'required',
            ]);

            $desa->update($validatedData);

            return response()->json([
                'status'  => 'true',
                'message' => 'Data berhasil diupdate',
                'data'    => $desa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'false',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $desa = Villages::findOrFail($id);
            $desa->delete();

            return response()->json([
                'status'  => 'true',
                'message' => 'Data berhasil dihapus',
                'data'    => $desa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'false',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
}
