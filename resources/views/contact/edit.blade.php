<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert-sucess>
                {{session('success')}}
            </x-alert-sucess>
            <div class="bg-white my-6 p-6 dark:bg-gray-800 border-gray-200  shadow-sm sm:rounded-lg">

                <form action="{{route('contact.update',$contact)}}" method="post">
                    @method('put')
                    @csrf
                    <x-text-input type="text" name="first_name" placeholder="FirstName..."  class="w-full mt-2" autocomplete="off" required :value="@old('first_name',$contact->first_name)"></x-text-input>

                    <x-text-input type="text" name="last_name" placeholder="Last Name..."  class="w-full mt-2" autocomplete="off" required :value="@old('last_name',$contact->last_name)"></x-text-input>

                    <x-text-input type="tel" name="phone_number" placeholder="Mobile Number..."  class="w-full mt-2" autocomplete="off" required :value="@old('phone_number',$contact->phone_number)"></x-text-input>
                    <x-text-input type="email" name="email" placeholder="Email..."  class="w-full mt-2" autocomplete="off" required :value="@old('email',$contact->email)"></x-text-input>

                    <x-text-area name="description" rows="6" placeholder="Description" class="w-full mt-6" required :value="@old('description',$contact->description)"></x-text-area>
                    <x-primary-button class="mt-6">Save Contact</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
