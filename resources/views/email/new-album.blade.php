@extends('layouts.email')

@section('content')
    <h1>New Album</h1>
    <p>
        {{ $album->artist->name }} has a new album called {{ $album->title }}
    </p>
@endsection 
