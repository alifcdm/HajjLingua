<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HajjModuleService;

class HajjController extends Controller
{
    /**
     * Menampilkan Modul Pembelajaran Ibadah Haji Terpadu
     */
    public function index(Request $request)
    {
        $hajjData = HajjModuleService::getModuleData();
        $activeTab = $request->query('tab', 'timeline');

        return view('hajj.index', [
            'hajj' => $hajjData,
            'activeTab' => $activeTab,
        ]);
    }
}
