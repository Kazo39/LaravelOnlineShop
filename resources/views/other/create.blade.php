@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p>New product</p>
                    </div>

                    <div class="card-body">
                        <form action="{{route('other.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 ">
                                    <input type="text" class="form-control" name="name" placeholder="Enter product name">
                                    @error('name')
                                        <div class="row">
                                            <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="type" placeholder="Enter product type">
                                    @error('type')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-4 ">
                                    <input type="text" class="form-control" name="price" placeholder="Enter product price">
                                    @error('price')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-8 offset-2">
                                    <textarea name="description" id="" cols="30" rows="5" class="form-control" placeholder="Description..."></textarea>
                                    @error('description')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-8 offset-2">
                                    <input type="file" name="product_photo" class="form-control">
                                    @error('product_photo')
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

