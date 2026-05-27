<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('src/UI/Bootstrap/Bootstrap.js')
    {{ seo()->render() }}
    <x-inertia::head />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <x-inertia::app />
</body>
</html>
