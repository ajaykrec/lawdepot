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
            <div class="col-lg-8 col-12">               
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
                <label class="form-label">Short Question (for api)</label>
                <input type="text" class="form-control" id="short_question" name="short_question" value="{{ old('short_question', $data['short_question'] ?? '') }}"> 
                <span class="err" id="error-short_question">
                @error('short_question')
                {{$message}}
                @enderror 
                </span>                 
                </div>


                <div class="my-3">
                <label class="form-label">Question</label>                
                <textarea class="form-control" id="question" name="question" style="height:75px">{{ old('question', $data['question'] ?? '') }}</textarea>
                <span class="err" id="error-question">
                @error('question')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Quick info (Hint)</label>                
                <textarea class="form-control" id="quick_info" name="quick_info" style="height:75px">{{ old('quick_info', $data['quick_info'] ?? '') }}</textarea>
                <span class="err" id="error-quick_info">
                @error('quick_info')
                {{$message}}
                @enderror 
                </span>                 
                </div>      
                
                
                <div class="my-3">
                <label class="form-label">Description</label>                
                <textarea class="form-control" id="description" name="description" style="height:100px">{{ old('description', $data['description'] ?? '') }}</textarea>
                <span class="err" id="error-description">
                @error('description')
                {{$message}}
                @enderror 
                </span>                 
                </div>                


                <div class="my-3">
                <label class="form-label">Field Name <span class="text-info small">(Template reserve field)</span></label>
                @php 
                if( $add_another_max > 0 ){
                    $field_name_prefix = old('field_name', $data['field_name'] ?? '');
                    $field_name = '';
                    for($i=1; $i<=$add_another_max; $i++){
                        $field_name .= $field_name_prefix .'_'.$i;

                        if( $i < $add_another_max){
                            $field_name .= ', ';
                        }
                    }
                }
                else{
                    $field_name = old('field_name', $data['field_name'] ?? '');
                }                
                @endphp
                <input type="text" class="form-control" id="field_name" name="field_name" value="{{ $field_name }}" disabled> 
                <span class="err" id="error-field_name">
                @error('field_name')
                {{$message}}
                @enderror 
                </span>                 
                </div>
                

                <div class="my-3">
                <label class="form-label">Placeholder</label>                
                <textarea class="form-control" id="placeholder" name="placeholder" style="height:75px">{{ old('placeholder', $data['placeholder'] ?? '') }}</textarea>
                <span class="err" id="error-placeholder">
                @error('placeholder')
                {{$message}}
                @enderror 
                </span>                 
                </div>                
                
                @php
                $is_add_another = old('is_add_another', $data['is_add_another'] ?? 0);
                if( $is_add_another == 1 ){
                    $div_2_style = '';                    
                }
                else{
                    $div_2_style = 'style="display:none"';                   
                }     
                $addAnotherArr = ['label','radio','checkbox','dropdown','text','textarea','date'];             
                @endphp
                
                {{-- @if($show_add_another)  --}}
                    @include('admin.document_questions.add_another')
                {{-- @endif --}}
                

                @php
                $answer_type = old('answer_type', $data['answer_type'] ?? '');
                $arrType = ['radio','radio_group'];
                if( in_array($answer_type, $arrType) ){
                    $div_1_style = '';                    
                }
                else{
                    $div_1_style = 'style="display:none"';                   
                }     
                @endphp

                <div class="row">
                    <div class="col-md-4 col-12">     
                        <div class="my-3">
                        <label class="form-label">Answer Type</label>                
                        <select class="form-select" id="answer_type" name="answer_type" onchange="get_value(this.value)"> 
                        <option value=""></option>  
                        @foreach($answer_types as $val)                   
                            @if($is_add_another == 1 || (!$show_add_another && $add_another_max > 0) )
                                @if(in_array($val, $addAnotherArr))
                                <option value="{{ $val }}" {{ ($answer_type==$val) ? 'selected' : '' }}>{{ $val }}</option> 
                                @endif 
                            @else
                            <option value="{{ $val }}" {{ ($answer_type==$val) ? 'selected' : '' }}>{{ $val }}</option>   
                            @endif
                        @endforeach
                        </select>
                        <span class="err" id="error-answer_type">
                        @error('answer_type')
                        {{$message}}
                        @enderror 
                        </span>      
                        </div>
                    </div>
                    <div class="col-md-4 col-12">     
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
                    <div class="col-md-4 col-12">     
                        <div class="my-3">
                        <label class="form-label">Sort order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $data['sort_order'] ?? 0) }}"> 
                        <span class="err" id="error-sort_order">
                        @error('sort_order')
                        {{$message}}
                        @enderror 
                        </span>                 
                        </div>
                    </div>   
                </div>
               
                <div class="my-3" id="value_div_1" {!! $div_1_style !!}>
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

                
                <div class="mb-3">  
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                </form>

                </div>
                </div>

            </div>
            <div class="col-lg-4 col-12">               
                <div class="card">
                <div class="card-body mb-3">

                    <form id="shiftForm" name="shiftForm" method="post" action="{{ route('shift.question') }}" enctype="multipart/form-data" onsubmit="return validate_form()">                   
                    @csrf  
                    <input type="hidden" name="question_id" value="{{ $question_id }}">

                    <h3>Sift this question to <i class="bi bi-arrow-right"></i></h3>
                    <div class="my-3">
                        <label class="form-label">Step</label>
                        <select class="form-select sift-step-id" name="step_id">  
                        <option value=""></option> 
                        @foreach($steps as $key=>$val)
                        <option value="{{ $val['step_id'] }}" {{ (old('step_id')==$val['step_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option> 
                        @endforeach
                        </select>
                        <span class="err" id="error-step_id">
                        @error('step_id')
                        {{$message}}
                        @enderror 
                        </span>                      
                    </div>                      
                    
                    <div class="my-3">
                        <label class="form-label">Group</label>
                        <select class="form-select" name="label_group" id="sift_label_group"></select>
                        <span class="err" id="error-1-label_group">
                        @error('label_group')
                        {{$message}}
                        @enderror 
                        </span>                      
                    </div>    
                    

                    <div class="mb-3">  
                    <button type="submit" class="btn btn-primary">Sift question</button>
                    </div>

                    </form>            
                </div>
                </div>
            </div>
        </div>
    </section>    

    <script>
    const get_value = (text)=>{
        const arrType = ['radio','radio_group'];
        if( arrType.includes(text) ){
            $('#value_div_1').show();
        }
        else{
            $('#value_div_1').hide();
        }        
    }       
    </script>  

    <script>  
    const form = document.getElementById('shiftForm');

    form.querySelector('[name="step_id"]')
    .addEventListener('change',(e)=>{
        validate_step_id('step_id')
    })  
    form.querySelector('[name="label_group"]')
    .addEventListener('change',(e)=>{
        validate_label_group('label_group')
    }) 

    const validate_step_id = (field_name)=>{	
        let input = form.elements[field_name]

        if (input.value.trim() === "") {
            input.classList.add("error")
            document.getElementById('error-'+field_name).innerHTML = 'This is required'
            return 1
        }    
        else{
            input.classList.remove("error")
            document.getElementById('error-'+field_name).innerHTML = ''
            return 0
        }
    } 
    const validate_label_group = (field_name)=>{	
        let input = form.elements[field_name]

        if (input.value.trim() === "") {
            input.classList.add("error")
            document.getElementById('error-1-'+field_name).innerHTML = 'This is required'
            return 1
        }    
        else{
            input.classList.remove("error")
            document.getElementById('error-1-'+field_name).innerHTML = ''
            return 0
        }
    } 

    const validate_form = ()=>{
        var total_error = 0;
        total_error = total_error + validate_step_id('step_id')  
        total_error = total_error + validate_label_group('label_group')
        if( total_error == 0 ){ 
            return true;
        }
        else{
            return false;
        }
    }    
    $('.sift-step-id').on('change', (e)=>{
        let step_id = e.target.value ?? ''       
        $.ajax({
            type: "get",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: "json",
            url: "{{ route('shift.step.group') }}",   
            data: {step_id:step_id}, 
            success: function(response){          
                $('#sift_label_group').html(response.message)                      
            }
        });  
    })
    </script>
    
@endsection