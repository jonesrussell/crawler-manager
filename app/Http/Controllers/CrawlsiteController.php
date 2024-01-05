<?php

namespace App\Http\Controllers;

use App\Models\Crawlsite;
use App\Models\Task;
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
        // Fetch the tasks for the crawl site
        $tasks = Task::where('crawlsite_id', $crawlsite->id)->get();

        return Inertia::render('Crawlsites/View', [
            'crawlsite' => $crawlsite,
            'tasks' => $tasks, // Pass the tasks as the 'tasks' prop
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

    public function storeTaskId(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'task_id' => 'required',
            'crawlsite_id' => 'required',
        ]);

        // Get the current user's ID
        $userId = auth()->id();

        // Store the task_id and user_id in the database...
        $task = new Task; // replace 'Task' with your actual model
        $task->id = $validated['task_id'];
        $task->user_id = $userId;
        $task->crawlsite_id = $validated['crawlsite_id'];
        $task->save();

        // Return a response...
        return response()->json(['message' => 'Task ID stored successfully']);
    }
}
