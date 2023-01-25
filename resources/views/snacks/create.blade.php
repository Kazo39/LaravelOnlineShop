@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p>New snack</p>
                    </div>

                    <div class="card-body">
                        <form action="{{route('snack.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6 ">
                                    <input type="text" class="form-control" name="name" placeholder="Enter snack name">
                                    @error('name')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="type" placeholder="Enter snack type">
                                    @error('type')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 ">
                                    <input type="text" class="form-control" name="price" placeholder="Enter snack price">
                                    @error('price')
                                    <div class="row">
                                        <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6 ">
                                    <input type="number" class="form-control" name="weight" placeholder="Enter snack weight">
                                    @error('weight')
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
                                    <input type="file" name="snack_photo" class="form-control">
                                    @error('snack_photo')
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

