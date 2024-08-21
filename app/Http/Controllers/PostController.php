<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function user($id){
        $user=User::where("id",$id)->firstOrFail();
        return response()->json([$user]);
    }
    public function category($categoryId){
        $category=Post::where("category_id",$categoryId)->get();
        return response()->json([$category]);
    }
    public function updateContent(Request $request, $id){
        $request->validate([
            'title'=>['string'],
            'content'=> ['string','required'],
            'category_id'=>['exists:categories,id']
        ]);
        $post=Post::where("id",$id)->firstOrFail();
        auth()->user()->posts()->find($post->id)->update($request->all());
        $post=Post::where("id",$id)->firstOrFail();
        return response()->json([
            "message"=> $post
        ]);
    }
    public function destroy($id){
        auth()->user()->posts()->findOrFail($id)->delete();
        return response()->json(["message"=> "done"]);
    }
    public function comments($id){
        $post=Post::where("id",$id)->firstOrFail();
        $comments=$post->comments()->get();
        return response()->json([
            "comment"=> $comments
            ]);
    }
    public function addComment(Request $request){
        $request->validate([
            'content'=> ['string','required'],
            'post_id'=>['required','exists:posts,id'],
        ]);
        $comment=auth()->user()->posts()->where('id',$request->post_id)->firstOrFail()
        ->comments()->create([
            'content'=> $request->content,
            'user_id'=> auth()->user()->id,
            'post_id'=> $request->post_id
        ]);
        return response()->json([
            'message'=> $comment
            ]);

        }



}
