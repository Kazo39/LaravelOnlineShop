@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p>Choose additions for "{{$snack->name}}"</p>
                    </div>

                    <div class="card-body">
                        <form action="{{route('snack.add.with.additions' , ['snack' => $snack])}}" method="POST" >
                            @csrf
                            <div class="row mt-2 border-bottom border-2">
                                @foreach($additions as $add)
                                    <div class="row mt-3">
                                        <div class="col-1 ">
                                            <input type="checkbox" class="" name="{{$add->id}}">
                                        </div>
                                        <div class="col-11 ">{{$add->name}}</div>
                                    </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-outline-primary float-end mb-2">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-1">
                            <div class="col-12">
                                <p class="fst-italic">Note: Each selected addition after the third will be paid 0.3€</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

