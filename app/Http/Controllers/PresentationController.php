<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PresentationController extends Controller
{
    /**
     * Display a listing of the resource (CRUD - Read All).
     */
    public function index(Request $request): View
    {
        $query = Presentation::query()->with('user');

        // Optional search filter by title or status
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $presentations = $query->latest()->paginate(8)->withQueryString();

        return view('presentations.index', compact('presentations'));
    }

    /**
     * Show the form for creating a new resource (CRUD - Create Form).
     */
    public function create(): View
    {
        return view('presentations.create');
    }

    /**
     * Store a newly created resource in storage (CRUD - Store with Validation).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'slide_count' => ['required', 'integer', 'min:1', 'max:200'],
            'sensitivity' => ['required', 'in:Low,Medium,High'],
            'cooldown_ms' => ['required', 'integer', 'min:200', 'max:3000'],
            'status'      => ['required', 'in:Ready,Draft,Archived'],
        ]);

        $validated['user_id'] = Auth::id() ?? 1;

        Presentation::create($validated);

        return redirect()->route('presentations.index')
            ->with('success', 'Presentation deck created successfully!');
    }

    /**
     * Display the specified resource (CRUD - Read Single / Interactive Presenter).
     */
    public function show(Presentation $presentation): View
    {
        return view('presentations.show', compact('presentation'));
    }

    /**
     * Show the form for editing the specified resource (CRUD - Edit Form).
     */
    public function edit(Presentation $presentation): View
    {
        return view('presentations.edit', compact('presentation'));
    }

    /**
     * Update the specified resource in storage (CRUD - Update with Validation).
     */
    public function update(Request $request, Presentation $presentation): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'slide_count' => ['required', 'integer', 'min:1', 'max:200'],
            'sensitivity' => ['required', 'in:Low,Medium,High'],
            'cooldown_ms' => ['required', 'integer', 'min:200', 'max:3000'],
            'status'      => ['required', 'in:Ready,Draft,Archived'],
        ]);

        $presentation->update($validated);

        return redirect()->route('presentations.index')
            ->with('success', 'Presentation settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage (CRUD - Delete).
     */
    public function destroy(Presentation $presentation): RedirectResponse
    {
        $presentation->delete();

        return redirect()->route('presentations.index')
            ->with('success', 'Presentation deleted successfully.');
    }
}