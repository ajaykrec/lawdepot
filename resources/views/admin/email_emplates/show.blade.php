@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('email-templates.index') }}">Email Templates</a></li>
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
                    <label class="form-label"><b>Title : </b></label>
                    {{ $data['title'] ?? '' }}                       
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Email Subject : </b></label>
                    {{ $data['subject'] ?? '' }}                       
                    </div> 

                    <div class="mb-1">
                    <label class="form-label"><b>Email Body : </b></label><br />
                    {!! $data['body'] ?? '' !!}                       
                    </div> 
                                    
                </div>

                <div class="card-footer">
                <a href="{{ route('email-templates.index') }}" class="btn btn-primary mx-2">&laquo; Back</a>
                </div>
            </div>
            </div>

        </div>
    </section>   
    
@endsection