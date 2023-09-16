<?php

namespace App\Http\Controllers;

use App\Models\Crawlsite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CrawlsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crawlsites = Crawlsite::with('tags')->get();
     
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
        return Inertia::render('Crawlsites/View', [
            'crawlsite' => $crawlsite,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crawlsite $Crawlsite)
    {
        // dd($Crawlsite->tags->pluck('name')->toArray());
        return Inertia::render(
            'Crawlsites/Edit',
            [
                'Crawlsite' => $Crawlsite,
                'tags' => $Crawlsite->tags->pluck('name')->toArray(), // Pass the existing tags to your view
            ]
        );
    }

    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, Crawlsite $Crawlsite)
{
    $request->validate([
        'url' => 'required|string|max:255',
        'tags' => 'nullable|array', // Assuming tags are sent as an array
    ]);

    $Crawlsite->url = $request->url;
    $Crawlsite->save();

    // Attach the tags
    if ($request->has('tags')) {
        $tags = $request->input('tags');

        // Attach a single tag
        if (is_string($tags)) {
            $Crawlsite->attachTag($tags);
        } else {
            // Attach multiple tags
            $Crawlsite->attachTags($tags);
        }
    }

    return redirect()->route('crawlsites.index')->with('message', 'Crawlsite Updated Successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crawlsite $Crawlsite)
    {
        // Detach tags before deleting the model
        $Crawlsite->detachTags();

        $Crawlsite->delete();

        return redirect()->route('crawlsites.index')->with('message', 'Crawlsite Delete Successfully');
    }
}

