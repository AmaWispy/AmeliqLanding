<?php

namespace App\Http\Controllers;

use App\Models\BotHit;
use Illuminate\Http\Request;

class BotTrapController extends Controller
{
    public function trap(Request $request)
    {
        BotHit::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'payload' => $request->all(),
        ]);

        // Redirect back as if nothing happened, or to home
        return redirect()->route('home');
    }
}

