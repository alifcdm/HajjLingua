<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Services\LinguisticMatrixService;
use Illuminate\Http\Request;

class AlphabetController extends Controller
{
    public function index($langCode = 'ar')
    {
        $language = Language::where('code', $langCode)->firstOrFail();
        $alphabetData = LinguisticMatrixService::getCompleteAlphabetMatrix($langCode);
        $allLanguages = Language::whereIn('code', ['ar', 'ja', 'ko', 'zh', 'en'])->get();

        return view('alphabet.index', compact('language', 'alphabetData', 'allLanguages', 'langCode'));
    }
}
