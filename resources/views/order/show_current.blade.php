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
            <div class="row">
                <div class="col-12">
                    @if(strlen($message) > 0)
                        <div class="alert alert-info text-center" role="alert" id="alert">{{$message}}</div>
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            Your order
                        </div>
                    </div>

                    <div class="card-body">

                        @if($order_items)
                            @foreach($order_items as $item)
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-6">{{$item['type']}}</div>
                                            <div class="col-6">{{$item['name']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        @foreach($item[1]['additions'] as $addition)
                                            <div class="row">
                                                <p class="fst-italic">{{$addition}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-2"><img src="{{asset('storage/'.$item['path'])}}" class="img-thumbnail" alt=""></div>
                                    <div class="col-2 text-center">{{$item['price']}} €</div>
                                    <div class="col-1">
                                        <div class="col-12 text-center">
                                            <div class="col-6 plus-minus" onclick="submitIncreaseAmountForm('amountIncreaseForm{{$item['name']}}')">
                                                <form action="{{route('amount.increase')}}" method="POST" id="amountIncreaseForm{{$item['name']}}">
                                                    @csrf
                                                    <i class="fa-solid fa-plus"></i>
                                                    <input type="hidden" name="product_name" value="{{$item['name']}}">
                                                </form>
                                            </div>
                                            <div class="col-6 plus-minus" onclick="submitDecreaseAmountForm('amountDecreaseForm{{$item['name']}}')">
                                                <form action="{{route('amount.decrease')}}" id="amountDecreaseForm{{$item['name']}}" method="POST">
                                                    @csrf
                                                    <i class="fa-solid fa-minus"></i>
                                                    <input type="hidden" name="product_name" value="{{$item['name']}}">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1">{{$item[0]['amount']}}</div>
                                    <div class="col-1 plus-minus" onclick="productRemove('productRemoveForm{{$item['name']}}')">
                                        <form action="{{route('product.remove')}}" id="productRemoveForm{{$item['name']}}" method="POST">
                                            @csrf
                                            <i class="fa-solid fa-trash"></i>
                                            <input type="hidden" name="product_name" value="{{$item['name']}}">
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row mt-5">
                                <div class="col-10">
                                    <p class="float-end fs-5">Total price: {{$total_price}}€</p>
                                </div>
                                <div class="col-2">
                                    <form action="{{route('order.store')}}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-success float-end">Make Order</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-8 offset-2 fs-5 text-center">
                                    Your order bag is empty!
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

        function removeMessage(){
            setTimeout(() =>{
                let productWithAdditionsAlert =  document.getElementById('alert');
                if(productWithAdditionsAlert){
                    productWithAdditionsAlert.classList.add('d-none');
                }
            },4000);
        }

        removeMessage();
    </script>
@endsection
