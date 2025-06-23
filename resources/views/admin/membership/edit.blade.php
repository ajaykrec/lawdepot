@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('membership-setting.index') }}">Membership</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <form id="dataForm" name="dataForm" method="post" action="{{ route('membership-setting.update',$id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf          
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12">               
                <div class="card">
                <div class="card-body mb-3">    
                    
                @php
                $country_id = old('country_id', $data['country_id'] ?? '');
                @endphp
                <div class="my-3">
                <label class="form-label">Country</label>                
                <select class="form-select" name="country_id"> 
                <option value=""></option>   
                @foreach($countries as $val)
                <option value="{{ $val['country_id'] }}" {{ ($country_id==$val['country_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>
                @endforeach
                </select>
                <span class="err" id="error-country_id">
                @error('country_id')
                {{$message}}
                @enderror 
                </span>      
                </div>

                <div class="my-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $data['name'] ?? '') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>
                

                <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" style="height: 100px">{{ old('description', $data['description'] ?? '') }}</textarea>
                <span class="err" id="error-description">
                @error('description')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="my-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $data['price'] ?? '') }}"> 
                <span class="err" id="error-price">
                @error('price')
                {{$message}}
                @enderror 
                </span>                 
                </div>  
                
                @php
                $time_period = old('time_period', $data['time_period'] ?? '');
                $time_period_sufix = old('time_period_sufix', $data['time_period_sufix'] ?? '');
                @endphp
                <div class="my-3">
                <label class="form-label">Time Period</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="time_period" name="time_period" value="{{ $time_period }}"> 
                    <div class="input-group-append">
                        <select class="form-select" name="time_period_sufix"> 
                        <option value="">--</option>   
                        <option value="day" {{ ($time_period_sufix=='day') ? 'selected' : '' }}>Day</option>   
                        <option value="week" {{ ($time_period_sufix=='week') ? 'selected' : '' }}>Week</option>   
                        <option value="month" {{ ($time_period_sufix=='month') ? 'selected' : '' }}>Month</option>  
                        <option value="year" {{ ($time_period_sufix=='year') ? 'selected' : '' }}>Year</option>  
                        </select>
                    </div>
                </div>
                <span class="err" id="error-time_period">
                @error('time_period')
                {{$message}}
                @enderror 
                </span>  
                <br />
                <span class="err" id="error-time_period_sufix">
                @error('time_period_sufix')
                {{$message}}
                @enderror 
                </span>                  
                </div>

                <div class="my-3">
                <label class="form-label">Free Trial period days</label>
                <input type="number" class="form-control" id="trial_period_days" name="trial_period_days" value="{{ old('trial_period_days', $data['trial_period_days'] ?? 0) }}"> 
                <span class="err" id="error-trial_period_days">
                @error('trial_period_days')
                {{$message}}
                @enderror 
                </span>                 
                </div>                


                @php
                $is_per_document = old('is_per_document', $data['is_per_document'] ?? '');
                @endphp
                <div class="my-3">
                <label class="form-label">Is per document?</label>
                <select class="form-select" name="is_per_document"> 
                <option value="0" {{ ($is_per_document=='0') ? 'selected' : '' }}>No</option>  
                <option value="1" {{ ($is_per_document=='1') ? 'selected' : '' }}>Yes</option>   
                </select>
                <span class="err" id="error-is_per_document">
                @error('is_per_document')
                {{$message}}
                @enderror 
                </span>      
                </div>

               
                <div class="my-3">
                <label class="form-label">Btton Color</label>
                <input type="color" class="form-control form-control-color" id="button_color" name="button_color" value="{{ old('button_color', $data['button_color'] ?? '') }}"> 
                <span class="err" id="error-button_color">
                @error('button_color')
                {{$message}}
                @enderror 
                </span>                 
                </div>


                @php
                $mode = old('mode', $data['mode'] ?? '');
                @endphp
                <div class="my-3">
                <label class="form-label">Mode</label>
                <select class="form-select" name="mode"> 
                <option value=""></option>   
                <option value="payment" {{ ($mode=='payment') ? 'selected' : '' }}>payment</option>   
                <option value="subscription" {{ ($mode=='subscription') ? 'selected' : '' }}>subscription</option>  
                </select>
                <span class="err" id="error-mode">
                @error('mode')
                {{$message}}
                @enderror 
                </span>      
                </div>

               
                @php
                $status = old('status', $data['status'] ?? '');
                @endphp
                <div class="my-3">
                <label class="form-label">Status</label>                
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

                <div class="my-3">
                <label class="form-label">Sort order</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $data['sort_order'] ?? '') }}"> 
                <span class="err" id="error-sort_order">
                @error('sort_order')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="mb-3">  
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>                

                </div>
                </div>

            </div>

            <div class="col-lg-6 col-md-12 col-12">              
                

                <div class="card">
                    <div class="card-body"> 
                    @include('admin.membership.specification')
                    </div>
                </div>
            </div>

        </div>
        </form>
    </section>     
@endsection