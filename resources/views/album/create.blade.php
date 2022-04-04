@extends('layouts.main')

@section('title', 'New Album')

@section('content')
    <form method='POST' action='{{ route('album.store') }}'>
        @csrf
        <div class='mb-3'>
            <label for='title' class='form-label'>Title</label>
            <input id='title' type='text' class='form-control' name='title' value='{{ old('title') }}'/>
            @error('title')
            <p class='text-danger'> {{ $message }}</p>
            @enderror
        </div>

        <div class='mb-3'>
            <label for='artist' class='form-label'>Artist</label>
            <select name='artist' id='artist' class='form-select'>
                <option value=''>-- Select Artist --</option>
                @foreach($artists as $artist)
                    <option
                        value='{{ $artist->id }}' {{ (string)$artist->id === (string)old('artist') ? 'selected' : ''}}>
                        {{ $artist->name }}
                    </option>
                @endforeach
            </select>
            @error('artist')
            <p class='text-danger'> {{ $message }}</p>
            @enderror
        </div>

        <button type='submit' class='btn btn-primary'>Save</button>
    </form>
@endsection
