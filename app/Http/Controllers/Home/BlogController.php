<?php

namespace App\Http\Controllers\Home;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        $popularBlogs = Blog::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->orderByDesc('lihat') // Urutkan berdasarkan jumlah view terbanyak
            ->take(5) // Ambil 5 blog paling populer (sesuaikan jika perlu)
            ->get();
        $trendingBlogs = Blog::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderByDesc('lihat') // Urutkan berdasarkan jumlah view terbanyak
            ->take(5) // Ambil 5 blog paling populer minggu ini
            ->get();


        return view('blog.index', ['blogs' => $blogs, 'popularBlogs' => $popularBlogs, 'trendingBlogs' => $trendingBlogs]);
    }
    public function show(Blog $blog)
    {
        $blog->lihat += 1;
        $blog->save();

        $relatedBlogs = Blog::latest()->get();
        $popularBlogs = Blog::latest()->get();

        return view('blog.show', ['relatedBlogs' => $relatedBlogs, 'blog' => $blog, 'popularBlogs' => $popularBlogs]);
    }
}
