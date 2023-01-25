@extends('layouts.app')
@section('additional_css')
    <style>
        .pointer:hover{
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
                        <p>New addition</p>
                    </div>

                    <div class="card-body">
                        <form action="{{route('addition.food.add')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-6">
                                    <input type="text" class="form-control" name="name" placeholder="Name">
                                    @error('name')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>


                                <div class="col-4">
                                    <select name="product_id" id="" class="form-control">
                                        <option value="" selected disabled>--select product for this addition--</option>
                                        @foreach($products as $p)
                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 ">
                                        <button class="btn btn-outline-primary float-end">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                            <div class="row mt-5 border border-2">
                                <div class="row ">
                                    <div class="col-4 border-end">Name</div>
                                    <div class="col-4 border-end ">Product</div>
                                    <div class="col-4 ">Delete</div>
                                </div>
                                @foreach($additions as $add)
                                    <div class="row mt-3">
                                        <div class="col-4 border-end">{{$add->name}}</div>
                                        <div class="col-4 border-end">{{$add->taggable->name}}</div>
                                        <div class="col-4 text-center">
                                            <form action="{{route('addition.destroy', ['addition' => $add])}}" method="POST" id="deleteForm{{$add->id}}">
                                                @method('DELETE')
                                                @csrf
                                                <i class="fa-solid fa-trash fa-xl me-3 pointer" onclick="submitDeleteForm('deleteForm{{$add->id}}')"></i>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional_script')
    <script>
        function submitDeleteForm(id){
            document.getElementById(`${id}`).submit();
        }
    </script>
@endsection
