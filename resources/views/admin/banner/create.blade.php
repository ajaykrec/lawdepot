@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('banner-category.index') }}">Banner Category</a></li>
                <li class="breadcrumb-item"><a href="{{ route('banner-category.banners.index',$bannercat_id) }}">{{$bcategory['name']}}</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body my-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('banner-category.banners.store',$bannercat_id)}}" enctype="multipart/form-data">
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
                        <label class="form-label">Image ({{ $bcategory['width'] }}X{{ $bcategory['height'] }} Pixel)</label>
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
                        <label class="form-label">Floating Image ({{ $bcategory['width'] }}X{{ $bcategory['height'] }} Pixel)</label>
                        <div id="imgdiv-outer"> 
                        <input class="form-control" type="file" name="floating_image"> 
                        <span class="err" id="error-floating_image">
                        @error('floating_image')
                        {{$message}}
                        @enderror 
                        </span>                               
                        </div>
                        </div>


                        <div class="my-3">
                        <label class="form-label">Url</label>
                        <input type="text" class="form-control" name="url" value="{{ old('url') }}"> 
                        <span class="err" id="error-url">
                        @error('url')
                        {{$message}}
                        @enderror 
                        </span>                 
                        </div>                 
                        
                        <div class="my-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order') }}"> 
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
                    
                    </div>


                    @foreach($languages as $val)
                    <div class="tab-pane fade my-3" id="bordered-justified-{{ $val['code'] }}" role="tabpanel" aria-labelledby="{{ $val['code'] }}-tab">

                        @php 
                        $language_id = $val['language_id'];                    
                        @endphp

                        <div class="mb-3">
                        <label class="form-label">Banner Text</label>
                        <textarea class="form-control" name="banner_text[{{ $language_id }}]" style="height: 250px">{{ old('banner_text')[$language_id] ?? '' }}</textarea>
                        <span class="err" id="error-banner_text[{{ $language_id }}]">
                        @error('banner_text['.$language_id.']')
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