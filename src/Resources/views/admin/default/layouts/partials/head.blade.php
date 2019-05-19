    <meta charset="UTF-8">

    <meta name=description content="">

    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <meta name="current-url" id="current_url" content="{{ url()->current() }}">
    <meta name="debug" id="debug" content="{{config('vaahcms.debug')}}">

    <base href="{{\URL::to('/')}}">