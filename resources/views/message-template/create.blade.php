<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Message Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white my-6 p-6 dark:bg-gray-800 border-gray-200  shadow-sm sm:rounded-lg">
                <div class="m-2 p-2 bg-gray-100 rounded-md"><p class="text-md ">Template Creation</p></div>

            <form action="{{route('templates.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <x-text-input type="text" name="templateName" id="templateName" placeholder="Enter the template name"
                                  class="w-full mt-2" autocomplete="off" required :value="@old('templateName')"></x-text-input>
                    <div class="">
                        <x-text-area name="content" id="templateContent" rows="6" placeholder="Enter your message here..." class="w-full mt-6" ></x-text-area>
                    </div>
                </div>
                <div class="flex flex-row gap-2">

                    <select class="w-full h-fit mt-2 border  rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 transition duration-300" name="variable" id="variable" >
                       <option>Select a Variable</option>
                        @foreach($message_variables as $variable)
                            <option value="{{ $variable->variable }}">{{$variable->variable}}</option>
                        @endforeach
                    </select>
{{--                    <x-primary-button class="text-sm" id="insertButton">Insert Variable</x-primary-button>--}}
                    <button id="insertButton" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Insert Variable
                    </button>
                </div>

                <x-primary-button class="mt-2">Add Template</x-primary-button>
            </form>
            </div>
        </div>
    </div>
    <script>
        const button = document.getElementById('insertButton')

        const insertVariable = (e) =>{
            e.preventDefault();
            const textArea = document.getElementById('templateContent');
            const selectArea  = document.getElementById('variable');
            const variable =  selectArea.value;
            if (variable) {
                const cursorPosition = textArea.selectionStart;
                const currentValue = textArea.value;
                const newValue = currentValue.substring(0,cursorPosition) + variable + currentValue.substring(cursorPosition);
                textArea.value = newValue;
            }
        }
        button.addEventListener("click",(e)=> insertVariable(e))
    </script>


</x-app-layout>
