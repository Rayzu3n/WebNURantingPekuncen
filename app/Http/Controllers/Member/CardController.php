<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jeeven\QrCode\Facades\QrCode;

class CardController extends Controller
{
    public function show(Request $request): View
    {
        $member = $request->user()->member;

        abort_unless($member, 404);

        $member->load('user');

        $verificationUrl = route(
            'member.verify',
            $member->member_number
        );

        $qrCode = QrCode::make($verificationUrl)
            ->size(300)
            ->errorCorrection('high')
            ->toBase64();

        return view('member.card', compact(
            'member',
            'qrCode',
            'verificationUrl'
        ));
    }
}