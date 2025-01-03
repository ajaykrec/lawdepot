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
            <div class="col-lg-12">               
            <div class="card">
                {{--<div class="card-header">Header</div>--}}
                <div class="card-body mt-4">

                    <div class="mb-1">
                    <label class="form-label"><b>Create Date : </b></label>
                    {{ date('j F, Y, g:i a',strtotime($data['created_at'])) }}                 
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Name : </b></label>
                    {{ $data['name'] ?? '' }}                       
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Width : </b></label>
                    {{ $data['width'] ?? '' }} Pixel                      
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Height : </b></label>
                    {{ $data['height'] ?? '' }} Pixel                     
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Status : </b></label>                    
                    @if($data['status'] == '1')                                                
                        <span class="badge rounded-pill bg-success">Active</span>
                    @else
                        <span class="badge rounded-pill bg-danger">In-Active</span>                                                
                    @endif
                    </div> 
                    
                
                </div>
                <div class="card-footer">
                <a href="{{ route('banner-category.index') }}" class="btn btn-primary mx-2">&laquo; Back</a>
                </div>
            </div>
            </div>

        </div>
    </section>   
    
@endsection