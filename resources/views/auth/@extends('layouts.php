@extends('layouts.app')

@section('title', 'Home Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <h1>Welcome to Home</h1>
    <p>Content-ka bogga home halkan.</p>
@endsection

@push('scripts')
<script>
    console.log("Home page script loaded!");
</script>
@endpush
