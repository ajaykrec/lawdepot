@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document.index') }}">Document</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document.steps.index',$document_id) }}">Steps</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document.faqs.index',$step_id) }}">Faqs</a></li>
                <li class="breadcrumb-item active">Add faq</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('document.faqs.store',$step_id)}}" enctype="multipart/form-data">
                @csrf

                <div class="my-3">
                <label class="form-label">Question</label>
                <input type="text" class="form-control" id="question" name="question" value="{{ old('question') }}"> 
                <span class="err" id="error-question">
                @error('question')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Answer</label>
                <textarea  class="form-control tinymce-editor" rows="10" id="answer" name="answer">{{ old('answer') }}</textarea> 
                <span class="err" id="error-answer">
                @error('answer')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Group</label>
                <select class="form-select" name="label_group">                 
                @for( $i=1; $i<=$group_count; $i++ ) 
                <option value="{{ $i }}" {{ (old('label_group')==$i) ? 'selected' : '' }}>{{ $i }}</option> 
                @endfor
                </select>
                <span class="err" id="error-label_group">
                @error('label_group')
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