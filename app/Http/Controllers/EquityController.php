<?php

namespace App\Http\Controllers;

use App\Models\EquityNews;
use Illuminate\Http\Request;

class EquityController extends Controller
{
    public function index()
    {
        $equityNews = EquityNews::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('equity.equity', compact('equityNews'));
    }

    public function showNews($slug)
    {
        $news = EquityNews::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedNews = EquityNews::where('is_active', true)
            ->where('id', '!=', $news->id)
            ->where('gradient_color', $news->gradient_color)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('equity.news-detail', compact('news', 'relatedNews'));
    }
}
