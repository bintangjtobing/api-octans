<?php

namespace App\Http\Controllers;

use App\Models\feedbackCenter;
use Illuminate\Http\Request;

class FeedbackManageController extends Controller
{
    public function index()
    {
        $feedback = feedbackCenter::paginate(15);

        if($feedback) {
            return response()->json([
                'status' => 200,
                'message' => 'okee',
                'data' => $feedback,
            ]);
        }else{
            return response()->json([
                'status' => 203,
                'message' => 'tiddak ada data yang ditampilkan',
            ]);
        }

        return response()->json([
            'status' => 400,
            'response' => 'error'
        ]);
    }

    public function getFeedbackManageById(Request $request)
    {
        $feedback = feedbackCenter::where('id', $request->id)->paginate(15);

        if($feedback) {
            return response()->json([
                'status' => 200,
                'message' => 'okee',
                'data' => $feedback,
            ]);
        }else{
            return response()->json([
                'status' => 203,
                'message' => 'tiddak ada data yang ditampilkan',
            ]);
        }

        return response()->json([
            'status' => 400,
            'response' => 'error'
        ]);
    }
}
