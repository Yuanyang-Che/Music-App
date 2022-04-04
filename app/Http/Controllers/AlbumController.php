<?php

namespace App\Http\Controllers;

use App\Jobs\AnnounceNewAlbum;
use App\Mail\NewAlbum;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        $album = new Album();
        $album->title = $request->input('title');
        $album->artist()->associate(Artist::find($request->input('artist')));
        //or $album->artist_id = $request->input('artist');
        $album->save();


//        DB::table('albums')->insert([
//            'title' => $request->input('title'),
//            'artist_id' => $request->input('artist'),
//        ]);
//        dd($request->input('artist'));

        //Mail::to('cheyuany@usc.edu')->queue(new NewAlbum($album));

        AnnounceNewAlbum::dispatch($album);

        return redirect()
            ->route('album.index')
            //stored in session('success')
            ->with('success', "Successfully created [{$request->input('title')}] album");

    }
}
