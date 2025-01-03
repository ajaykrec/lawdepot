@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}">Testimonial</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('testimonial.store')}}" enctype="multipart/form-data">
                @csrf

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
                <label class="form-label">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation') }}"> 
                <span class="err" id="error-designation">
                @error('designation')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Profile Image ({{$width}}X{{$height}} Pixel)</label>
                <div id="imgdiv-outer"> 
                <input class="form-control" type="file" name="profile_image"> 
                <span class="err" id="error-profile_image">
                @error('profile_image')
                {{$message}}
                @enderror 
                </span>                               
                </div>
                </div>                

                <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control tinymce-editor" name="description" style="height: 100px">{{ old('description') }}</textarea>
                <span class="err" id="error-description">
                @error('description')
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
                <label class="form-label">Sort order</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order') }}"> 
                <span class="err" id="error-sort_order">
                @error('sort_order')
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