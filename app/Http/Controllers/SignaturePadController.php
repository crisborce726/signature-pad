<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signature;

class SignaturePadController extends Controller
{
    public function index()
    {
        return view('signature-pad');
    }

    public function save(Request $request)
    {
        $folderPath = storage_path('app/public/signatures/'); // create signatures folder in public directory
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);

        // Save in your data in database here.
        Signature::create([
            'name' => $request->name,
            'signature' => uniqid() . '.' . $image_type
        ]);

        return back()->with('success', 'Successfully saved the signature');
    }
}