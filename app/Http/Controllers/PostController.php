<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DisLike;
use App\Models\Like;
use App\Models\Post;
use App\Models\ReplyComment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function index()
    {
        return view('posts.show_post');
    }

    function show_all_posts()
    {
        $posts = Post::orderBy('created_at', 'desc')->latest()->get();
        $html = '';
        $html .= view('posts.show_all_posts', compact('posts'))->render();
        return response()->json(['data' => $html]);
    }

    function like_post(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::findOrFail($post_id);
        $like = Like::whereUserIdAndPostId(auth()->id(), $post->id)->first();
        if ($like) {
            $like->delete();

            $post->likes--;
            $post->dis_likes = $post->dis_likes > 0 ?  $post->dis_likes - 1 : $post->dis_likes;
            $post->save();
        } else {
            $dislike = DisLike::whereUserIdAndPostId(1, $post->id)->first();
            if ($dislike) {
                $dislike->delete();
            }
            $like = new Like();
            $like->post_id = $post->id;
            $like->user_id = auth()->id();
            $like->save();


            $post->likes++;
            $post->dis_likes = $post->dis_likes > 0 ?  $post->dis_likes - 1 : $post->dis_likes;
            $post->save();
        }
        return response()->json(['success' => true]);
    }
    function dis_like_post(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::findOrFail($post_id);
        $dis_like = DisLike::whereUserIdAndPostId(auth()->id(), $post->id)->first();
        if ($dis_like) {

            $dis_like->delete();

            $post->dis_likes--;
            $post->likes = $post->likes > 0 ?  $post->likes - 1 : $post->likes;
            $post->save();
        } else {
            $like = Like::whereUserIdAndPostId(1, $post->id)->first();
            if ($like) {
                $like->delete();
            }

            $dis_like1 = new DisLike();
            $dis_like1->post_id = $post->id;
            $dis_like1->user_id = auth()->id();
            $dis_like1->save();


            $post->dis_likes++;
            $post->likes = $post->likes > 0 ?  $post->likes - 1 : $post->likes;
            $post->save();
        }
        return response()->json(['success' => true]);
    }

    function show_comments(Request $request)
    {
        $post_id = $request->post_id;
        $comments = Comment::wherePostId($post_id)->latest()->limit(4)->get();
        $html = "";
        $html .= view('posts.show_comment', compact('comments'))->render();
        return response()->json(['data' => $html]);
    }

    function show_replay_comments(Request $request)
    {
        $post_id = $request->post_id;
        $comments = ReplyComment::wherePostIdAndCommentId($post_id, $request->comment_id)->latest()->limit(4)->get();
        $html = "";
        $html .= view('posts.replay_show_comment', compact('comments'))->render();
        return response()->json(['data' => $html]);
    }

    function create_comments(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::findOrFail($post_id);

        $comment = new Comment();
        $comment->content = $request->comment;
        $comment->post_id = $post->id;
        $comment->user_id = auth()->id();
        $comment->save();

        $post->comments++;
        $post->save();

        return response()->json(['data' => ['success' => true, 'post_id' => $post->id]]);
    }

    function create_replay_comments(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::findOrFail($post_id);

        $comment = new ReplyComment();
        $comment->content = $request->comment;
        $comment->comment_id = $request->comment_id;
        $comment->post_id = $post->id;
        $comment->user_id = auth()->id();
        $comment->save();

        $post->comments++;
        $post->save();

        return response()->json(['data' => ['success' => true, 'post_id' => $post->id]]);
    }
}
