<x-app-layout>
<div class="relative items-top min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            <a href="{{ route('posts') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Posts</a>
            <a href="{{ route('all.users') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Users</a>
                 
        </div>
           
    <x-slot name="header">
        <div style="display:inline-block; width:50%" class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome') }}
        </div>
        <div style="float:right;" class="font-semibold text-xl text-gray-800 leading-tight">
        <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>Notification({{$data['unread_notifications']}})</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if($data['postData'])
                            @foreach($data['postData'] as $post)
                                @if($post)
                                <x-dropdown-link target="_blank" :href="route('post.update.user',['user_id' => $data['id'], 'post_id' => $post['post_id']])">
                                    {{$post['post_type']}}
                                </x-dropdown-link>
                                @endif
                            @endforeach
                        @endif
                        
                    </x-slot>
                    
                </x-dropdown>
            </div>
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   Welcome {{ $data['name']}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
