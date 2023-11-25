<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LabController extends Controller
{
    public function index()
    {
        $lab = Lab::all();
        return response()->json([
            'status' => 'success',
            'data' => $lab
        ]);
    }
    public function show($id)
    {
        $lab = Lab::find($id);
        if (!$lab) {
            return response()->json([
                'status' => 'error',
                'message' => 'lab not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $lab
        ]);
    }

    public  function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|min:0',
            'code_lab' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $lab = Lab::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $lab
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $lab = Lab::find($id);
        if (!$lab) {
            return response()->json([
                'status' => 'error',
                'message' => 'lab not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
            'price' => 'min:0',
            'code_lab' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
        $lab->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $lab
        ], 200);
    }

    public function destroy($id)
    {
        $lab = Lab::find($id);
        if (!$lab) {
            return response()->json([
                'status' => 'error',
                'message' => 'lab not found',
            ], 404);
        }

        $lab->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'lab deleted successfully'
        ]);
    }
}
