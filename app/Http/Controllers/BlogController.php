<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Comment;
class BlogController extends Controller
{

    
    public function show($uuid)
    {
        $blog = Blog::where('uuid', $uuid)->firstOrFail();

        // Load top-level comments and their replies
        $comments = Comment::where('blog_id', $blog->id)
                           ->whereNull('parent_id')
                           ->with('replies') // eager load replies
                           ->get();

        return view('website.newssingle', compact('blog', 'comments'));
    }
    public function index()
    {
        $all_blogs = Blog::sortby('created_at','desc')->all();
        return view('admin.systemsetting.blog.index', compact('all_blogs'));
    }

    public function create()
    {
        return view('admin.systemsetting.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        Blog::create($request->all());
        return redirect()->back()->with('success', 'Blog created successfully');
    }

    public function edit($uuid)
    {
        $blog = Blog::where('uuid', $uuid)->first();
        if (!$blog) {
            abort(404);
        }
        return view('admin.systemsetting.blog.edit', compact('blog'));
    }

    public function update(Request $request)
    {
        $blogs_id = $request->uuid;
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $blog = Blog::where('uuid', $blogs_id)->first();
        if (!$blog) {
            abort(404);
        }
        $blog->update($request->all());
        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully');
    }
    // public function destroy(Blog $blog)
    // {
    //     $blog->delete();
    //     return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully');
    // }

    public function delete($uuid)
    {
        $blog = Blog::where('uuid', $uuid)->first();
        if (!$blog) {
            abort(404);
        }
        $blog->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
