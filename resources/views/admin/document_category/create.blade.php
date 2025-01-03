@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document-category.index') }}">Document category</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('document-category.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="my-3">
                <label class="form-label">Country</label>
                <select class="form-select" name="country_id"> 
                <option value=""></option>   
                @foreach($countries as $val)
                <option value="{{ $val['country_id'] }}" {{ (old('country_id')==$val['country_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>  
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
                <input type="text" class="form-control" id="category_name" name="name" value="{{ old('name') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}"> 
                <span class="err" id="error-slug">
                @error('slug')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Image ({{$width}}X{{$height}} Pixel)</label>
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
                <label class="form-label">Banner Image ({{$width2}}X{{$height2}} Pixel)</label>
                <div id="imgdiv-outer"> 
                <input class="form-control" type="file" name="banner_image"> 
                <span class="err" id="error-banner_image">
                @error('banner_image')
                {{$message}}
                @enderror 
                </span>                               
                </div>
                </div>

                <div class="my-3">
                <label class="form-label">Banner Text</label>
                <textarea class="form-control" name="banner_text" style="height: 150px">{{ old('banner_text') }}</textarea>
                <span class="err" id="error-banner_text">
                @error('banner_text')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control tinymce-editor" name="content" style="height: 100px">{{ old('content') }}</textarea>
                <span class="err" id="error-content">
                @error('content')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="my-3">
                <label class="form-label">Sort ordere</label>
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

                
                <div class="card-header mb-3 px-0 text-primary">Meta data</div>

                <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <textarea class="form-control" name="meta_title" style="height: 75px">{{ old('meta_title') }}</textarea>
                <span class="err" id="error-meta_title">
                @error('meta_title')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="mb-3">
                <label class="form-label">Meta Keyword</label>
                <textarea class="form-control" name="meta_keyword" style="height: 75px">{{ old('meta_keyword') }}</textarea>
                <span class="err" id="error-meta_keyword">
                @error('meta_keyword')
                {{$message}}
                @enderror 
                </span>        
                </div>

                <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" name="meta_description" style="height: 75px">{{ old('meta_description') }}</textarea>
                <span class="err" id="error-meta_description">
                @error('meta_description')
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

    <script>    
    $('#category_name').on('change', ()=> {            
        var text = $.trim($('#category_name').val()).toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        $('#slug').val(text);        
    });    
    </script>

@endsection