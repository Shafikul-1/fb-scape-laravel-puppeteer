@props(['action', 'method' => 'POST', 'fields' => []])

<form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" {{ $attributes }}>

    @csrf
    @unless (in_array($method, ['GET', 'POST']))
        @method($method)
    @endunless

    <div class="grid gap-6 mb-6 md:grid-cols-2">

        @foreach ($fields as $field)
            <div>
                @if (isset($field['label']))
                    <label for="{{ $field['name'] }}"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
                @endif

                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                    @php
                        if (isset($field['id'])) echo " id=\"{$field['id']}\"";
                        if (isset($field['placeholder'])) echo " placeholder=\"{$field['placeholder']}\"";
                        if (isset($field['maxlength'])) echo " maxlength=\"{$field['maxlength']}\"";
                        if (isset($field['class'])) echo " class=\"{$field['class']}\"";
                        if (isset($field['autocomplete'])) echo " autocomplete=\"{$field['autocomplete']}\"";
                        if (isset($field['title'])) echo " title=\"{$field['title']}\"";
                        if (isset($field['multiple'])) echo " multiple";
                        if (isset($field['disabled'])) echo " disabled";
                        if (isset($field['value'])) echo " value=\"{$field['value']}\"";
                        if (isset($field['required'])) echo " required";
                        if (isset($field['readonly'])) echo " readonly";

                    @endphp
                        value="{{ old($field['name']) }}"
                        {{-- @if (isset($field['attributes']))
                            {!! $field['attributes'] !!}
                        @endif --}}
                >

                @error($field['name'])
                    <p class="text-red-600" style="text-shadow:3px 5px 4px black">{{ $message }}</p>
                @enderror

            </div>
        @endforeach
    </div>


    {{ $slot }}
</form>
