<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ImageUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('upload/tours', $fileName, 'public'); // Sử dụng driver 'public'
    
            return response()->json([
                'success' => true,
                'path' => Storage::url($path) // Đảm bảo đường dẫn URL là công khai
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'No image uploaded'
        ], 400);
    }
    
}