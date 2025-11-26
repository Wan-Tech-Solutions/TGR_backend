<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;


class AdminBlogsController extends Controller
{
    public function blogs(){
        $all_blogs = Blog::latest()->paginate(10);
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.blogs.blogs', compact('all_blogs','count_blogs','contact_count','founder_count','prospectus_count'));
    }

    public function edit($uuid)
    {
        $blog = Blog::where('uuid', $uuid)->firstOrFail();
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.blogs.edit', compact('blog', 'count_blogs', 'contact_count', 'founder_count', 'prospectus_count'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Blog::create($validated);

        return redirect()->route('admin.blogs')->with('success', 'Blog created successfully!');
    }

    public function update(Request $request, $uuid)
    {
        $blog = Blog::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $blog->update($validated);

        return redirect()->route('admin.blogs')->with('success', 'Blog updated successfully!');
    }

    public function destroy($uuid)
    {
        $blog = Blog::where('uuid', $uuid)->firstOrFail();
        $blog->delete();

        return redirect()->route('admin.blogs')->with('success', 'Blog deleted successfully!');
    }
}
