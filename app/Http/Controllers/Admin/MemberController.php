<?php

namespace App\\Http\\Controllers\\Admin;

use App\\Http\\Controllers\\Controller;
use App\\Models\\Member;
use Illuminate\\View\\View;

class MemberController extends Controller
{
    /**
     * Show the minimum member directory data available to administrators.
     *
     * Personal profile information is intentionally excluded from both the
     * query and the rendered response after an application has been approved.
     */
    public function index(): View
    {
        $members = Member::query()
            ->select(['id', 'user_id', 'member_number', 'status'])
            ->with(['user:id,name'])
            ->latest()
            ->paginate(10);

        return view('admin.members.index', compact('members'));
    }
}
