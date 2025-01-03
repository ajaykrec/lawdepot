@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('country.index') }}">Country</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('country.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="my-3">
                <label class="form-label">Image ({{ $width }}X{{ $height }} Pixel)</label>
                <div id="imgdiv-outer"> 
                <input class="form-control" type="file" name="image"> 
                <span class="err" id="error-image">
                @error('image')
                {{$message}}
                @enderror 
                </span>                               
                </div>
                </div>

                <div class="my-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Code</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}"> 
                <span class="err" id="error-code">
                @error('code')
                {{$message}}
                @enderror 
                </span>                 
                </div>  

                <div class="my-3">
                <label class="form-label">Language</label>
                <select class="form-select" name="language_id"> 
                <option value=""></option>   
                @foreach($languages as $val)
                <option value="{{ $val['language_id'] }}" {{ (old('language_id')==$val['language_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>  
                @endforeach 
                </select>
                <span class="err" id="error-language_id">
                @error('language_id')
                {{$message}}
                @enderror 
                </span>      
                </div>    
                
                <div class="my-3">
                <label class="form-label">Sort Order</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order') }}"> 
                <span class="err" id="error-sort_order">
                @error('sort_order')
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
                
                <div class="my-3">
                <label class="form-label">Default</label>
                <select class="form-select" name="default"> 
                <option value=""></option>   
                <option value="1" {{ (old('default')=='1') ? 'selected' : '' }}>Yes</option>   
                <option value="0" {{ (old('default')=='0') ? 'selected' : '' }}>No</option>  
                </select>
                <span class="err" id="error-default">
                @error('default')
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