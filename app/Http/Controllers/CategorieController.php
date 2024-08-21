<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;

class CategorieController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
        ]);
         Category::create([
            'name'=> $request->name
            ]);
            return response()->json(    [
                'message'=> 'done'
            ]);
    }
    public function addPost(Request $request,$postId){
        $request->validate([
            'category_id'=>['required','exists:categories,id']
        ]);
        $post=Post::where("id",$postId)->firstOrFail();
        auth()->user()->posts()->find($post->id)->update($request->all());
        $post=Post::where("id",$postId)->firstOrFail();
        return response()->json([
            "message"=> $post
        ]);
    }
    public function removePost($postId){
      
        $post=Post::where("id",$postId)->firstOrFail();
        auth()->user()->posts()->find($post->id)->update([
            "category_id"=>null
        ]);
        $post=Post::where("id",$postId)->firstOrFail();
        return response()->json([
            "message"=> $post
        ]);

    }


    public function destroy($id){
        Category::find($id)->delete();
        return response()->json( [
            'message'=> 'done'  
            ]);
    }

}
