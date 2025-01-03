@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body my-3">
                
                <form id="chngpasswordFrm" name="chngpasswordFrm" method="post" action="{{ route('profile.change.password')}}" >
                    @csrf
                    <input type="hidden" name="apply_action" value="ok">

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input name="password" type="password" class="form-control" id="password" value="{{ old('password') }}">
                        <span class="err" id="error-password">
                        @error('password')
                        {{$message}}
                        @enderror 
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input name="new_password" type="password" class="form-control" id="new_password" value="{{ old('new_password') }}">
                        <span class="err" id="error-new_password">
                        @error('new_password')
                        {{$message}}
                        @enderror 
                        </span>                        
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Re-enter New Password</label>
                        <input name="renew_password" type="password" class="form-control" id="renew_password" value="{{ old('renew_password') }}">
                        <span class="err" id="error-renew_password">
                        @error('renew_password')
                        {{$message}}
                        @enderror 
                        </span>                       
                    </div>

                    <div class="mb-3">
                        <label class="form-label"></label>                        
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
               
                </div>
                </div>

            </div>
        </div>
    </section> 
    
@endsection