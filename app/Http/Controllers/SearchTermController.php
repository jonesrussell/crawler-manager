<?php

namespace App\Http\Controllers;

use App\Models\SearchTerm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchTermController extends Controller
{
  public function index()
  {
      $searchTerms = SearchTerm::all();
      return Inertia::render('SearchTerms/SearchTermIndex', ['searchTerms' => $searchTerms]);
  }

  public function create()
  {
      return Inertia::render('SearchTerms/SearchTermCreate');
  }

  public function store(Request $request)
  {
      $searchTerm = SearchTerm::create($request->all());
      return redirect()->route('terms.index');
  }

  public function show($id)
  {
      $searchTerm = SearchTerm::findOrFail($id);
      return Inertia::render('SearchTerms/Show', ['searchTerm' => $searchTerm]);
  }

  public function edit($id)
  {
      $searchTerm = SearchTerm::findOrFail($id);
      return Inertia::render('SearchTerms/Edit', ['searchTerm' => $searchTerm]);
  }

  public function update(Request $request, $id)
  {
      $searchTerm = SearchTerm::findOrFail($id);
      $searchTerm->update($request->all());
      return redirect()->route('terms.index');
  }

  public function destroy($id)
  {
      SearchTerm::destroy($id);
      return redirect()->route('terms.index');
  }
}