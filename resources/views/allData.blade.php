<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
</head>
<body>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="pb-4 bg-white dark:bg-gray-900">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        url
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Website
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Address
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Mobile
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['postDetails']['name'] }}
                    </th>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['postDetails']['timeText'] }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['postDetails']['url'] }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['contactDetails']['Website'] ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['contactDetails']['Address'] ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        @php
                            $mobile = $data['contactDetails']['Mobile'] ?? 'N/A';
                            if (Str::startsWith($mobile, '+')) {
                                $mobile = substr($mobile, 1);
                            }
                        @endphp
                        {{ $mobile }}
                        {{-- {{ $data['contactDetails']['Mobile'] ?? 'N/A' }} --}}
                        {{-- {{ starts_with($data['contactDetails']['Mobile'] ?? '', '+') ? substr($data['contactDetails']['Mobile'], 1) : ($data['contactDetails']['Mobile'] ?? 'N/A') }} --}}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['contactDetails']['Email'] ?? 'N/A' }}
                    </td>
                </tr>
                @endforeach
            </tbody>

            <script>
            function selectAndCopy(element) {
                // Get the text content of the element
                const text = element.textContent.trim();

                // Create a temporary range and select the text node
                const range = document.createRange();
                const selection = window.getSelection();

                // Clear any previous selections
                selection.removeAllRanges();

                // Select the text within the element
                range.selectNodeContents(element);
                selection.addRange(range);

                // Copy the selected text to the clipboard
                navigator.clipboard.writeText(text).then(function() {
                    console.log('Text copied to clipboard: ', text);
                }).catch(function(err) {
                    console.error('Failed to copy text: ', err);
                });
            }
            </script>



</body>
</html>
