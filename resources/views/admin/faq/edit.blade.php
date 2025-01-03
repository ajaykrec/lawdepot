@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">Faq</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body my-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('faq.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
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
                        <label class="form-label">Sort order</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $data['sort_order'] ?? '') }}">  
                        <span class="err" id="error-sort_order">
                        @error('sort_order')
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
                    
                    </div>

                    @foreach($languages as $val)
                    <div class="tab-pane fade my-3" id="bordered-justified-{{ $val['code'] }}" role="tabpanel" aria-labelledby="{{ $val['code'] }}-tab">

                        @php 
                        $language_id = $val['language_id'];                    
                        @endphp

                        <div class="my-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="question[{{ $language_id }}]" value="{{ old('question')[$language_id] ?? $lang_data[$language_id]['question'] ?? '' }}"> 
                        <span class="err" id="error-question[{{ $language_id }}]">
                        @error('question['.$language_id.']')
                        {{$message}}
                        @enderror 
                        </span>                 
                        </div>

                        <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control tinymce-editor" name="answer[{{ $language_id }}]" style="height: 100px">{{ old('answer')[$language_id] ?? $lang_data[$language_id]['answer'] ?? '' }}</textarea>
                        <span class="err" id="error-answer[{{ $language_id }}]">
                        @error('answer['.$language_id.']')
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