@extends('layouts.app')
@section('additional_css')
    <style>
        .image{
            width: 20rem;
            height: 13rem;
        }
        .other_image{
            content: url("{{asset('Storage/Images/otherImageBanner.PNG')}}");
        }
        .other_image:hover{
            content: url("{{asset('Storage/Images/otherImageBanner1.PNG')}}");
        }
        .food_image{
            content: url("{{asset('Storage/Images/foodImageBanner.PNG')}}");
        }
        .food_image:hover{
            content: url("{{asset('Storage/Images/foodImageBanner1.PNG')}}");
        }
        .drink_image{
            content: url("{{asset('Storage/Images/drinkImageBanner.PNG')}}");
        }
        .drink_image:hover{
            content: url("{{asset('Storage/Images/drinkImageBanner1.PNG')}}");
        }
        .snacks_image{
            content: url("{{asset('Storage/Images/snacksImageBanner.PNG')}}");
        }
        .snacks_image:hover{
            content: url("{{asset('Storage/Images/snacksImageBanner1.PNG')}}");
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Menu</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 offset-1">
                                <div class="card" style="width: 20rem;" onclick="allFood()">
                                    <img src="" class="card-img-top food_image image" alt="...">
                                    <div class="card-body">
                                        <p class="card-text">Food</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 offset-1">
                                <div class="card" style="width: 20rem;" onclick="allDrinks()">
                                    <img src="" class="card-img-top drink_image image" alt="...">
                                    <div class="card-body">
                                        <p class="card-text">Drinks</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 offset-1">
                                <div class="card" style="width: 20rem;" onclick="allSnacks()">
                                    <img src="" class="card-img-top snacks_image image" alt="...">
                                    <div class="card-body">
                                        <p class="card-text">Snacks</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 offset-1">
                                <div class="card" style="width: 20rem;" onclick="allOther()">
                                    <img src="" class="card-img-top other_image image" alt="...">
                                    <div class="card-body">
                                        <p class="card-text">Other</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script>
         function allFood(){
             location.href = "{{route('food.index')}}";
         }
         function allDrinks(){
             location.href = "{{route('drink.index')}}";
         }
         function allSnacks(){
             location.href = "{{route('snack.index')}}";
         }
         function allOther(){
             location.href = "{{route('other.index')}}";
         }
    </script>
@endsection
