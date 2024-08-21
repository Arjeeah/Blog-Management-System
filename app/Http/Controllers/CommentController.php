<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function showpost($id){
        $post=Comment::findOrFail($id)->post()->first();
        return response()->json($post);
    }
    public function user($id){
        $user=auth()->user()->comments()->where("id",$id)->firstOrFail()->user;
        return response()->json($user);
    }
    public function update(Request $request,$id){
        $request->validate([
            'content'=> ['string','required'],
        ]);
        auth()->user()->comments()->findOrFail($id)->update($request->all());
        return response()->json(
            [
                'message'=> 'done',
            ]
        );
    }
    public function destroy($id){
        auth()->user()->comments()->findOrFail($id)->delete();
        return response()->json(
            [
                'message'=> 'done'
                ]
                );
            }
}
