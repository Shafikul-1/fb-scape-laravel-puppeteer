<x-body>


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    {{-- <form method="POST" action="{{ route('link.multiwork') }}" >
        <div class="flex gap-4 my-4">
            @csrf
            <button type="submit" name="action" value="complete" class="capitalize dark:text-white font-bold text-3xl bg-gray-500 px-5 py-1 rounded-md my-2 hover:bg-gray-900 cursor-pointer">complete</button>
            <button type="submit" name="action" value="complete" class="capitalize dark:text-white font-bold text-3xl bg-gray-500 px-5 py-1 rounded-md my-2 hover:bg-gray-900 cursor-pointer">delete</button>
        </div> --}}

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkAll" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkAll" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    SR:
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Check
                </th>
                <th scope="col" class="px-6 py-3">
                    Link
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($allLinks as $key => $link)
                <tr class="{{ ($link->check == 'valid') ? 'bg-white' : 'bg-red-500' }}  border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input value="{{ $link->id }}" name="linkId[]" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 link-checkbox">
                            <label class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $link->id }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $link->status }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $link->check }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $link->link }}
                    </td>
                    <td class="flex items-center px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('link.destroy', $link->id) }}" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3 capitalize">remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
{{-- </form> --}}

    {{ $allLinks->links() }}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.link-checkbox');

        checkAll.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
            });
        });
    });
</script>

</x-body>
