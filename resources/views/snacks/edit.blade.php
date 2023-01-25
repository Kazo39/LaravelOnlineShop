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
                        <form action="{{route('snack.update', ['snack' => $snack])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6 ">
                                    <label for="name" class="pb-1">Enter new snack name</label>
                                    <input type="text" id="name" class="form-control" name="new_name" placeholder="Enter snack name" value="{{$snack->name}}">
                                    @error('new_name')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="type" class="pb-1">Enter snack type</label>
                                    <input type="text" id="type" class="form-control" name="new_type" placeholder="Enter snack type" value="{{$snack->type}}">
                                    @error('new_type')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 ">
                                    <label for="price" class="pb-1">Enter snack price</label>
                                    <input type="text" id="price" class="form-control" name="new_price" placeholder="Enter snack price" value="{{$snack->price}}">
                                    @error('new_price')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6 ">
                                    <label for="weight" class="pb-1">Enter snack weight</label>
                                    <input type="number" id="weight" class="form-control" name="new_weight" placeholder="Enter snack weight" value="{{$snack->weight}}">
                                    @error('new_weight')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-8 offset-2">
                                    <label for="description" class="pb-1">Enter snack description</label>
                                    <textarea name="new_description" id="description" cols="30" rows="5" class="form-control" placeholder="Description..." >{{$snack->description}}</textarea>
                                    @error('new_description')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                            </div>

                            <div class="row mt-3">
                                <div class="col-8 offset-2">
                                    <label for="photo" class="pb-1">Upload snack photo</label>
                                    <input type="file" id="photo" name="new_snack_photo" class="form-control">
                                    @error('new_snack_photo')
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

