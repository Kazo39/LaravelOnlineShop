@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p>Edit this product</p>
                    </div>

                    <div class="card-body">
                        <form action="{{route('other.update', ['other' => $other])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-4">
                                    <label for="name" class="pb-1">Enter new product name</label>
                                    <input type="text" id="name" class="form-control" name="new_name" placeholder="Enter product name" value="{{$other->name}}">
                                    @error('new_name')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="type" class="pb-1">Enter product type</label>
                                    <input type="text" id="type" class="form-control" name="new_type" placeholder="Enter product type" value="{{$other->type}}">
                                    @error('new_type')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="price" class="pb-1">Enter product price</label>
                                    <input type="text" id="price" class="form-control" name="new_price" placeholder="Enter product price" value="{{$other->price}}">
                                    @error('new_price')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-8 offset-2">
                                    <label for="description" class="pb-1">Enter product description</label>
                                    <textarea name="new_description" id="description" cols="30" rows="5" class="form-control" placeholder="Description..." >{{$other->description}}</textarea>
                                    @error('new_description')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-8 offset-2">
                                    <label for="photo" class="pb-1">Upload product photo</label>
                                    <input type="file" id="photo" name="new_product_photo" class="form-control">
                                    @error('new_product_photo')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-8 offset-2">
                                    <button class="btn float-end btn-outline-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

