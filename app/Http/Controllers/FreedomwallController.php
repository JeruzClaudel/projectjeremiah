<?php

namespace App\Http\Controllers;

use App\Models\FreedomWall;
use App\Models\Quotes;
use Illuminate\Http\Request;

class FreedomwallController extends Controller
{
    //

    /* VIEW INDEX PAGE */
    public function index(Request $request) {
        $query = FreedomWall::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $entries = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.freedomwall.freedomwall', compact('entries'));
    }

    /* VIEW ADD POSTS PAGE */
     public function add(){
        return view('user.freedomwall.freedomwall_add');
    }

    /* SAVE FUNCTION */
    public function store(Request $request){
         $validated = $request->validate([
            'postName' => 'nullable|string',
            'post' => 'required|string',
        ]);

        if (empty($validated['postName'])) {
            $validated['postName'] = 'Anonymous' . mt_rand(10000, 99999);
        }

        // Save the post
        $post = new FreedomWall();
        $post->postName = $validated['postName'];
        $post->post = $validated['post'];
        $post->save();

        
        return redirect()->route('user.freedomwall.submitted', $post)->with('success', 'Post has been added');
    }

    /* VIEW DETAILS PER POST */
    public function details($id)
    {
        $post = FreedomWall::findOrFail($id);
        return view('admin.freedomwall.details', compact('post'));
    }


    /* DELETE  */
    public function destroy($id)
    {
        $post = FreedomWall::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.freedomwall.freedomwall')->with('status', 'Post deleted successfully.');
    }

    /* VIEW CREATE PAGE */
    public function create(){
        return view('user.freedomwall.freedomwall_create');
    }

    /* VIEW THE SUBMITTED PAGE*/
    public function submitted(){

         $randomQuote = Quotes::inRandomOrder()->first();


        return view('user.freedomwall.freedomwall_submitted', ['randomQuote' => $randomQuote]);
    }
}

