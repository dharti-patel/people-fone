<x-app-layout>
    
    <div class="relative items-top min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            <a href="{{ route('posts') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Posts</a>
            <a href="{{ route('all.users') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Users</a>
                 
        </div>
           
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Posts') }}
            </h2>
        </x-slot>
 
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-success-message class="mb-4"/>
                <a href="{{ route('post.create.page') }}" class="mb-4 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                    Create Post
                </a>

                @if($data)
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <table class="w-full whitespace-no-wrapw-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-center font-bold">
                                        <td class="border px-6 py-4">Count</td>
                                        <td class="border px-6 py-4">Post Type</td>
                                        <td class="border px-6 py-4">Post Data</td>
                                        <td class="border px-6 py-4">End Date</td>
                                        <td class="border px-6 py-4">Users</td>
                                        <td class="border px-6 py-4">Edit</td>
                                    </tr>
                                </thead>
                                
                                @foreach($data as $id=>$post) 
                                    <tr>
                                        <td class="border px-6 py-4">{{$count=$id+1}}</td>
                                        <td class="border px-6 py-4">{{$post->post_type}}</td>
                                        <td class="border px-6 py-4">{{$post->post_data}}</td>
                                        <td class="border px-6 py-4">{{ \Carbon\Carbon::parse($post->valid_till)->format('d-m-Y') }}</td>
                                        <td class="border px-6 py-4">
                                            @if($post->postUserData)
                                                <ul>
                                                    @foreach($post->postUserData as $userData)
                                                        <li>{{ $userData->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                No Users Mapped
                                            @endif
                                        </td>
                                        <td class="border px-6 py-4"><a href="{{ route('edit.post', $post->id) }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Edit</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        
                        </div>
                        {{ $data->links() }}
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            No Posts Found
                        </div>
                    </div>
                @endif
            </div>
        </div>
    
    </div>
</x-app-layout>