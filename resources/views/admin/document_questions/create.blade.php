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
                <li class="breadcrumb-item"><a href="{{ $url_1 }}">Questions</a></li>
                <li class="breadcrumb-item active">Add question</li>
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

                <form id="dataForm" name="dataForm" method="post" action="{{  $url_2 }}" enctype="multipart/form-data">
                @csrf

                <div class="my-3">
                <label class="form-label">Label</label>
                <input type="text" class="form-control" id="label" name="label" value="{{ old('label') }}"> 
                <span class="err" id="error-label">
                @error('label')
                {{$message}}
                @enderror 
                </span>                 
                </div>            
                
                <div class="my-3">
                <label class="form-label">Short Question (for api)</label>
                <input type="text" class="form-control" id="short_question" name="short_question" value="{{ old('short_question') }}"> 
                <span class="err" id="error-short_question">
                @error('short_question')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Question</label>                
                <textarea class="form-control" id="question" name="question" style="height:75px">{{ old('question') }}</textarea>
                <span class="err" id="error-question">
                @error('question')
                {{$message}}
                @enderror 
                </span>                 
                </div>


                <div class="my-3">
                <label class="form-label">Quick info (Hint)</label>                
                <textarea class="form-control" id="quick_info" name="quick_info" style="height:75px">{{ old('quick_info') }}</textarea>
                <span class="err" id="error-quick_info">
                @error('quick_info')
                {{$message}}
                @enderror 
                </span>                 
                </div>    
                
                <div class="my-3">
                <label class="form-label">Description</label>                
                <textarea class="form-control" id="description" name="description" style="height:100px">{{ old('description') }}</textarea>
                <span class="err" id="error-description">
                @error('description')
                {{$message}}
                @enderror 
                </span>                 
                </div>                


                {{--
                <div class="my-3">
                <label class="form-label">Field Name <span class="text-info small">(Template reserve field)</span></label>
                <input type="text" class="form-control" id="field_name" name="field_name" value="{{ old('field_name') }}"> 
                <span class="err" id="error-field_name">
                @error('field_name')
                {{$message}}
                @enderror 
                </span>                 
                </div>
                --}}
                
                <div class="my-3">
                <label class="form-label">Placeholder</label>                
                <textarea class="form-control" id="placeholder" name="placeholder" style="height:75px">{{ old('placeholder') }}</textarea>
                <span class="err" id="error-placeholder">
                @error('placeholder')
                {{$message}}
                @enderror 
                </span>                 
                </div>                


                @php 
                $is_add_another = old('is_add_another') ?? 0;                
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
                $answer_type = old('answer_type') ?? '';
                $arrType = ['radio','radio_group'];
                if( in_array($answer_type, $arrType) ){
                    $div_1_style = '';                    
                }
                else{
                    $div_1_style = 'style="display:none"';                   
                }                
                @endphp

                <div class="row">
                    <div class="col-md-6 col-12"> 
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
                    <div class="col-md-6 col-12">     
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
                    </div>   
                </div>

                <div class="my-3" id="value_div_1" {!! $div_1_style !!}>
                    <label class="form-label">Display Type</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="display_type" id="display_type_1" value="0" @php if(old('display_type')==0){ echo 'checked'; } @endphp >
                        <label class="form-check-label" for="display_type_1">
                        Vertical
                        </label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="display_type" id="display_type_2" value="1" @php if(old('display_type')==1){ echo 'checked'; } @endphp>
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

@endsection