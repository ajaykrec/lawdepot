@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('zones.index') }}">Zones</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('zones.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf   

                <div class="my-3">
                <label class="form-label">Country</label>
                @php
                $country_id = old('country_id', $data['country_id'] ?? '');
                @endphp
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
                <label class="form-label">Zone Name</label>
                <input type="text" class="form-control" name="zone_name" value="{{ old('zone_name', $data['zone_name'] ?? '') }}"> 
                <span class="err" id="error-zone_name">
                @error('zone_name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Zone Code</label>
                <input type="text" class="form-control" id="zone_code" name="zone_code" value="{{ old('zone_code', $data['zone_code'] ?? '') }}"> 
                <span class="err" id="error-zone_code">
                @error('zone_code')
                {{$message}}
                @enderror 
                </span>                 
                </div>                    

                <div class="my-3">
                <label class="form-label">Status</label>
                @php
                $status = old('status', $data['status'] ?? '');                
                @endphp
                <select class="form-select" name="status">   
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