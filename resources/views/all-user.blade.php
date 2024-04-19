<x-app-layout>
    
    <div class="relative items-top min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            <a href="{{ route('posts') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Posts</a>
            <a href="{{ route('all.users') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Users</a>
                 
        </div>
           
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
        </x-slot>
 
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-success-message class="mb-4"/>
                
                @if($data)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <table class="w-full whitespace-no-wrapw-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-center font-bold">
                                        <td class="border px-6 py-4">Count</td>
                                        <td class="border px-6 py-4">Name</td>
                                        <td class="border px-6 py-4">Email</td>
                                        <td class="border px-6 py-4">Mobile No</td>
                                        <td class="border px-6 py-4">Show Notification</td>
                                        <td class="border px-6 py-4">Unread Notification Count</td>
                                    </tr>
                                </thead>
                                
                                @foreach($data as $id=>$user) 
                                    <tr>
                                        <td class="border px-6 py-4">{{$count=$id+1}}</td>
                                        <td class="border px-6 py-4"><a href="{{ route('imporsonate.user', $user['id']) }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">{{$user['name']}}</a></td>
                                        <td class="border px-6 py-4">{{$user['email']}}</td>
                                        <td class="border px-6 py-4">{{$user['mobile_no']}}</td>
                                        <td class="border px-6 py-4">
                                            @if($user['notification_switch'])
                                                On
                                            @else
                                                Off
                                            @endif
                                        </td>
                                        <td class="border px-6 py-4">{{$user['unread_notifications']}}</td>
                                        <td class="border px-6 py-4"><a href="{{ route('edit.post', $user['id']) }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Edit</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        
                        </div>
                        
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