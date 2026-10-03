<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show PointDex Landing / Home Page.
     */
    public function home(): View
    {
        $presentationCount = Presentation::count();
        return view('welcome', compact('presentationCount'));
    }

    /**
     * Show About Page (PointDex Research, EDP Architecture, SDG Alignment).
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Show Presenter Dashboard with system stats and recent decks.
     */
    public function dashboard(): View
    {
        $totalDecks = Presentation::count();
        $readyDecks = Presentation::where('status', 'Ready')->count();
        $recentDecks = Presentation::latest()->take(5)->get();

        return view('dashboard', compact('totalDecks', 'readyDecks', 'recentDecks'));
    }
}