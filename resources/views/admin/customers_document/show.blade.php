@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.cusdocument.index',$customer_id) }}">Document</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">               
            <div class="card">                
                <div class="card-body mt-4"> 
                    <div class="contractPreview">
                    <div class="contract">
                    <div class="outputVersion1">
                    <div style="background:url(/frontend-assets/images/draft_bg.png) repeat-y center top/contain #fff"> 
                    {!! $document['document']['template'] !!}      
                    </div>
                    </div>
                    </div>   
                    </div>  
                </div>
                <div class="card-footer">
                <a href="{{ route('customers.cusdocument.index',$customer_id) }}" class="btn btn-primary mx-2">&laquo; Back</a>
                </div>
            </div>
            </div>

        </div>
    </section>   
    
@endsection