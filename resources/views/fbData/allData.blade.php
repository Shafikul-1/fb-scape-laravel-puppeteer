<x-body>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="pb-4 bg-white dark:bg-gray-900">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for items">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-all-search" class="sr-only">Select All</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Time</th>
                    <th scope="col" class="px-6 py-3">URL</th>
                    <th scope="col" class="px-6 py-3">Website</th>
                    <th scope="col" class="px-6 py-3">Address</th>
                    <th scope="col" class="px-6 py-3">Mobile</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allData as $data)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-{{ $data['id'] }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-{{ $data['id'] }}" class="sr-only">Select</label>
                        </div>
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['allInfo']['postDetails']['name'] ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['allInfo']['postDetails']['timeText'] ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        @if (!empty($data['allInfo']['postDetails']['url']))
                            {{-- <a href="{{ $data['allInfo']['postDetails']['url'] }}" class="text-blue-600 dark:text-blue-500" target="_blank" rel="noopener noreferrer"></a> --}}
                            {{ $data['allInfo']['postDetails']['url'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['allInfo']['contactDetails']['Website'] ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['allInfo']['contactDetails']['Address'] ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        @php
                            $mobile = $data['allInfo']['contactDetails']['Mobile'] ?? 'N/A';
                            if (Str::startsWith($mobile, '+')) {
                                $mobile = substr($mobile, 1);
                            }
                        @endphp
                        {{ $mobile }}
                    </td>
                    <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer" onclick="selectAndCopy(this)">
                        {{ $data['allInfo']['contactDetails']['Email'] ?? 'N/A' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function selectAndCopy(element) {
            const text = element.textContent.trim();
            const range = document.createRange();
            const selection = window.getSelection();
            selection.removeAllRanges();
            range.selectNodeContents(element);
            selection.addRange(range);

            navigator.clipboard.writeText(text).then(() => {
                console.log('Text copied to clipboard: ', text);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
</x-body>
