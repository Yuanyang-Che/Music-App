@extends('layouts.main')

@section('title', 'Blocked')

@section('content')
    <p>Hello, {{ Auth::user()->name }}. You have been blocked.</p>
@endsection
