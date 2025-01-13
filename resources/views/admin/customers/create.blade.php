@extends('admin.layout.main')

@section('page-content')
    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <form id="dataForm" name="dataForm" method="post" action="{{ route('customers.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">       
                    
                <div class="my-3">
                <label class="form-label">Profile Photo ({{$width}}X{{$height}} Pixel)</label>
                <div id="imgdiv-outer"> 
                <input class="form-control" type="file" name="profile_photo"> 
                <span class="err" id="error-profile_photo">
                @error('profile_photo')
                {{$message}}
                @enderror 
                </span>                               
                </div>
                </div>

                <div class="my-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"> 
                <span class="err" id="error-email">
                @error('email')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"> 
                <span class="err" id="error-phone">
                @error('phone')
                {{$message}}
                @enderror 
                </span>                 
                </div>
                

                <div class="my-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}" > 
                <span class="err" id="error-dob">
                @error('dob')
                {{$message}}
                @enderror 
                </span>                 
                </div>


                <div class="my-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"> 
                <span class="err" id="error-password">
                @error('password')
                {{$message}}
                @enderror 
                </span>                 
                </div>  

                <div class="my-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="{{ old('confirm_password') }}"> 
                <span class="err" id="error-confirm_password">
                @error('confirm_password')
                {{$message}}
                @enderror 
                </span>                 
                </div>          

                <div class="my-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status"> 
                <option value=""></option>   
                <option value="1" {{ (old('status')=='1') ? 'selected' : '' }}>Active</option>   
                <option value="0" {{ (old('status')=='0') ? 'selected' : '' }}>In-Active</option>  
                </select>
                <span class="err" id="error-status">
                @error('status')
                {{$message}}
                @enderror 
                </span>      
                </div>   
             
                </div>
                </div>
            </div>            
            
            <div class="col-lg-12">
                <div class="mb-3 text-start">  
                <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>
            </div>           
        </div>
        </form>
    </section>  
    
@endsection