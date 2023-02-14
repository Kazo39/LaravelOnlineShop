@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            Change your password
                        </div>
                    </div>
                    @if($message == 'correct')
                        <div class="alert alert-success text-center mx-5 mt-2" role="alert" id="alert">
                            Password successfully changed!
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <form action="{{route('settings.update')}}" method="POST" id="form">
                                @csrf
                                <div class="row">
                                    <div class="col-8 offset-2">
                                        <input type="password" name="old_password" placeholder="Enter your current password" class="form-control">

                                        @error('old_password')
                                        <div class="row">
                                            <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-8 offset-2">
                                        <input type="password"  name="password" placeholder="Enter new password" class="form-control">
                                        @error('password')
                                            <div class="row">
                                                <div class="alert alert-danger col-10 offset-1 mt-1">{{$message}}</div>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-8 offset-2">
                                        <input type="password" name="password_confirmation" placeholder="Enter new password again" class="form-control">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-8 offset-2">
                                        <button class="btn btn-outline-primary float-end">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('additional_script')
    <script>
        function checkMessageVisibility(){
            window.history.pushState('page2', 'Title', '/settings');
            setTimeout(()=>{
                document.getElementById('alert').classList.add('d-none');
            }, 2000)
        }
        checkMessageVisibility();
    </script>
@endsection
