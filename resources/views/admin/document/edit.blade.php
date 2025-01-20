@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document.index') }}">Document</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
    <form id="dataForm" name="dataForm" method="post" action="{{ route('document.update',$id) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf            
        <div class="row">
            <div class="col-lg-6 col-12">               
                <div class="card">
                <div class="card-body mb-3">   
                    
                <div class="my-3">
                <label class="form-label">Image ({{ $width }}X{{ $height }} Pixel)</label>
                <div id="imgdiv-outer-1">
                    @if($data['image'])  
                        @php
                            $array = [
                                'table'=>'documents',
                                'table_id'=>'document_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'image',
                                'file_name'=>old('image', $data['image'] ?? ''),
                                'file_path'=>'uploads/document',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-id="1" data-content="{{ $json_string }}">X</span>
                        <img src="{{ url('/storage/uploads/document/'.$data['image']) }}" class="img-thumb" width="100">                    
                        </div>      
                        <input type="hidden" name="image" value="{{ old('image', $data['image'] ?? '') }}"> 
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
                <input type="text" class="form-control" id="product_name" name="name" value="{{ old('name', $data['name'] ?? '') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $data['slug'] ?? '') }}"> 
                <span class="err" id="error-slug">
                @error('slug')
                {{$message}}
                @enderror 
                </span>                 
                </div> 

                <div class="mb-3">
                <label class="form-label">Short Description</label>
                <textarea class="form-control" name="short_description" style="height: 150px">{{ old('short_description', $data['short_description'] ?? '') }}</textarea>
                <span class="err" id="error-short_description">
                @error('short_description')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="mb-3">
                <label class="form-label">Long Description</label>
                <textarea class="form-control tinymce-editor" name="description" style="height: 100px">{{ old('description', $data['description'] ?? '') }}</textarea>
                <span class="err" id="error-description">
                @error('description')
                {{$message}}
                @enderror 
                </span>        
                </div>   
                
                
                <div class="card-header mb-3 px-0 py-0 text-primary">Meta data for Search Engine Optimization (SEO)</div>

                <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <textarea class="form-control" name="meta_title" style="height: 75px">{{ old('meta_title', $data['meta_title'] ?? '') }}</textarea>
                <span class="err" id="error-meta_title">
                @error('meta_title')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="mb-3">
                <label class="form-label">Meta Keyword</label>
                <textarea class="form-control" name="meta_keyword" style="height: 75px">{{ old('meta_keyword', $data['meta_keyword'] ?? '') }}</textarea>
                <span class="err" id="error-meta_keyword">
                @error('meta_keyword')
                {{$message}}
                @enderror 
                </span>        
                </div>

                <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" name="meta_description" style="height: 75px">{{ old('meta_description', $data['meta_description'] ?? '') }}</textarea>
                <span class="err" id="error-meta_description">
                @error('meta_description')
                {{$message}}
                @enderror 
                </span>        
                </div>

                <div class="mb-3">  
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>                

                </div>
                </div>

            </div>
            <div class="col-lg-6 col-12">               
                <div class="card">
                <div class="card-body mb-3">


                <div class="my-3">
                <label class="form-label">Country</label>
                @php 
                $country_id = old('country_id', $data['country_id'] ?? '');
                @endphp
                <select class="form-select" id="country_id" name="country_id" onchange=get_get_categories(this.value)> 
                <option value=""></option>   
                @foreach($countries as $val)
                <option value="{{ $val['country_id'] }}" {{ ($country_id==$val['country_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>  
                @endforeach 
                </select>
                <span class="err" id="error-country_id">
                @error('country_id')
                {{$message}}
                @enderror 
                </span>      
                </div>  
                
                <div class="my-3">
                <label class="form-label">Category</label>
                @php 
                $category_id = old('category_id', $data['category_id'] ?? '');
                @endphp
                <select class="form-select" id="category_id" name="category_id"> 
                <option value=""></option>   
                @foreach($categories as $val)
                <option value="{{ $val['category_id'] }}" {{ ($category_id==$val['category_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>  
                @endforeach 
                </select>
                <span class="err" id="error-category_id">
                @error('category_id')
                {{$message}}
                @enderror 
                </span>      
                </div>   

                <div class="row">

                    <div class="col-md-6 col-12">     
                        <div class="my-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $data['sort_order'] ?? '') }}"> 
                        <span class="err" id="error-sort_order">
                        @error('sort_order')
                        {{$message}}
                        @enderror 
                        </span>                 
                        </div> 
                    </div>

                    <div class="col-md-6 col-12">     
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

                </div> 

                <div class="mb-3">
                <label class="form-label">Template</label>
                <textarea class="form-control tinymce-editor" name="template" style="height: 100px">{{ old('template', $data['template'] ?? '') }}</textarea>
                <span class="err" id="error-template">
                @error('template')
                {{$message}}
                @enderror 
                </span>        
                </div>                   

                </div>
                </div>
            </div>
        </div>
    </form>
    </section> 

    <script>

    $('#product_name').on('change', ()=> {            
        var text = $.trim($('#product_name').val()).toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        $('#slug').val(text);        
    });    

    $('.delete_image').on('click', (e)=>{
        let json_string = e.target.getAttribute('data-content')    
        let obj = JSON.parse(json_string)
        let id = e.target.getAttribute('data-id')  

        swal({		  
            title				: 'Are you sure?',
            text				: 'You want to delete this file',
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
                    $('#imgdiv-outer-'+id).html(response.message)  
                    swal('Deleted!','Your file has been deleted.', 'success' )   
                }
            });  
        })	
    })

    const get_get_categories = (country_id) =>{ 
        var url = "{{ route('doc.categories','country_id') }}"
        url = url.replace('country_id',country_id); 
        $.ajax({
            type: "get",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: "json",
            url: url, 
            success: function(response){  
                let options = '<option value="">Category</option>';
                if(response){
                    response.map((val,i)=>{                    
                        options += '<option value="'+val.category_id+'">'+val.name+'</option>';
                    })
                    console.log(options)
                }
                $('#category_id').html(options)                 
                
            }
        });  
    }
    </script>
    
@endsection