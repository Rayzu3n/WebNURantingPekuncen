<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use Illuminate\View\View;

class BanomController extends Controller
{
    public function index(): View
    {
        $banoms = Banom::query()
            ->active()
            ->with('members')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('banoms.index', compact('banoms'));
    }
}
