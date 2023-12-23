<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Upload') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert-sucess>
                {{session('success')}}
            </x-alert-sucess>
            <div class="bg-white my-6 p-6 dark:bg-gray-800 border-gray-200  shadow-sm sm:rounded-lg">

                <form action="{{route('upload.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="upload" class="w-full mt-2">
{{--                    <x-text-input type="file" name="upload" placeholder="Select a File"  class="w-full mt-2"></x-text-input>--}}
                    <x-primary-button class="mt-6">Save Contact</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
