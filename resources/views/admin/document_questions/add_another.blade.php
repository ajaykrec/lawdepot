<div class="my-3">
    <label class="form-label">is add another?</label>                
    <div class="col-sm-10">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_add_another" id="is_add_another_1" 
            value="0" 
            onclick="get_add_another_div(0)"
            @php if($is_add_another==0){ echo 'checked'; } @endphp >
            <label class="form-check-label" for="is_add_another_1">
            No
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_add_another" id="is_add_another_2" 
            value="1" 
            onclick="get_add_another_div(1)"
            @php if($is_add_another==1){ echo 'checked'; } @endphp>
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

<div class="row" id="add_another_div" {!! $div_2_style !!}>

    <div class="col-md-6 col-12">     
    <div class="my-3">
    <label class="form-label">Maximum row to add</label>
    <input type="number" class="form-control" id="add_another_max" name="add_another_max" value="{{ old('add_another_max', $data['add_another_max'] ?? '') }}">
    <span class="err" id="error-add_another_max">
    @error('add_another_max')
    {{$message}}
    @enderror 
    </span>                      
    </div>    
    </div>   

    <div class="col-md-6 col-12">     
    <div class="my-3">
    <label class="form-label">Add another button text</label>
    <input type="text" class="form-control" id="add_another_button_text" name="add_another_button_text" value="{{ old('add_another_button_text', $data['add_another_button_text'] ?? '') }}">
    <span class="err" id="error-add_another_button_text">
    @error('add_another_button_text')
    {{$message}}
    @enderror 
    </span>                      
    </div>    
    </div>                
    
    <div class="col-md-12 col-12">     
    <div class="my-3">
    <label class="form-label">Box text</label>
    <input type="text" class="form-control" id="add_another_text" name="add_another_text" value="{{ old('add_another_text', $data['add_another_text'] ?? '') }}">
    <span class="err" id="error-add_another_text">
    @error('add_another_text')
    {{$message}}
    @enderror 
    </span>                      
    </div>    
    </div>  
    
</div> 


<script>    
    const get_add_another_div = (count)=>{   
        var html = '<option value=""></option>'    
        if( count == 1 ){ 

            @foreach($answer_types as $val)
                @if(in_array($val, $addAnotherArr))
                html+='<option value="{{ $val }}" {{ (old('answer_type')==$val) ? 'selected' : '' }}>{{ $val }}</option>'  
                @endif 
            @endforeach

            $('#add_another_div').show();
            $('#answer_type').children('option').remove();    
            $('#answer_type').append(html);
            
        }
        else{
            
            @foreach($answer_types as $val)
            html+='<option value="{{ $val }}" {{ (old('answer_type')==$val) ? 'selected' : '' }}>{{ $val }}</option>'   
            @endforeach

            $('#add_another_div').hide(); 
            $('#answer_type').children('option').remove();    
            $('#answer_type').append(html);
        }         
    }    
    </script>  