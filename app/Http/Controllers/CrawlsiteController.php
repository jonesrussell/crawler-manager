<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Crawlsite; // Make sure to add the Crawlsite model import

class CrawlsiteController extends Controller
{
    public function index()
    {
        $crawlsites = Crawlsite::all();
        return Inertia::render('Crawlsites/Index', ['crawlsites' => $crawlsites]);
    }

    public function create()
    {
        return Inertia::render('Crawlsites/Create');
    }

    public function store(Request $request)
    {
        // Validate and store the new Crawlsite here
        // ...

        return redirect()->route('crawlsites.index');
    }

    public function show(Crawlsite $crawlsite)
    {
        return Inertia::render('Crawlsites/Show', ['crawlsite' => $crawlsite]);
    }

    public function edit(Crawlsite $crawlsite)
    {
        return Inertia::render('Crawlsites/Edit', ['crawlsite' => $crawlsite]);
    }

    public function update(Request $request, Crawlsite $crawlsite)
    {
        // Validate and update the Crawlsite here
        // ...

        return redirect()->route('crawlsites.index');
    }

    public function destroy(Crawlsite $crawlsite)
    {
        // Delete the Crawlsite here
        // ...

        return redirect()->route('crawlsites.index');
    }
}

