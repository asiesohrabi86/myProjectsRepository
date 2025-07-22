@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# اوه!
@else
# سلام!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ str_replace([
    'برای تایید ایمیل خود بر روی دگمه ی زیر کلیک کنید',
    'اگر شما حساب کاربری را ایجاد نکردید، نیاز به انجام هیچ عملی نیست.'
], [
    'برای تایید ایمیل خود روی دکمه زیر کلیک کنید.',
    'اگر شما این حساب کاربری را ایجاد نکرده‌اید، نیاز به انجام هیچ کاری نیست.'
], $line) }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText == 'تایید ایمیل' ? 'تایید ایمیل' : $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
با احترام،<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@if($actionText == 'تایید ایمیل')
اگر با کلیک روی دکمه «تایید ایمیل» مشکل دارید، لینک زیر را کپی و در مرورگر خود وارد کنید:
@else
اگر با کلیک روی دکمه «{{ $actionText }}» مشکل دارید، لینک زیر را کپی و در مرورگر خود وارد کنید:
@endif
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
