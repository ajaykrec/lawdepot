@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('settings.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                @if($data['field_type'] == 'TextBox')

                <div class="my-3">
                <label class="form-label">{{ $data['title'] ?? '' }}</label>
                <input type="text" class="form-control" name="value" value="{{ old('value', $data['value'] ?? '' ) }}"> 
                <span class="err" id="error-value">
                @error('value')
                {{$message}}
                @enderror 
                </span>                 
                </div>  
                
                @elseif($data['field_type'] == 'TextArea')

                <div class="my-3">
                <label class="form-label">{{ $data['title'] ?? '' }}</label>
                <textarea class="form-control" name="value" rows="10">{{ old('value', $data['value'] ?? '' ) }}</textarea>
                <span class="err" id="error-value">
                @error('value')
                {{$message}}
                @enderror 
                </span>                 
                </div>  

                @elseif($data['field_type'] == 'TextEditor')

                <div class="my-3">
                <label class="form-label">{{ $data['title'] ?? '' }}</label>
                <textarea class="form-control tinymce-editor" name="value">{{ old('value', $data['value'] ?? '' ) }}</textarea>
                <span class="err" id="error-value">
                @error('value')
                {{$message}}
                @enderror 
                </span>                 
                </div> 
                
                @elseif($data['field_type'] == 'Radio')

                @php
                $value = old('value', $data['value'] ?? '' );
                @endphp

                <div class="my-3">
                <label class="form-label">{{ $data['title'] ?? '' }}</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="value" id="radio1" value="1" @php if($value==1){ echo 'checked'; } @endphp >
                      <label class="form-check-label" for="radio1">
                      Yes
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="value" id="radio2" value="0" @php if($value==0){ echo 'checked'; } @endphp>
                      <label class="form-check-label" for="radio2">
                      No
                      </label>
                    </div>                    
                </div>                
                <span class="err" id="error-value">
                @error('value')
                {{$message}}
                @enderror 
                </span>                 
                </div> 
                
                @elseif($data['field_type'] == 'Image')                

                <div class="my-3">
                <label class="form-label">{{ $data['title'] ?? '' }}</label>
                <div id="imgdiv-outer">
                    @if($data['value'])  
                        @php
                            $array = [
                                'table'=>'settings',
                                'table_id'=>'setting_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'value',
                                'file_name'=>old('value', $data['value'] ?? ''),
                                'file_path'=>'uploads/settings',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-content="{{ $json_string }}">X</span>
                        <img src="{{ url('/storage/uploads/settings/'.$data['value']) }}" class="img-thumb" width="100">                    
                        </div>      
                        <input type="hidden" name="value" value="{{ old('value', $data['value'] ?? '') }}"> 
                               
                    @else
                        <input class="form-control" type="file" name="value"> 
                        <span class="err" id="error-value">
                        @error('value')
                        {{$message}}
                        @enderror 
                        </span>               
                    @endif
                </div>      
                </div> 

                <script>
                $('.delete_image').on('click', (e)=>{
                    let json_string = e.target.getAttribute('data-content')    
                    let obj = JSON.parse(json_string)
                    swal({		  
                        title				: 'Are you sure?',
                        text				: 'You want to delete this image',
                        type				: 'warning',
                        showCancelButton	: true,
                        confirmButtonColor  : '#3085d6',
                        cancelButtonColor	: '#d33',
                        confirmButtonText	: 'Yes, delete it!',
                        cancelButtonText	: 'No, cancel!',
                        confirmButtonClass  : 'btn btn-success',
                        cancelButtonClass	: 'btn btn-danger',
                        buttonsStyling	    : false,
                        closeOnConfirm	    : false	
                    }).then(function () {
                        $.ajax({
                            type: "delete",
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            dataType: "json",
                            url: "{{ route('delete.file') }}",   
                            data: obj, 
                            success: function(response){          
                                $('#imgdiv-outer').html(response.message)  
                                swal('Deleted!','Your file has been deleted.', 'success' )   
                            }
                        });  
                    })	
                })
                </script>

                @elseif($data['field_type'] == 'File') 
                
                <div class="my-3">
                <label class="form-label">{{ $data['title'] ?? '' }}</label>                
                <div id="imgdiv-outer">
                    @if($data['value'])  
                        @php
                            $array = [
                                'table'=>'settings',
                                'table_id'=>'setting_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'value',
                                'file_name'=>old('value', $data['value'] ?? ''),
                                'file_path'=>'uploads/settings',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-content="{{ $json_string }}">X</span>                        
                        {!! $data['value'] !!}                   
                        </div>      
                        <input type="hidden" name="value" value="{{ old('value', $data['value'] ?? '') }}"> 
                               
                    @else
                        <input class="form-control" type="file" name="value"> 
                        <span class="err" id="error-value">
                        @error('value')
                        {{$message}}
                        @enderror 
                        </span>               
                    @endif
                </div>         
                </div> 
                <script>
                $('.delete_image').on('click', (e)=>{
                    let json_string = e.target.getAttribute('data-content')    
                    let obj = JSON.parse(json_string)
                    swal({		  
                        title				: 'Are you sure?',
                        text				: 'You want to delete this image',
                        type				: 'warning',
                        showCancelButton	: true,
                        confirmButtonColor  : '#3085d6',
                        cancelButtonColor	: '#d33',
                        confirmButtonText	: 'Yes, delete it!',
                        cancelButtonText	: 'No, cancel!',
                        confirmButtonClass  : 'btn btn-success',
                        cancelButtonClass	: 'btn btn-danger',
                        buttonsStyling	    : false,
                        closeOnConfirm	    : false	
                    }).then(function () {
                        $.ajax({
                            type: "delete",
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            dataType: "json",
                            url: "{{ route('delete.file') }}",   
                            data: obj, 
                            success: function(response){          
                                $('#imgdiv-outer').html(response.message)  
                                swal('Deleted!','Your file has been deleted.', 'success' )   
                            }
                        });  
                    })	
                })
                </script> 

                @else
            
                <div class="my-3">
                <label class="form-label">{{ $data['title'] ?? '' }}</label>
                <input type="text" class="form-control" name="value" value="{{ old('value', $data['value'] ?? '' ) }}"> 
                <span class="err" id="error-value">
                @error('value')
                {{$message}}
                @enderror 
                </span>                 
                </div>  

                @endif


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