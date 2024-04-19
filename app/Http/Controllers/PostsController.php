<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\PostsUserMapping;
use App\Models\User;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function creatPostPage(){
        $user = User::get();
        return view('create-post-page')->with('data', $user);
    }

    public function createPost(Request $request){
        $request->validate([
            'notification_type' => ['required', Rule::in(['marketing', 'invoices', 'system'])],
            'user_ids' => ['required'],
            'post_data' => ['required','string'],
            'end_date' => ['required','date','after:today']
        ]);

        $posts = Posts::create([
            'post_type' => $request->notification_type,
            'post_data' => $request->post_data,
            'valid_till' =>  $request->end_date,
        ]);

        if($request->user_ids == 'all'){
            $userIds = User::pluck('id')->toArray();
            foreach($userIds as $user_id){
                $user = PostsUserMapping::create([
                    'post_id' => $posts->id,
                    'user_id' => $user_id
                ]);
            }
        }
        

        return redirect()->route('posts')->with('status', 'post added successfully');
    }

    public function getAll(){
        $posts = Posts::with('postUserData')->paginate(5);
        if($posts->isNotEmpty()){
            return view('posts')->with('data', $posts);
        }else{
            return view('posts')->with('data', null);
        }
    }

    public function update(Request $request){
        $request->validate([
            'post_type' => ['required', Rule::in(['marketing', 'invoices', 'system'])],
            'post_data' => ['required','string'],
            'valid_till' => ['required','date'],
            'post_id' => ['required','integer','exists:posts,id']
        ]);

        $postData = $request->except(['user_ids','post_id','_token']);
        Posts::whereId($request->post_id)->update($postData);

        if($request->has('user_ids')){
            PostsUserMapping::where('post_id',$request->post_id)->delete();
            if($request->user_ids == 'all'){
                $userIds = User::pluck('id')->toArray();
                foreach($userIds as $user_id){
                    $user = PostsUserMapping::create([
                        'post_id' => $request->post_id,
                        'user_id' => $user_id
                    ]);
                }
            }
        }

        $posts = Posts::with('postUserData')->get();
        if($posts->isNotEmpty()){
            return redirect()->route('posts')->with([
                'status' => 'Post Updated Successfully',
                'data' => $posts
            ]);
        }else{
            return redirect()->route('posts')->with([
                'data' => null
            ]);
        }
    }

    public function delete(Request $request){
        $request->validate([
            'post_id' => ['required','integer','exists:posts,id']
        ]);

        Posts::whereId($request->post_id)->delete();
        PostsUserMapping::whrere('post_id',$request->post_id)->delete();

        return redirect()->route('posts')->with('status', 'Post Deleted Successfully');
    }

    public function edit($id){
        $post = Posts::findOrFail($id);

        $user = User::get();

        return view('edit-post-page')->with([
            'users' => $user,
            'post' => $post
        ]);
    }
}
