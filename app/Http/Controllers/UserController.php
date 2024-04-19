<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Posts;
use App\Models\PostsUserMapping;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function getUserData()
    {
        $id = auth()->user()->id;
        $user = User::with('userPosts.postMapping')->where('id',$id)->first();

        $userData = NULL;
        if($user){
            
            $unreadNotifications = $readNotifications = 0;
            $unreadNotificationData = $user->userPosts;
            $unreadNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                            return 1;
                        }
                    }
                }
                
            })->sum();

            $readNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 1){
                            return 1;
                        }
                    }
                }
            })->sum();

            $postsData = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                        return [
                                'post_type' => $itemTwo->postMapping->post_type,
                                'post_id' => $itemTwo->postMapping->id
                        ];
                        }
                    }
                }
            });

            $userData =  [
                'id' => $user->id,
                'read_notifications' => $readNotifications,
                'unread_notifications' => $unreadNotifications,
                'postData' => $postsData
            ];
        }
        if($userData){
            return view('profile')->with('data',$userData);
        }else{
            return view('profile')->with('data',null);
        }
        
    }

    public function dashboard()
    {
        $id = auth()->user()->id;
        $user = User::with('userPosts.postMapping')->where('id',$id)->first();

        $userData = NULL;
        if($user){
            
            $unreadNotifications = $readNotifications = 0;
            $unreadNotificationData = $user->userPosts;
            $unreadNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                            return 1;
                        }
                    }
                }
                
            })->sum();

            $readNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 1){
                            return 1;
                        }
                    }
                }
            })->sum();

            $postsData = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                        return [
                                'post_type' => $itemTwo->postMapping->post_type,
                                'post_id' => $itemTwo->postMapping->id
                        ];
                        }
                    }
                }
            });

            $userData =  [
                'id' => $user->id,
                'read_notifications' => $readNotifications,
                'unread_notifications' => $unreadNotifications,
                'postData' => $postsData
            ];
        }
        if($userData){
            return view('dashboard')->with('data',$userData);
        }else{
            return view('dashboard')->with('data',null);
        }
        
    }

    public function update(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile_no' => ['digits_between:0,10','regex:/^[6-9][0-9]{9}$/'],
            'notification_switch' => ['required','integer',Rule::in(['0','1'])]
        ]);

       
        $userData = $request->except(['_token']);
        User::whereId(auth()->user()->id)->update($userData);

        return redirect()->route('settings')->with('status','Settings Updated Successfully!');
        
    }

    public function getAll(){
        $users = User::with('userPosts.postMapping')->get();
        
        if($users){
            $userData = $users->map(function ($item, $index) {
                $unreadNotifications = $readNotifications = 0;
                $unreadNotificationData = $item->userPosts;
                $unreadNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($item,$unreadNotifications,$readNotifications) {
                    if($itemTwo->postMapping){
                        
                        if($itemTwo->postMapping->valid_till>=today()){
                            if($item->is_post_read_by_user == 0){
                               return 1;
                            }
                        }
                    }
                    
                })->sum();

                $readNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($item,$unreadNotifications,$readNotifications) {
                    if($itemTwo->postMapping){
                        if($itemTwo->postMapping->valid_till>=today()){
                            if($item->is_post_read_by_user == 1){
                                return 1;
                            }
                        }
                    }
                })->sum();
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'mobile_no' => $item->mobile_no,
                    'notification_switch' => $item->notification_switch,
                    'read_notifications' => $readNotifications,
                    'unread_notifications' => $unreadNotifications
                ];
            });
            
            return view('all-user')->with('data', $userData);
        }else{
            return view('all-user')->with('data', null);
        }
    }

    public function imporsonateUser($id){
        $user = User::with('userPosts.postMapping')->findOrFail($id);

        
        $unreadNotifications = $readNotifications = 0;
        $unreadNotificationData = $user->userPosts;
        $unreadNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
            if($itemTwo->postMapping){
                
                if($itemTwo->postMapping->valid_till>=today()){
                    if($itemTwo->is_post_read_by_user == 0){
                        return 1;
                    }
                }
            }
            
        })->sum();

        $readNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
            if($itemTwo->postMapping){
                if($itemTwo->postMapping->valid_till>=today()){
                    if($itemTwo->is_post_read_by_user == 1){
                        return 1;
                    }
                }
            }
        })->sum();

        $postsData = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
            if($itemTwo->postMapping){
                if($itemTwo->postMapping->valid_till>=today()){
                    if($itemTwo->is_post_read_by_user == 0){
                       return [
                            'post_type' => $itemTwo->postMapping->post_type,
                            'post_id' => $itemTwo->postMapping->id
                       ];
                    }
                }
            }
        });

        $user =  [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile_no' => $user->mobile_no,
            'notification_switch' => $user->notification_switch,
            'read_notifications' => $readNotifications,
            'unread_notifications' => $unreadNotifications,
            'postData' => $postsData
        ];

        return view('imporsonate-user-page')->with('data', $user);

        
    }

    public function editUser(){
        $id = auth()->user()->id;
        $user = User::with('userPosts.postMapping')->where('id',$id)->first();

        $userData = NULL;
        if($user){
            
            $unreadNotifications = $readNotifications = 0;
            $unreadNotificationData = $user->userPosts;
            $unreadNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                            return 1;
                        }
                    }
                }
                
            })->sum();

            $readNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 1){
                            return 1;
                        }
                    }
                }
            })->sum();

            $postsData = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                        return [
                                'post_type' => $itemTwo->postMapping->post_type,
                                'post_id' => $itemTwo->postMapping->id
                        ];
                        }
                    }
                }
            });

            $userData =  [
                'id' => $user->id,
                'read_notifications' => $readNotifications,
                'unread_notifications' => $unreadNotifications,
                'postData' => $postsData
            ];
        }
        if($userData){
            return view('settings')->with('data',$userData);
        }else{
            return view('settings')->with('data',null);
        }
        
    }

    public function userPosts(){
        $id = auth()->user()->id;
        $user = User::with('userPosts.postMapping')->where('id',$id)->first();

        $userData = NULL;
        if($user){
            
            $unreadNotifications = $readNotifications = 0;
            $unreadNotificationData = $user->userPosts;
            $unreadNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                            return 1;
                        }
                    }
                }
                
            })->sum();

            $readNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 1){
                            return 1;
                        }
                    }
                }
            })->sum();

            $postsData = NULL;
            $postsData = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                            return [
                                    'post_type' => $itemTwo->postMapping->post_type,
                                    'post_id' => $itemTwo->postMapping->id,
                                    'post_data' =>  $itemTwo->postMapping->post_data,
                                    'valid_till' =>  $itemTwo->postMapping->valid_till,
                            ];
                        }
                    }
                }
            });

            $postDataForPage = NULL;
            $postDataForPage = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        return [
                            'post_type' => $itemTwo->postMapping->post_type,
                            'post_id' => $itemTwo->postMapping->id,
                            'post_data' =>  $itemTwo->postMapping->post_data,
                            'valid_till' =>  $itemTwo->postMapping->valid_till,
                        ];
                        
                    }
                }
            });

            $userData =  [
                'id' => $user->id,
                'postData' => $postsData,
                'read_notifications' => $readNotifications,
                'unread_notifications' => $unreadNotifications,
                'postDataForPage' => $postDataForPage
            ];

        }
        if($userData){
            return view('user-posts')->with('data',$userData);
        }else{
            return view('user-posts')->with('data',null);
        }
        
    }

    public function notificationReadByUser($userId,$postId){
        $post = Posts::findOrFail($postId);
        $user = User::with('userPosts.postMapping')->findOrFail($userId);

        PostsUserMapping::where('post_id',$postId)->where('user_id',$userId)->update(['is_post_read_by_user' => 1]);

        if($user){
            
            $unreadNotifications = $readNotifications = 0;
            $unreadNotificationData = $user->userPosts;
            $unreadNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                            return 1;
                        }
                    }
                }
                
            })->sum();

            $readNotifications = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 1){
                            return 1;
                        }
                    }
                }
            })->sum();

            $postsData = NULL;
            $postsData = $unreadNotificationData->map(function ($itemTwo, $indexTwo) use($unreadNotifications,$readNotifications) {
                if($itemTwo->postMapping){
                    if($itemTwo->postMapping->valid_till>=today()){
                        if($itemTwo->is_post_read_by_user == 0){
                            return [
                                    'post_type' => $itemTwo->postMapping->post_type,
                                    'post_id' => $itemTwo->postMapping->id,
                                    'post_data' =>  $itemTwo->postMapping->post_data,
                                    'valid_till' =>  $itemTwo->postMapping->valid_till,
                            ];
                        }
                    }
                }
            });

            $userData =  [
                'id' => $user->id,
                'postData' => $postsData,
                'read_notifications' => $readNotifications,
                'unread_notifications' => $unreadNotifications,
            ];

        }
        if($userData){
            return view('post-read-by-user')->with(['data'=>$post,'notification_data'=>$userData]);
        }else{
            return view('post-read-by-user')->with('data',null);
        }
        
    }

    public function notificationRead($userId,$postId){
        $post = Posts::findOrFail($postId);
        $user = User::findOrFail($userId);

        PostsUserMapping::where('post_id',$postId)->where('user_id',$userId)->update(['is_post_read_by_user' => 1]);

        return view('user-post-read')->with('data',$post);
    }
}
