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
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('email-templates.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="my-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $data['title'] ?? '' ) }}"> 
                <span class="err" id="error-title">
                @error('title')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Email Subject</label>
                <input type="text" class="form-control" name="subject" value="{{ old('subject', $data['subject'] ?? '') }}"> 
                <span class="err" id="error-subject">
                @error('subject')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="mb-3">
                <label class="form-label">Email Body</label>
                <textarea class="form-control tinymce-editor" name="body">{{ old('body', $data['body'] ?? '') }}</textarea>
                <span class="err" id="error-body">
                @error('body')
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