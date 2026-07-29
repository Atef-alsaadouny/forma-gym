<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('public.home');
    }

    public function about(): RedirectResponse
    {
        return redirect('/#features');
    }

    public function contact(): RedirectResponse
    {
        return redirect('/#contact');
    }
}
