<?php

namespace App\Http\Controllers;

use App\Models\ResultLab;
use Illuminate\Http\Request;
use App\Models\DetailKunjungan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ResultLabController extends Controller
{
    public function index()
    {
        $resultLabs = ResultLab::with(['lab', 'user', 'kunjungan'])->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $resultLabs
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => 'required',
            "lab_id" => 'required',
            "kunjungan_id" => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $resultLab = ResultLab::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $resultLab
        ]);
    }

    public function show($id)
    {
        $resultLab = ResultLab::find($id);

        if (!$resultLab) {
            return response()->json([
                'status' => 'success',
                'data' => $resultLab
            ], 404);
        }

        $resultLab->load(['user', 'lab', 'kunjungan']);
        return response()->json([
            'status' => 'success',
            'data' => $resultLab
        ]);
    }

    public function destroy($id)
    {
        $resultLab = ResultLab::find($id);

        if (!$resultLab) {
            return response()->json([
                'status' => 'error',
                'data' => 'data not found',
            ], 404);
        }

        if ($resultLab->hasil_lab) {
            Storage::delete($resultLab->hasil_lab);
        }
        $resultLab->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'data deleted successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $resultLab = ResultLab::find($id);

        if (!$resultLab) {
            return response()->json([
                'status' => 'error',
                'message' => 'data not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kunjungan_id' => 'required',
            'user_id' => 'required',
            'lab_id' => 'required',
            'hasil_lab' => 'required',
            'status' => 'required',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        if ($resultLab->hasil_lab && $request->file('hasil_lab')) {
            Storage::delete($resultLab->hasil_lab);
        }

        // $validated['hasil_lab'] = $request->file('hasil_lab')->store('public/hasil-lab');


        // if ($validated['status'] === 'success' && $resultLab->status == null) {

        //     $invoiceUpdate = DetailKunjungan::where('kunjungan_id', $resultLab->kunjungan_id)->first();

        //     $invoiceUpdate->pembayaran = $invoiceUpdate->pembayaran + $resultLab->lab->price;
        //     $invoiceUpdate->update();
        // }

        $resultLab->update($request->all());

        return response()->json([
            'status' => 'success',
            "data" => $resultLab
        ]);
    }
}
