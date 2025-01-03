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
            <div class="col-lg-12">               
            <div class="card">
                {{--<div class="card-header">Header</div>--}}
                <div class="card-body mt-4">

                    <div class="mb-1">                    
                    @if($data['profile_image'])  
                        <img src="{{ url('/storage/uploads/testimonial/'.$data['profile_image']) }}" class="img-thumb" width="100">                     
                    @else
                        <img src="{{ url('/admin_assets/assets/img/no-photos.png') }}" class="img-thumb" height="100">
                    @endif
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Create Date : </b></label>
                    {{ date('j F, Y, g:i a',strtotime($data['created_at'])) }}                 
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Name : </b></label>
                    {{ $data['name'] ?? '' }}                       
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Designation : </b></label>
                    {{ $data['designation'] ?? '' }}                       
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Description : </b></label><br />
                    {!! $data['description'] ?? '' !!}                       
                    </div> 
                
                </div>
                <div class="card-footer">
                <a href="{{ route('testimonial.index') }}" class="btn btn-primary mx-2">&laquo; Back</a>
                </div>
            </div>
            </div>

        </div>
    </section>   
    
@endsection