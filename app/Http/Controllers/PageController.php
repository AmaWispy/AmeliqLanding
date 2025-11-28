<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::where('slug', 'home')->where('is_active', true)->firstOrFail();

        return view('page', compact('page'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('page', compact('page'));
    }
}
