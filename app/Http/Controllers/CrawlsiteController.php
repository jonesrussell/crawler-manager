<?php

namespace App\Http\Controllers;

use App\Models\Crawlsite;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Jobs\CrawlerJob;
use Illuminate\Support\Facades\Log;

class CrawlsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crawlsites = Crawlsite::all();

        return Inertia::render(
            'Crawlsites/Index',
            [
                'crawlsites' => $crawlsites,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Crawlsites/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string|max:255',
        ]);
        Crawlsite::create([
            'url' => $request->url,
        ]);
        sleep(1);

        return redirect()->route('crawlsites.index')->with('message', 'Crawlsite Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Crawlsite $crawlsite)
    {
        // Define a list of jobs
        $jobs = [
            ['name' => 'CrawlerJob', 'description' => 'Crawls a website'],
            // ['name' => 'AnotherJob', 'description' => 'Another job description'],
        ];

        return Inertia::render('Crawlsites/View', [
            'crawlsite' => $crawlsite,
            'jobs' => $jobs, // Pass the list of jobs as the 'jobs' prop
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crawlsite $Crawlsite)
    {
        return Inertia::render(
            'Crawlsites/Edit',
            [
                'Crawlsite' => $Crawlsite,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crawlsite $Crawlsite)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Update only the "title" field
        $Crawlsite->update([
            'title' => $request->input('title'),
        ]);

        return redirect()->route('crawlsites.index')->with('message', 'Crawlsite Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crawlsite $Crawlsite)
    {
        $Crawlsite->delete();

        return redirect()->route('crawlsites.index')->with('message', 'Crawlsite Delete Successfully');
    }

    public function dispatchJob(Request $request, Crawlsite $crawlsite)
    {
        $data = [
            'url' => $crawlsite->url,
            'searchTerms' => $crawlsite->searchTerms,
            'crawlsiteId' => $crawlsite->id,
        ];

        CrawlerJob::dispatch($data)->onQueue('crawler_queue');

        return back()->with('message', 'Job dispatched successfully');
    }
}
