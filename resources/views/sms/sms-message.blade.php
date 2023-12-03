<x-app-layout>

<x-slot name="header">
    @if(request()->routeIs('bulk-sms'))
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BULK SMS') }}
        </h2>
    @endif
    @if(request()->routeIs('sms'))
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SMS') }}
        </h2>
    @endif
</x-slot>
{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <x-alert-sucess>--}}
{{--                {{session('success')}}--}}
{{--            </x-alert-sucess>--}}
{{--            <div class="bg-white my-6 p-6 dark:bg-gray-800 border-gray-200  shadow-sm sm:rounded-lg">--}}

{{--                <form action="{{route('send-sms')}}" method="post">--}}
{{--                    @csrf--}}

{{--                    <x-text-input type="text" name="phone_number" placeholder="Recipient Phone Number or Email..."  class="w-full mt-2" autocomplete="off" required :value="@old('title')"></x-text-input>--}}
{{--                    @error('title')--}}
{{--                    <div class="text-red-600 tex-sm">{{$message}}</div>--}}
{{--                    @enderror--}}
{{--                    <x-text-area name="message" rows="10" placeholder="Enter Your Message..." class="w-full mt-6" required :value="@old('text')"></x-text-area>--}}
{{--                    @error('text')--}}
{{--                    <div class="text-red-600 tex-sm">{{$message}}</div>--}}
{{--                    @enderror--}}
{{--                    <x-primary-button class="mt-6">Send SMS</x-primary-button>--}}

{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert-sucess>
                {{session('success')}}
            </x-alert-sucess>
            <div class="bg-white my-6 p-6 dark:bg-gray-800 border-gray-200  shadow-sm sm:rounded-lg">
                <nav class="bg-green-200 w-fit p-2 align-middle rounded-lg flex justify-center items-center mb-3 mt-2 m-auto ">
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <a href="#phoneNumber" ><button class="rounded-md bg-white text-1xl p-2 shadow-md border">Enter Number</button></a>
                        </div>
                        <div>
                            <a href="#selectContact" ><button class="rounded-md bg-white text-1xl p-2 shadow-md border">Select Contact</button></a>
                        </div>
                        <div>
                                <select id="messageTemplate"  name="selectMessageTemplate" class="p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring focus:border-indigo-300 transition duration-300" name="phone_number_selected" id="SelectedNumber">
                                    <option value="">Template </option>
                                    @foreach ($messageTemplates as $messageTemplate)
                                        <option value="{{$messageTemplate -> content}}">
                                            {{$messageTemplate->title}}
                                        </option>
                                    @endforeach
                                </select>
                        </div>

                        <div>
                            <a href="#phone_number" ><button class="rounded-md bg-white text-1xl p-2 shadow-md border">Add Contact</button></a>
                        </div>


                    </div>
                </nav>
                @if(request()->routeIs('sms'))
                    <div id="sms">
                        <form action="{{ route('send-sms') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="">
                                    <label for="selectContact"></label>
                                    <select id="selectContact"  name="selectContact" class="p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring focus:border-indigo-100 transition duration-300" name="phone_number_selected" id="SelectedNumber">
                                        <option value='{"contact":"","first_name":"","last_name":""}'>Select a number</option>
                                        @foreach ($contacts as $contact)
                                            <option value='{"contact": "{{$contact->phone_number}}","first_name":"{{$contact->first_name}}","last_name":"{{$contact->last_name}}" }'>
                                                {{$contact->first_name}} {{$contact -> last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="flex flex-row mb-0">
                                        <x-text-input type="text" name="phone_number" id="phoneNumber" placeholder="Type a phone number in international format. For example: +23354159968"
                                                      class="w-full mt-2" autocomplete="off" required :value="@old('title')"></x-text-input>
                                        <select class="w-fit h-fit mt-2 border  rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 transition duration-300" name="country_code" id="country_code" placeholder="Countrycode">
                                            <option value="">Code</option>
                                            <option value="+233">GH</option>
                                            <option value="+234">NGR</option>
                                            <option value="+1">USA</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <x-text-area name="message" id="message" rows="6" placeholder="Enter your message here..." class="w-full mt-6" ></x-text-area>
                                    </div>
                                    <x-primary-button class="mt-6">Send SMS</x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                @if(request()->routeIs('bulk-sms'))
                    <div id="bulksms" >
                        <form action="{{ route('send-bulk-sms') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="">
                                    <label for="selectContact">Select Contacts</label>
                                    <select id="selectContact" multiple   class=" form-control contact p-2 w-full border rounded-md shadow-sm focus:outline-none focus:ring focus:border-indigo-100 transition duration-300" name="phone_number_selected[]" id="SelectedNumber">
                                        @foreach ($contacts as $contact)
                                            <option value='{"contact": "{{$contact->phone_number}}","first_name":"{{$contact->first_name}}","last_name":"{{$contact->last_name}}" }'>
                                                {{$contact->first_name}} {{$contact -> last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="flex flex-row mb-0">
                                        <x-text-input type="text" name="phone_number" id="phoneNumber" placeholder="Type a phone number in international format separated by commas. For example: +23354159968,+233245968478"
                                                      class="w-full mt-2" autocomplete="off" required :value="@old('title')"></x-text-input>
                                        <select class="w-fit h-fit mt-2 border  rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 transition duration-300" name="country_code" id="country_code" placeholder="Countrycode">
                                            <option value="">Code</option>
                                            <option value="+233">GH</option>
                                            <option value="+234">NGR</option>
                                            <option value="+1">USA</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <x-text-area name="message" id="message" rows="6" placeholder="Enter your message here..." class="w-full mt-6" ></x-text-area>
                                    </div>
                                    <x-primary-button class="mt-6">Send SMS</x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <script>
        const selectNumber = document.getElementById("selectContact");
        const inputNumber = document.getElementById("phoneNumber");

        selectNumber.addEventListener("change", function () {

            let selectedOption = JSON.parse(selectNumber.value);
            console.log(selectedOption); // Debugging line

            inputNumber.value = selectedOption.contact;
        });

        const selectedTemplate = document.getElementById("messageTemplate");
        const messageInput = document.getElementById("message");

        selectedTemplate.addEventListener("change", function () {
            messageInput.value = selectedTemplate.value;
        });

        // const smsButton = document.getElementById('smsType')
        // smsButton.addEventListener('click',(e)=>toggleView(e))
        //
        //
        // function toggleView(e) {
        //     e.preventDefault()
        //     const viewType = document.getElementById('smsType').value;
        //     const smsView = document.getElementById('sms');
        //     const bulksmsView = document.getElementById('bulksms');
        //
        //     if (viewType === 'sms') {
        //         smsView.style.display = 'block';
        //         bulksmsView.style.display = 'none';
        //         smsButton.value = 'Bulk SMS'
        //         smsButton.textContent='Bulk SMS'
        //     } else {
        //         smsButton.value = 'sms';
        //         smsButton.textContent='SMS'
        //         smsView.style.display = 'none';
        //         bulksmsView.style.display = 'block';
        //     }
        // }
    </script>
</x-app-layout>
