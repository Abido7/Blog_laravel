@if ($errors->any())
    <ul>

        @foreach ($errors->all() as $error)

            <p class="text-danger text-center">{{ $error }}*</p>

        @endforeach

    </ul>
@endif
@if (session('msg'))
    <p class="text-danger text-center">{{ session('msg') }}</p>
@endif
