<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = DB::table('albums')
            ->select('albums.title', 'artists.name AS artist',)
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->orderBy('artist')
            ->orderBy('title')
            ->get();

        return view('album.index', [
            'albums' => $albums
        ]);
    }

    public function create()
    {
        $artists = DB::table('artists')
            ->orderBy('name')
            ->get();

        return view("album.create", [
            'artists' => $artists
        ]);
    }

    public function store(Request $request)
    {
        //When validation fails, the page will not be redirected, just refreshed, at @error and old() is filled
        $request->validate([
            'title' => 'required|max:20',
            'artist' => 'required|exists:artists,id',
        ]);

        DB::table('albums')->insert([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist'),
        ]);
//        dd($request->input('artist'));

        return redirect()
            ->route('album.index')
            //stored in session('success')
            ->with('success', "Successfully created [{$request->input('title')}] album");

    }
}
