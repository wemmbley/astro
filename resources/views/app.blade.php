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
    @isset($page['props']['seo'])
        <article style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0)">
            {!! $page['props']['seo'] !!}
        </article>
    @endisset
    <x-inertia::app />
</body>
</html>
