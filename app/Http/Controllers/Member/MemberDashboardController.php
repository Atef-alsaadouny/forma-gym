<?php

declare(strict_types=1);

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MemberDashboardController extends Controller
{
    public function index(): View
    {
        return view('member.dashboard');
    }
}
