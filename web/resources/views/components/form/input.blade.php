@if ($label)
    <label for="{{ $id }}">{{ $label }}</label>
@endif
<input class="form-control {{ $class }}" id="{{ $id }}" aria-describedby="{{ $id_small }}" {{ $attributes }} />
@if ($small)
    <small id="{{ $id_small }}" class="form-text text-muted">{{ $small }}</small>
@endif