<?php
// app/Http/Controllers/Api/BlogController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::published()->recent();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // Pagination
        $perPage = $request->get('per_page', 6);
        $blogs = $query->paginate($perPage);

        // Transform the data manually
        $transformedBlogs = $blogs->getCollection()->map(function ($blog) {
            return [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'excerpt' => $blog->excerpt,
                'content' => $blog->content,
                'image' => $blog->image_url,
                'category' => $blog->category,
                'author' => $blog->author,
                'author_role' => $blog->author_role,
                'author_image' => $blog->author_image_url,
                'published_date' => $blog->published_date,
                'read_time' => $blog->read_time,
                'tags' => $blog->tags,
                'is_published' => $blog->is_published,
                'views' => $blog->views,
                'created_at' => $blog->created_at,
                'updated_at' => $blog->updated_at,
            ];
        });

        return response()->json([
            'data' => $transformedBlogs,
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::published()->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $blog->increment('views');

        return response()->json([
            'data' => [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'excerpt' => $blog->excerpt,
                'content' => $blog->content,
                'image' => $blog->image_url,
                'category' => $blog->category,
                'author' => $blog->author,
                'author_role' => $blog->author_role,
                'author_image' => $blog->author_image_url,
                'published_date' => $blog->published_date,
                'read_time' => $blog->read_time,
                'tags' => $blog->tags,
                'is_published' => $blog->is_published,
                'views' => $blog->views,
                'created_at' => $blog->created_at,
                'updated_at' => $blog->updated_at,
            ]
        ]);
    }

    public function categories(): array
    {
        return Blog::published()
            ->distinct()
            ->pluck('category')
            ->toArray();
    }

    public function recentPosts($excludeSlug = null, $limit = 3)
    {
        $query = Blog::published()->recent();
        
        if ($excludeSlug) {
            $query->where('slug', '!=', $excludeSlug);
        }

        $posts = $query->limit($limit)->get()->map(function ($blog) {
            return [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'excerpt' => $blog->excerpt,
                'image' => $blog->image_url,
                'category' => $blog->category,
                'author' => $blog->author,
                'published_date' => $blog->published_date,
                'read_time' => $blog->read_time,
            ];
        });

        return response()->json(['data' => $posts]);
    }
}