<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BIRTHDAY') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl font-bold mb-6">Add Birthday</h2>

                <form method="POST" action="{{ route('birthdays.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="contact" class="block text-gray-700 text-sm font-bold mb-2">Contact Details:</label>
                        <select id="contact" name="contact" class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach($contacts as $contact)
                                <option value="{{$contact->id}}">{{$contact->first_name}} {{$contact->last_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="message_template" class="block text-gray-700 text-sm font-bold mb-2">Message Template:</label>
                        <select id="message_template" name="message_template" class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach($message_templates as $message_template)
                                <option value="{{$message_template->content}}">{{$message_template->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="date_of_birth" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth:</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Birthday</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
