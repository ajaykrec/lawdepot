@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('banner-category.index') }}">Banner Category</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('banner-category.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf                

                <div class="my-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $data['name'] ?? '') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Width</label>
                <input type="number" class="form-control" name="width" value="{{ old('width', $data['width'] ?? '') }}"> 
                <span class="err" id="error-width">
                @error('width')
                {{$message}}
                @enderror 
                </span>                 
                </div>     
                
                
                <div class="my-3">
                <label class="form-label">Height</label>
                <input type="number" class="form-control" name="height" value="{{ old('height', $data['height'] ?? '') }}"> 
                <span class="err" id="error-height">
                @error('height')
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