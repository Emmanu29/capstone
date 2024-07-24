<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title !== "" ? $title : 'Animal System'}}</title>
    <link href="{{ asset('/build/assets/app-83f76dfa.css') }}" rel="stylesheet">
    <script src="{{ asset('/build/assets/app-a5991337.js') }}"></script>
    @vite('resources/css/app.css') 
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body style="background: linear-gradient(to bottom right, rgba(118, 171, 174, 1), rgba(255, 255, 255, 1))">
<x-messages/>


<style>
    .left-background,
    .right-background {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%; /* Adjust the width of the image */
        background-repeat: no-repeat;
        background-size: cover;
        z-index: -1;
    }

    .left-background {
        left: 800px;
        background-image: url('{{ asset('images/paws.png') }}');
    }

    .right-background {
        right: 950px;
        background-image: url('{{ asset('images/paws.png') }}');
    }
</style>

<div class="left-background"></div>
<div class="right-background"></div>
