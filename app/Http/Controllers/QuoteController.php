<?php

namespace App\Http\Controllers;

use App\Models\Quotes;
use Illuminate\Http\Request;
use League\CommonMark\Extension\SmartPunct\Quote;

class QuoteController extends Controller
{
    //

    public function index(){
        $quotes = Quotes::all();
        $page_data = ['quotes' => $quotes];
        return view('admin.quote.quote', $page_data);
    }

    /* VIEW ADD PAGE */
    public function add() {
        return view('admin.quote.quote_add');
    }
    
    /* SAVE POST */
    public function store(Request $request) {
        $validated = $request->validate([
            'author' => 'nullable|string|max:100',
            'quote' => 'required|string|max:10000',
        ]);
        $quotes = Quotes::create($validated);
        $id = $quotes->id;
        return redirect()->route('admin.quote.details', $id)->with('added', 'Quote has been added');
    }

    /* VIEW DETAILS */
    public function details($id)
    {
        $quote = Quotes::findOrFail($id);
        return view('admin.quote.quote_details', compact('quote'));
    }

     public function edit($id) {
        $quote = Quotes::findOrFail($id);
        return view('admin/quote/quote_edit', ['quote' => $quote,]);
    }

    public function update(Request $request, Quotes $id) {
        $validated = $request->validate([
            'author' => 'nullable|string|max:100',
            'quote' => 'required|string|max:10000',
        ]);
        $id->author = $validated['author'] ?? null;
        $id->quote = $validated['quote'];
        $id->save();
        return redirect()->route('admin.quote.details', $id)->with('updated', 'Quote has been updated');
    }

    public function destroy($id)
    {
        $post = Quotes::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.quote.index')->with('status', 'Quote deleted successfully.');
    }






}
