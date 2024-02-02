@component('vendor.mail.html.layout')
    @slot('header')
        @component('vendor.mail.html.header', ['url' => config('app.url')])
            <x-mail::header :url="config('app.url')">
                {{ config('app.name') }}
            </x-mail::header>
        @endcomponent
    @endslot
        <div>
            {{ $user->name }}
        </div>
    @slot('footer')
        @component('vendor.mail.html.footer')
        @endcomponent
    @endslot
@endcomponent
