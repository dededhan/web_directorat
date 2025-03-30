<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instagram;
use Illuminate\Support\Facades\Storage;

class InstagramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instagram_posts = Instagram::orderBy('created_at', 'desc')->get();
        return view('admin.instagram', compact('instagram_posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:100',
            'deskripsi' => 'required',
            'link' => 'required|url',
        ]);

        Instagram::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
        ]);

        return redirect()->route('admin.instagram.index')->with('success', 'Post Instagram berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instagram = Instagram::findOrFail($id);
        $instagram->delete();

        return redirect()->route('admin.instagram.index')->with('success', 'Post Instagram berhasil dihapus');
    }
    
    /**
     * Get Instagram posts for the frontend display
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFrontendPosts()
    {
        $instagramPosts = Instagram::orderBy('created_at', 'desc')->take(3)->get();
        return $instagramPosts;
    }
}