@component('vaahcms::mails.layout')

    {{-- Header --}}
    @slot('header')
        @component('vendor.mail.html.header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    @slot('subcopy')
        @isset($message)
        {{ Illuminate\Mail\Markdown::parse($message) }}
        @endisset
    @endslot

    {{-- Footer --}}
    @slot('footer')
        @component('vendor.mail.html.footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot


@endcomponent
