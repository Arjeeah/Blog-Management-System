<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagPostController extends Controller
{
    public function index($tag_id){
        $posts=Tag::where("id",$tag_id)->firstOrFail()->posts()->get();
        return response()->json([
            "date"=> $posts
            ]);

    }
    public function addPost( Request $request,$post_id){
        $request->validate([
            'name'=>['required','string'],
        ]);
        $tag=Tag::create([
            'name'=>$request->name
        ]);
        Post::where('id',$post_id)->firstOrFail()->tags()->attach($tag->id);
        return response()->json([
            'date'=> "done"
            ]);

    }
    public function removePost(Request $request,$post_id){
        $request->validate([
            'id'=>["required","string",'exists:tags,id'],
            ]);
            Tag::where('id',$request->id)->firstOrFail()->posts()->detach($post_id);
            return response()->json([
                'date'=> 'done'
                ]);
    }
    public function update(Request $request,$id){
        $request->validate([
            'name'=>['required','string'],
            ]);
            $tag=Tag::where('id', '=',$request->id)->firstOrFail();
            $tag->update($request->all());
            $tag=Tag::where('id', '=',$request->id)->firstOrFail();
                return response()->json([
                    "date"=> $tag->firstOrFail()
                    ]);
                }
                public function deleteTag(Request $request){
                    $tag=Tag::where("name", "=",$request->name)->firstOrFail();
                    Tag::where('id',$tag->id)->firstOrFail()->posts()->detach();
                    $tag->delete(); 
                    return response()->json([
                        'date'=> 'done' 
                        ]);
                        




                }

}
