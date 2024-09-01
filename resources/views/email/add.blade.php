<x-body>
    <div class="dark:bg-gray-700 py-5">
    @php
        $fieldClass =
            'my-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500';
    @endphp
    <x-form action="{{ route('emails.store') }}" class="ok" id="x" :fields="[
        [
            'type' => 'text',
            'name' => 'email',
            'placeholder' => 'Enter Sender Emails',
            'title' => 'Enter Sender Emails',
            'class' => $fieldClass,
            'label' => 'Enter Sender Emails',
        ],
        [
            'type' => 'text',
            'name' => 'email_subject',
            'placeholder' => 'Enter email_subject',
            'title' => 'Enter email_subject',
            'class' => $fieldClass,
            'label' => 'Enter email_subject',
        ],
        [
            'type' => 'text',
            'name' => 'email_body',
            'placeholder' => 'Enter email_body',
            'title' => 'Enter email_body',
            'class' => $fieldClass,
            'label' => 'Enter email_body',
        ],
        [
            'type' => 'file',
            'name' => 'email_files',
            'placeholder' => 'Enter email_files',
            'title' => 'Enter email_files',
            'class' => $fieldClass,
            'label' => 'Enter email_files',
        ],
        [
            'type' => 'datetime-local',
            'name' => 'sending_time',
            'placeholder' => 'Enter sending_time',
            'title' => 'Enter sending_time',
            'class' => $fieldClass,
            'label' => 'Enter sending_time',
        ],
    ]"
        class="font-[sans-serif] max-w-4xl mx-auto mt-10" enctype="multipart/form-data">
        <div class="">
            <div class="flex justify-between">
                <div class="">
                    <label for="schedule_time" class="dark:text-white">Enter Schedule time</label>
                </div>

                <div class="flex">
                    <input type="checkbox" name="random_time" id="random_time" title="Random Time">
                    <label for="random_time" class="dark:text-white ml-4">Random Time</label>
                </div>
            </div>
            <input type="text" id="schedule_time" name="schedule_time" class="{{ $fieldClass }}" value="{{ old('schedule_time') }}" placeholder="Enter Schedule time" title="Enter Schedule time">
            @error('schedule_time')
            <p class="text-red-600" style="text-shadow:3px 5px 4px black">{{ $message }}</p>
            @enderror
        </div>


        <button type="submit" class="mt-8 px-6 py-2.5 text-sm w-full bg-[#007bff] hover:bg-[#006bff] text-white rounded transition-all">Submit</button>
    </x-form>


</div>
</x-body>
