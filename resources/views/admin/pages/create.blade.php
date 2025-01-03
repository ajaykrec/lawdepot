@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body my-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('pages.store')}}" enctype="multipart/form-data">
                @csrf

                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">

                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" 
                        id="general-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#bordered-justified-general" 
                        type="button" 
                        role="tab" 
                        aria-controls="general" 
                        aria-selected="true">General Info</button>
                    </li>

                    @foreach($languages as $val)
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" 
                        id="{{ $val['code'] }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#bordered-justified-{{ $val['code'] }}" 
                        type="button" 
                        role="tab" 
                        aria-controls="{{ $val['code'] }}" 
                        aria-selected="false">
                        @if($val['image'])  
                        <img src="{{ url('/storage/uploads/language/'.$val['image']) }}" class="img-thumb" height="20">  
                        @endif      
                        {{ $val['name'] }}
                        </button>
                    </li>
                    @endforeach               

                </ul>

                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                
                    <div class="tab-pane fade show active my-3" id="bordered-justified-general" role="tabpanel" aria-labelledby="general-tab">

                        <div class="my-3">
                        <label class="form-label">Banner Image ({{$width}}X{{$height}} Pixel)</label>
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
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}"> 
                        <span class="err" id="error-slug">
                        @error('slug')
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


                    @foreach($languages as $val)
                    <div class="tab-pane fade my-3" id="bordered-justified-{{ $val['code'] }}" role="tabpanel" aria-labelledby="{{ $val['code'] }}-tab">

                        @php 
                        $language_id = $val['language_id'];                    
                        @endphp

                        <div class="my-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name[{{ $language_id }}]" value="{{ old('name')[$language_id] ?? '' }}"> 
                        <span class="err" id="error-name[{{ $language_id }}]">
                        @error('name['.$language_id.']')
                        {{$message}}
                        @enderror 
                        </span>                 
                        </div>

                        <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control tinymce-editor" name="content[{{ $language_id }}]" style="height: 100px">{{ old('content')[$language_id] ?? '' }}</textarea>
                        <span class="err" id="error-content[{{ $language_id }}]">
                        @error('content['.$language_id.']')
                        {{$message}}
                        @enderror 
                        </span>        
                        </div> 

                        <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <textarea class="form-control" name="meta_title[{{ $language_id }}]" style="height: 75px">{{ old('meta_title')[$language_id] ?? '' }}</textarea>
                        <span class="err" id="error-meta_title[{{ $language_id }}]">
                        @error('meta_title['.$language_id.']')
                        {{$message}}
                        @enderror 
                        </span>        
                        </div> 

                        <div class="mb-3">
                        <label class="form-label">Meta Keyword</label>
                        <textarea class="form-control" name="meta_keyword[{{ $language_id }}]" style="height: 75px">{{ old('meta_keyword')[$language_id] ?? '' }}</textarea>
                        <span class="err" id="error-meta_keyword[{{ $language_id }}]">
                        @error('meta_keyword['.$language_id.']')
                        {{$message}}
                        @enderror 
                        </span>        
                        </div>

                        <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description[{{ $language_id }}]" style="height: 75px">{{ old('meta_description')[$language_id] ?? '' }}</textarea>
                        <span class="err" id="error-meta_description[{{ $language_id }}]">
                        @error('meta_description['.$language_id.']')
                        {{$message}}
                        @enderror 
                        </span>        
                        </div>
                    
                    </div>
                    @endforeach
                
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