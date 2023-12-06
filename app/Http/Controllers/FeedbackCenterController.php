<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\feedbackCenter;
use App\Helper\DatabaseHelper;

class FeedbackCenterController extends Controller
{
    public function store()
    {
        $validate = request()->validate([
            'kategori' => 'required',
            'deskripsi' => 'required',
            'info_tambahan' => 'max:255',
            'lampiran' => 'file', // Menambahkan validasi bahwa ini adalah sebuah file
        ]);

        $count_feedback = feedbackCenter::count();

        $validate['no_feedback'] = 'OCTNS-FDB-000' . ($count_feedback + 1) . '-' . DatabaseHelper::getYear();

        $validate['user_id'] = auth()->user()->id;

        $deskripsi = strip_tags(request()->deskripsi);
        $validate['excerpt'] = mb_strlen($deskripsi) > 10 ? mb_substr($deskripsi, 0, 50) . '...' : $deskripsi;


        if(request()->hasFile('lampiran') && $validate['lampiran']->isValid()) {
            $validate['lampiran'] = cloudinary()->upload(request()->file('lampiran')->getRealPath())->getSecurePath();
        }

        $createFeedback = feedbackCenter::create($validate);

        if($createFeedback){
            return response()->json([
                'status' => 201,
                'message' => 'data berhasil ditambahkan'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'data gagal ditambahkan'
            ]);
        }
    }
}
