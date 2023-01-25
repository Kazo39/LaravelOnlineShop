@extends('layouts.app')
@section('additional_css')
    <style>
        .plus-minus:hover{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            Your order
                        </div>
                    </div>

                    <div class="card-body">

                        @if($orders)
                            @foreach($orders as $order)
                                <div class="row mt-2">
                                    <div class="col-12">
                                        Created at: {{$order->date_created}}
                                    </div>
                                </div>
                                @foreach($order->order_items as $item)
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-6">{{$item->type}}</div>
                                                <div class="col-6">{{$item->name}}</div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <p>{{$item->additions}}</p>
                                        </div>
                                        <div class="col-2"><img src="{{asset('storage/'.$item->path)}}" class="img-thumbnail" alt=""></div>
                                        <div class="col-2 text-center">{{$item->price}} €</div>
                                        <div class="col-2">Amount: {{$item->amount}}</div>
                                    </div>
                                @endforeach
                                <div class="row mt-5 border-bottom">
                                    <div class="col-12">
                                        <p class="float-end fs-5">Total price: {{$order->total_price}}€</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-8 offset-2 fs-5 text-center">
                                    Your order history is empty!
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional_script')
    <script>
        function submitIncreaseAmountForm(form){
            document.getElementById(`${form}`).submit();
        }
        function submitDecreaseAmountForm(form){
            document.getElementById(`${form}`).submit();
        }
        function productRemove(form){
            document.getElementById(`${form}`).submit();
        }
    </script>
@endsection
