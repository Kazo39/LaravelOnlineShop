<x-mail::message>
# Introduction

Dear, {{$user->name}}

    Your order is successfully made.
    Order:
    @foreach($orders as $order)
                Name: {{$order['name']}}
                Price: {{$order['price']}}€
                Amount: {{$order[0]['amount']}}

    @endforeach
    Total price is {{$total_price}}€
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

{{--<div>--}}
{{--    Dear {{$user->name}}--}}

{{--    Your order is successfully made.--}}
{{--    Your order:--}}
{{--        @foreach($orders as $order)--}}
{{--            Name: {{$order['name']}}--}}
{{--            Price: {{$order['price']}}--}}
{{--            Amount: {{$order[0]['amount']}}--}}
{{--        <hr>--}}
{{--       @endforeach--}}
{{--</div>--}}
