
<x-app-layout>
    
    <div class="relative items-top min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            <a href="{{ route('posts') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Posts</a>
            <a href="{{ route('all.users') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Users</a>
                 
        </div>
           
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
            
                            
                    <form method="POST" action="{{ route('create.post') }}">
                        @csrf

                        <div>
                            <x-label for="name" :value="__('Post Type')" />
                            <select class="border-gray-300 shadow-sm rounded-md block mt-1 w-full form-select" name="notification_type" id="exampleDropdown" required>
                                <option selected>--Select--</option>
                                <option value="marketing">Marketing</option>
                                <option value="invoices">Invoices</option>
                                <option value="system">System</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label :value="__('Post Data')" />

                            <x-input class="block mt-1 w-full" type="text" name="post_data" required />
                        </div>

                        <div class="mt-4">
                            <x-label :value="__('End Date')" />

                            <x-input class="block mt-1 w-full" type="date" name="end_date" required />
                        </div>

                        <div class="mt-4">
                            <x-label :value="__('Users')" />

                            <select class="border-gray-300 shadow-sm rounded-md block mt-1 w-full form-select" name="user_ids" id="exampleDropdown">
                                <option selected>--Select--</option>
                                <option value="all">All</option>
                                @if($data)
                                    @foreach($data as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

            
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create Post') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
    
        </div>
    </div>
</x-app-layout>