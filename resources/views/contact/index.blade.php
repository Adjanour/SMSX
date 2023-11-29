<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <p class="text-3xl font-bold dark:text-white">Contacts</p>
            <div class="w-fit">
                <label for="viewType" class="mr-2 dark:text-white">Select View:</label>
                <select id="viewType" onchange="toggleView()" class="p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 transition duration-300">
                    <option value="table">Table View</option>
                    <option value="card">Card View</option>
                </select>
            </div>
        </div>

        <div id="tableView">
            @if($contacts->count() > 0)
                <div class="overflow-x-auto rounded-md" >
                    <table class="min-w-full bg-white border border-gray-300 tab rounded-md">
                        <thead>
                        <tr class="table-row">
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Phone Number</th>
                            <th class="py-2 px-4 border-b">Email Address</th>
                            <th class="py-2 px-4 border-b">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr class="table-row">
                                <td class="py-2 px-6 border-b">{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                <td class="py-2 px-6 border-b">{{ $contact->phone_number }}</td>
                                <td class="py-2 px-6 border-b">{{ $contact->email }}</td>
                                <td class="py-2 px-6 border-b">
                                    <a class="bg-blue-500 text-white py-1 px-2 rounded-md hover:bg-blue-700 transition duration-300" href="{{ route('contact.edit', $contact) }}">Edit</a>
                                    <button class="bg-red-500 text-white py-1 px-2 rounded-md hover:bg-red-700 transition duration-300" onclick="deleteContact({{ $contact->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-lg">You have no contacts yet.</p>
            @endif
        </div>

        <div id="cardView" class="hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($contacts as $contact)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold">{{ $contact->first_name }} {{ $contact->last_name }}</h2>
                        <p class="text-gray-600">{{ $contact->phone_number }}</p>
                        <p class="text-gray-600">{{ $contact->email }}</p>
                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('contact.edit', $contact->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <button onclick="deleteContact({{ $contact->id }})" class="ml-4 text-red-500 hover:text-red-700">Delete</button>
                        </div>
                    </div>
                @empty
                    <p class="text-lg">You have no contacts yet.</p>
                @endforelse
            </div>
        </div>

        <a href="{{ route('contact.create') }}">
            <x-primary-button class="mt-6">+ Add Contact</x-primary-button>
        </a>
    </div>

    <script>
        function deleteContact(contactId) {
            if (confirm('Are you sure you want to delete this contact?')) {
                // Send an Ajax request to delete the contact
                axios.delete('/contact/' + contactId)
                    .then(function (response) {
                        // Update the table or cards on success
                        window.location.reload();
                    })
                    .catch(function (error) {
                        console.error('Error deleting contact:', error);
                    });
            }
        }

        function toggleView() {
            const viewType = document.getElementById('viewType').value;
            const tableView = document.getElementById('tableView');
            const cardView = document.getElementById('cardView');

            if (viewType === 'table') {
                tableView.style.display = 'block';
                cardView.style.display = 'none';
            } else {
                tableView.style.display = 'none';
                cardView.style.display = 'block';
            }
        }
    </script>
</x-app-layout>
