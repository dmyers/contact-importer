<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script>
    window.App = {!! collect(compact('core_fields'))->toJson() !!};
    </script>
</head>
<body>
    <div id="app" class="mt-3 mt-md-5 mb-3 mb-md-5">
        <div class="container">
            <div class="row">
                <div class="col-8 offset-2">
                    <router-view />
                </div>
            </div>
        </div>
    </div>

    @if (app()->isLocal() && env('MIX_HOT_RELOAD'))
        <script src="http://localhost:8080/js/app.js"></script>
    @else
        <script src="{{ mix('js/app.js') }}"></script>
    @endif
</body>
</html>
