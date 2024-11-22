@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle)? $pageTitle:'pageTitle Here')
    
@section('content')
    
<div class="login-box bg-white box-shadow border-radius-10">
    <div class="login-title">
        <h2 class="text-center text-primary">Login</h2>
    </div>
    <form action="{{route('admin.login_handler')}}" method="POST">

        <x-form-alerts></x-form-alerts>
        
        @csrf                
        
        <div class="input-group custom mb-1">
            <input type="text" class="form-control form-control-lg" placeholder="Username/Email" name="login_id" value="{{old('login_id')}}">
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
            </div>
        </div>

        @error('login_id')
            <span class="text-danger ml-1">{{$message}}</span>
        @enderror
        <div class="input-group custom mb-1 mt-2">
            <input type="password" class="form-control form-control-lg" placeholder="**********" name="password">
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
            </div>
        </div>


        @error('password')
            <span class="text-danger ml-1">{{$message}}</span>
        @enderror
        <div class="row pb-30">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Remember</label>
                </div>
            </div>
            <div class="col-6">
                <div class="forgot-password">
                    <a href="{{route('admin.forgot')}}">Forgot Password</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group mb-0"> 
                    <input type="submit" class="btn btn-primary btn-large btn-block" value="Sign In">
                </div>
                
            </div>
        </div>
    </form>
</div>
@endsection