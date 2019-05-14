    <meta charset="UTF-8">

    <meta name=description content="">

    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
    <base href="{{\URL::to('/')}}">

    <script type='text/javascript' >
        var show_console_logs = {{config('vaahcms.show_console_logs')}};
    </script>