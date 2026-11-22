<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function show($uuid)
    {
        $certificate = Certificate::with(['language', 'level', 'user'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('certificate.show', compact('certificate'));
    }

    public function verify($uuid)
    {
        $certificate = Certificate::with(['language', 'level'])
            ->where('uuid', $uuid)
            ->first();

        $isValid = $certificate !== null;

        return view('certificate.verify', compact('certificate', 'isValid', 'uuid'));
    }
}
