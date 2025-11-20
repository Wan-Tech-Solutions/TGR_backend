<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $uuid)
    {
        $blog = Blog::where('uuid', $uuid)->firstOrFail();

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Create the comment
        $comment = new Comment();
        $comment->uuid = (string) \Illuminate\Support\Str::uuid();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->message = $request->message;

        $blog->comments()->save($comment);

        // Redirect back to the blog post with a success message
        return back()->with('success', 'Comment posted successfully!');
    }
    public function reply(Request $request, $uuid)
    {
        // Find the comment by its UUID or fail if not found
        $comment = Comment::where('uuid', $uuid)->firstOrFail();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Create a new Comment instance for the reply
        $reply = new Comment();
        $reply->name = $validatedData['name'];
        $reply->email = $validatedData['email'];
        $reply->message = $validatedData['message'];

        // Save the reply as a child of the parent comment
        $comment->replies()->save($reply);

        // Return a JSON response indicating success
        return response()->json(['message' => 'Reply posted successfully']);
    }
}
