
<x-app-layout>
    
    <div class="relative items-top min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            <a href="{{ route('posts') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Posts</a>
            <a href="{{ route('all.users') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Users</a>
                 
        </div>
           
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        {{$data->post_type}}
                    </div>

                    <div class="mt-4">
                        {{$data->post_data}}
                    </div>

                    <div class="mt-4">
                        
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        {{ \Carbon\Carbon::parse($data->valid_till)->format('d-m-Y') }}
                    </div>
                    
                </div>
            </div>
    
        </div>
    </div>
</x-app-layout>