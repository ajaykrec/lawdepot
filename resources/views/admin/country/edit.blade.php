@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('country.index') }}">Country</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('country.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf   
                
                <div class="my-3">
                <label class="form-label">Image ({{ $width }}X{{ $height }} Pixel)</label>
                <div id="imgdiv-outer">
                    @if($data['image'])  
                        @php
                            $array = [
                                'table'=>'country',
                                'table_id'=>'country_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'image',
                                'file_name'=>old('image', $data['image'] ?? ''),
                                'file_path'=>'uploads/country',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-content="{{ $json_string }}">X</span>
                        <img src="{{ url('/storage/uploads/country/'.$data['image']) }}" class="img-thumb" width="100">                    
                        </div>      
                        <input type="hidden" name="image" value="{{ old('image', $data['image'] ?? '') }}"> 
                        <span class="err" id="error-image">
                        @error('image')
                        {{$message}}
                        @enderror 
                        </span>              
                    @else
                        <input class="form-control" type="file" name="image"> 
                        <span class="err" id="error-image">
                        @error('image')
                        {{$message}}
                        @enderror 
                        </span>               
                    @endif
                </div>                      
                </div>

                <div class="my-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $data['name'] ?? '') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Country Code</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $data['code'] ?? '') }}"> 
                <span class="err" id="error-code">
                @error('code')
                {{$message}}
                @enderror 
                </span>                 
                </div>    

                <div class="my-3">
                <label class="form-label">Currency Code</label>
                <input type="text" class="form-control" id="currency_code" name="currency_code" value="{{ old('currency_code', $data['currency_code'] ?? '') }}"> 
                <span class="err" id="error-currency_code">
                @error('currency_code')
                {{$message}}
                @enderror 
                </span>                 
                </div>    

                <div class="my-3">
                <label class="form-label">Language</label>
                @php
                $language_id = old('language_id', $data['language_id'] ?? '');
                @endphp
                <select class="form-select" name="language_id"> 
                <option value=""></option>   
                @foreach($languages as $val)
                <option value="{{ $val['language_id'] }}" {{ ($language_id==$val['language_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>  
                @endforeach 
                </select>
                <span class="err" id="error-language_id">
                @error('language_id')
                {{$message}}
                @enderror 
                </span>      
                </div>    
                
                <div class="my-3">
                <label class="form-label">Sort Order</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order" 
                value="{{ old('sort_order', $data['sort_order'] ?? '') }}"> 
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
                $default = old('default', $data['default'] ?? '');
                @endphp
                <select class="form-select" name="status">   
                @if($default == 1) 
                <option value="1" {{ ($status=='1') ? 'selected' : '' }}>Active</option>   
                @else
                <option value="1" {{ ($status=='1') ? 'selected' : '' }}>Active</option>   
                <option value="0" {{ ($status=='0') ? 'selected' : '' }}>In-Active</option>  
                @endif                 
                </select>
                <span class="err" id="error-status">
                @error('status')
                {{$message}}
                @enderror 
                </span>      
                </div>

                <div class="my-3">
                <label class="form-label">Default</label>
                @php
                $default = old('default', $data['default'] ?? '');
                @endphp
                <select class="form-select" name="default">                 
                @if($default == 1) 
                <option value="1" {{ ($default=='1') ? 'selected' : '' }}>Yes</option>   
                @else
                <option value="1" {{ ($default=='1') ? 'selected' : '' }}>Yes</option>   
                <option value="0" {{ ($default=='0') ? 'selected' : '' }}>No</option>  
                @endif                
                </select>
                <span class="err" id="error-default">
                @error('default')
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
@endsection