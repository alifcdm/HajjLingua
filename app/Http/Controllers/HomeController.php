<?php

namespace App\Http\Controllers;

use App\Models\LanguagePair;
use App\Models\Certificate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pairs = LanguagePair::with(['baseLanguage', 'targetLanguage'])
            ->where('is_active', true)
            ->get();

        $recentCertificates = Certificate::with(['language', 'level'])
            ->latest('issued_at')
            ->limit(5)
            ->get();

        return view('home', compact('pairs', 'recentCertificates'));
    }
}
