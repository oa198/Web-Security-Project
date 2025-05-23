@extends('layouts.master')

@section('title', 'University Portal')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>React + Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/frontend/src/main.tsx'])
</head>
<body>
    <div id="root"></div>
</body>
</html>

@endsection
