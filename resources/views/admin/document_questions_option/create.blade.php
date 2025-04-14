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
                <li class="breadcrumb-item"><a href="{{ route('document.options.index',$question_id) }}">...</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ $url }}">Questions</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document.options.index',$question_id) }}">Options</a></li>
                <li class="breadcrumb-item active">Add option</li>
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

                <form id="dataForm" name="dataForm" method="post" action="{{ route('document.options.store',$question_id)}}" enctype="multipart/form-data">
                @csrf

                <div class="my-3">
                <label class="form-label">Image ({{$width}}X{{$height}} Pixel)</label>
                <div id="imgdiv-outer"> 
                <input class="form-control" type="file" name="image"> 
                <span class="err" id="error-image">
                @error('image')
                {{$message}}
                @enderror 
                </span>                               
                </div>
                </div> 

                <div class="my-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"> 
                <span class="err" id="error-title">
                @error('title')
                {{$message}}
                @enderror 
                </span>                 
                </div>  

                <div class="my-3">
                <label class="form-label">Placeholder</label>                
                <textarea class="form-control" id="placeholder" name="placeholder" style="height:75px">{{ old('placeholder') }}</textarea>
                <span class="err" id="error-placeholder">
                @error('placeholder')
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

                @php 
                $is_table_value = old('is_table_value') ?? 0;

                if($is_table_value == 0){
                    $div_1_style = '';
                    $div_2_style = 'style="display:none"';
                }
                else{
                    $div_1_style = 'style="display:none"';
                    $div_2_style = '';
                }                
                @endphp

                
                <div class="my-3">
                <label class="form-label">is table value?</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_table_value" id="is_table_value_1" onclick="get_value(this.value)" value="0" @php if($is_table_value==0){ echo 'checked'; } @endphp >
                      <label class="form-check-label" for="is_table_value_1">
                      No
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_table_value" id="is_table_value_2" onclick="get_value(this.value)" value="1" @php if($is_table_value==1){ echo 'checked'; } @endphp>
                      <label class="form-check-label" for="is_table_value_2">
                      Yes
                      </label>
                    </div>                    
                </div>                
                <span class="err" id="error-is_table_value">
                @error('is_table_value')
                {{$message}}
                @enderror 
                </span>      
                </div>


                <div class="my-3" id="value_div_1" {!! $div_1_style !!}>
                <label class="form-label">Value</label>
                <input type="text" class="form-control" name="value1" value="{{ old('value1') }}"> 
                <span class="err" id="error-value1">
                @error('value1')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3" id="value_div_2" {!! $div_2_style !!}>
                <label class="form-label">Table value</label>
                <select class="form-select" name="value2">   
                    @foreach($table_names as $val)                 
                    <option value="{{ $val }}" {{ (old('value2')==$val) ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>     
                <span class="err" id="error-value2">
                @error('value2')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">is sub question?</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_sub_question" id="is_sub_question_1" value="0" @php if(old('is_sub_question')==0){ echo 'checked'; } @endphp >
                      <label class="form-check-label" for="is_sub_question_1">
                      No
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_sub_question" id="is_sub_question_2" value="1" @php if(old('is_sub_question')==1){ echo 'checked'; } @endphp>
                      <label class="form-check-label" for="is_sub_question_2">
                      Yes
                      </label>
                    </div>                    
                </div>                
                <span class="err" id="error-is_sub_question">
                @error('is_sub_question')
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
    const get_value = (id)=>{
        if(id == 1){
            $('#value_div_2').show();
            $('#value_div_1').hide();
        }
        else{
            $('#value_div_2').hide();
            $('#value_div_1').show();
        }        
    }
    </script>

@endsection