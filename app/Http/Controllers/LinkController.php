<?php
namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::latest()->limit(20)->get();
        return view('home', compact('links'));
    }

    public function shorten(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $link = Link::create([
            'code' => Str::random(6),
            'url' => $request->url,
        ]);

        return back()->with('success', url($link->code));
    }

    public function redirect($code)
    {
        $link = Link::where('code', $code)->firstOrFail();
        $link->increment('clicks');
        return redirect($link->url);
    }
}
