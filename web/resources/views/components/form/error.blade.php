@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger {{ $class }}" role="alert" {{ $attributes }}>
            {{ $error }}
        </div>
    @endforeach
@endif