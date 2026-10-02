<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function show(string $member_number): View
    {
        $member = Member::with('user')
            ->where('member_number', $member_number)
            ->firstOrFail();

        return view('member.verify', compact('member'));
    }
}