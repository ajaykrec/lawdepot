@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('users.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="my-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="{{ old('email') }}"> 
                <span class="err" id="error-email">
                @error('email')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="my-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">  
                <span class="err" id="error-phone_number">
                @error('phone_number')
                {{$message}}
                @enderror 
                </span>                        
                </div>

                <div class="my-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="{{ old('password') }}">  
                <span class="err" id="error-password">
                @error('password')
                {{$message}}
                @enderror 
                </span>                        
                </div>

                <div class="my-3">
                <label class="form-label">User Type</label>
                @php
                $usertype_id = old('usertype_id');
                @endphp
                <select class="form-select" name="usertype_id"> 
                <option value=""></option>   
                @foreach($user_types as $val)
                <option value="{{ $val['usertype_id'] }}" {{ ($val['usertype_id']==$usertype_id) ? 'selected' : '' }}>{{ $val['user_type'] }}</option>   
                @endforeach
                </select>
                <span class="err" id="error-usertype_id">
                @error('usertype_id')
                {{$message}}
                @enderror 
                </span>      
                </div>


                <div class="my-3">
                <label class="form-label">Company</label>
                <input type="text" class="form-control" name="company" value="{{ old('company') }}">  
                <span class="err" id="error-company">
                @error('company')
                {{$message}}
                @enderror 
                </span>                        
                </div>


                <div class="my-3">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="country" value="{{ old('country') }}">  
                <span class="err" id="error-country">
                @error('country')
                {{$message}}
                @enderror 
                </span>                        
                </div>

                <div class="my-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="{{ old('address') }}">  
                <span class="err" id="error-address">
                @error('address')
                {{$message}}
                @enderror 
                </span>                        
                </div>


                <div class="my-3">
                <label class="form-label">Status</label>
                @php
                $status = old('status');
                @endphp
                <select class="form-select" name="status"> 
                <option value=""></option>   
                <option value="1" {{ ($status=='1') ? 'selected' : '' }}>Active</option>   
                <option value="0" {{ ($status=='0') ? 'selected' : '' }}>In-Active</option>  
                </select>
                <span class="err" id="error-status">
                @error('status')
                {{$message}}
                @enderror 
                </span>      
                </div>

                <div class="mb-3">  
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                </form>

                </div>
                </div>

            </div>
        </div>
    </section>   
    
@endsection