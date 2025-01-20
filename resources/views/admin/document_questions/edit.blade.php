@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        {{--
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document.index') }}">Document</a></li>
                @if($step_id)
                <li class="breadcrumb-item"><a href="{{ route('document.steps.index',$document_id) }}">Steps</a></li>
                @else
                <li class="breadcrumb-item"><a href="{{ route('document.options.index',$question_id) }}">Options</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ $url }}">Questions</a></li>
                <li class="breadcrumb-item active">Edit question</li>
            </ol>
        </nav>
        --}}
        <nav>
            <ol class="breadcrumb">
                @php 
                $i = 0;                   
                @endphp
                @foreach($breadcrumb as $val)
                    @php                     
                    $i++;
                    @endphp

                    @if( count($breadcrumb) > $i)
                    <li class="breadcrumb-item"><a href="{{ $val['url'] }}">{{ $val['name'] }}</a></li>  
                    @else 
                    <li class="breadcrumb-item active">{{ $val['name'] }}</li>  
                    @endif
                @endforeach            
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('questions.update',$question_id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf                

                <div class="my-3">
                <label class="form-label">Label</label>
                <input type="text" class="form-control" id="label" name="label" value="{{ old('label', $data['label'] ?? '') }}"> 
                <span class="err" id="error-label">
                @error('label')
                {{$message}}
                @enderror 
                </span>                 
                </div>                

                <div class="my-3">
                <label class="form-label">Question</label>
                <input type="text" class="form-control" id="question" name="question" value="{{ old('question', $data['question'] ?? '') }}"> 
                <span class="err" id="error-question">
                @error('question')
                {{$message}}
                @enderror 
                </span>                 
                </div>


                <div class="my-3">
                <label class="form-label">Field Name <span class="text-info small">(Template reserve field)</span></label>
                <input type="text" class="form-control" id="field_name" name="field_name" value="{{ old('field_name', $data['field_name'] ?? '') }}"> 
                <span class="err" id="error-field_name">
                @error('field_name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Placeholder</label>
                <input type="text" class="form-control" id="placeholder" name="placeholder" value="{{ old('placeholder', $data['placeholder'] ?? '') }}"> 
                <span class="err" id="error-placeholder">
                @error('placeholder')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Answer Type</label>
                @php
                $answer_type = old('answer_type', $data['answer_type'] ?? '');
                @endphp
                <select class="form-select" name="answer_type"> 
                <option value=""></option>   
                @foreach($answer_types as $val)
                <option value="{{ $val }}" {{ ($answer_type==$val) ? 'selected' : '' }}>{{ $val }}</option>   
                @endforeach
                </select>
                <span class="err" id="error-answer_type">
                @error('answer_type')
                {{$message}}
                @enderror 
                </span>      
                </div>
               
                <div class="my-3">
                <label class="form-label">Display Type</label>
                @php
                $display_type = old('display_type', $data['display_type'] ?? '');
                @endphp
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="display_type" id="display_type_1" value="0" @php if($display_type==0){ echo 'checked'; } @endphp >
                      <label class="form-check-label" for="display_type_1">
                      Vertical
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="display_type" id="display_type_2" value="1" @php if($display_type==1){ echo 'checked'; } @endphp>
                      <label class="form-check-label" for="display_type_2">
                      Horizontal
                      </label>
                    </div>                    
                </div>                
                <span class="err" id="error-display_type">
                @error('display_type')
                {{$message}}
                @enderror 
                </span>      
                </div>

                <div class="my-3">
                <label class="form-label">is add another?</label>
                @php
                $is_add_another = old('is_add_another', $data['is_add_another'] ?? '');
                @endphp
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_add_another" id="is_add_another_1" value="0" @php if($is_add_another==0){ echo 'checked'; } @endphp >
                      <label class="form-check-label" for="is_add_another_1">
                      No
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_add_another" id="is_add_another_2" value="1" @php if($is_add_another==1){ echo 'checked'; } @endphp>
                      <label class="form-check-label" for="is_add_another_2">
                      Yes
                      </label>
                    </div>                    
                </div>                
                <span class="err" id="error-is_add_another">
                @error('is_add_another')
                {{$message}}
                @enderror 
                </span>      
                </div>

                <div class="row">

                    <div class="col-md-6 col-12">     
                    <div class="my-3">
                    <label class="form-label">Group</label>
                    <select class="form-select" name="label_group">                     
                    @for( $i=1; $i<=$group_count; $i++ ) 
                    <option value="{{ $i }}" {{ (old('label_group', $data['label_group'] ?? '')==$i) ? 'selected' : '' }}>{{ $i }}</option> 
                    @endfor
                    </select>
                    <span class="err" id="error-label_group">
                    @error('label_group')
                    {{$message}}
                    @enderror 
                    </span>                      
                    </div>    
                    </div> 
                    
                    <div class="col-md-6 col-12">     
                    <div class="my-3">
                    <label class="form-label">Sort order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $data['sort_order'] ?? '') }}"> 
                    <span class="err" id="error-sort_order">
                    @error('sort_order')
                    {{$message}}
                    @enderror 
                    </span>                 
                    </div>    
                    </div>      
                    
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