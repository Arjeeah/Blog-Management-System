<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function store(Request $request){
        $inputs= $request->validate([
            'name'=>['required','string'],
            'email'=>['required','string','email','unique:users,email,id'],
            'password'=>['required','string'],
        ]);
        User::create([
            'name'=>$inputs['name'],
            'email'=>$inputs['email'],
            'password'=>Hash::make($inputs['password']),
        ]);
        return response()->json([
            'message'=> 'done',
            ]);

    }
    public function login(Request $request){
      $request->validate([
            'email'=>['required','string','email'],
            'password'=>['required','string'],
        ]);
        $credentials=request(['email','password']);
        $token = auth('api')->attempt($credentials);
        return response()->json([
            "access_token"=> $token,
    "token_type"=>"bearer",
    "expires_in"=> 3600
        ]);

    }
    public function update(Request $request){
        $request->validate([
            'name'=>['string'],
            'email'=>['string','email','unique:users,eamil,'.$request['email'].',id'],
            'password'=>['string'],
        ]);
        $inputs=request(['name','email','password']);
        auth('api')->user()->update($inputs);
        return response()->json([
            'message'=> 'update suss',
            ]);


    }
    public function logout(){
        auth('')->logout(true);
        return response()->json([
            'message'=> 'logout'
            ]);
    }
    public function refresh(){
        $newtoken=auth('api')->refresh(true, true);
        return response()->json([
            "access_token"=> $newtoken,
            "token_type"=>"bearer",
            "expires_in"=> 3600
                
        ]);
            

    }
    
    
    public function destroy(){
        auth('')->user()->delete();
        return response()->json([
            'message'=> 'delete done'
            ]);
    }
    public function showPosts(){
        $post=auth()->user()->posts()->get();
        return response()->json([
            'message'=> $post
            ]);
    }
    public function createPost(Request $request){
        $request->validate([
            'title'=>['string'],
            'content'=> ['string','required'],
            'category_id'=>['exists:categories,id']
        ]);
        auth()->user()->posts()->create([
            'title'=> $request->title??null,
            'content'=> $request->content,
            'category_id'=> $request->category_id??null,
            'user_id'=> auth('')->user()->id
        ]);
        return response()->json([
            'message'=> 'create post done'
            ]);


    }
    public function commentsshow(){
        $comments=auth()->user()->comments()->get();
        return response()->json([
            'all comment'=> $comments
            ]);

    }


}
