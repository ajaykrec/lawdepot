@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document-category.index') }}">Document category</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('document-category.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf  
                
                <div class="my-3">
                <label class="form-label">Country</label>
                @php
                $country_id = old('country_id', $data['country_id'] ?? '');
                @endphp
                <select class="form-select" name="country_id"> 
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
                <label class="form-label">Name</label>
                <input type="text" class="form-control" id="category_name" name="name" value="{{ old('name', $data['name'] ?? '') }}"> 
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

                <div class="my-3">
                <label class="form-label">Image ({{ $width }}X{{ $height }} Pixel)</label>
                <div id="imgdiv-outer-1">
                    @if($data['image'])  
                        @php
                            $array = [
                                'table'=>'documents_category',
                                'table_id'=>'category_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'image',
                                'file_name'=>old('image', $data['image'] ?? ''),
                                'file_path'=>'uploads/document-category',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-id="1" data-content="{{ $json_string }}">X</span>
                        <img src="{{ url('/storage/uploads/document-category/'.$data['image']) }}" class="img-thumb" width="100">                    
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
                <label class="form-label">Banner Image ({{ $width2 }}X{{ $height2 }} Pixel)</label>
                <div id="imgdiv-outer-2">
                    @if($data['banner_image'])  
                        @php
                            $array = [
                                'table'=>'documents_category',
                                'table_id'=>'category_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'banner_image',
                                'file_name'=>old('banner_image', $data['banner_image'] ?? ''),
                                'file_path'=>'uploads/document-category',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-id="2" data-content="{{ $json_string }}">X</span>
                        <img src="{{ url('/storage/uploads/document-category/'.$data['banner_image']) }}" class="img-thumb" width="100">                    
                        </div>      
                        <input type="hidden" name="banner_image" value="{{ old('banner_image', $data['banner_image'] ?? '') }}"> 
                               
                    @else
                        <input class="form-control" type="file" name="banner_image"> 
                        <span class="err" id="error-banner_image">
                        @error('banner_image')
                        {{$message}}
                        @enderror 
                        </span>               
                    @endif
                </div>                      
                </div>

                <div class="my-3">
                <label class="form-label">Banner Text</label>
                <textarea class="form-control" name="banner_text" style="height: 150px">{{ old('banner_text', $data['banner_text'] ?? '') }}</textarea>
                <span class="err" id="error-banner_text">
                @error('banner_text')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                
                <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control tinymce-editor" name="content" style="height: 100px">{{ old('content', $data['content'] ?? '') }}</textarea>
                <span class="err" id="error-content">
                @error('content')
                {{$message}}
                @enderror 
                </span>        
                </div> 

                <div class="my-3">
                <label class="form-label">Sort ordere</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $data['sort_order'] ?? '') }}"> 
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

                <div class="card-header mb-3 px-0 text-primary">Meta data</div>

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

                </form>

                </div>
                </div>

            </div>
        </div>
    </section> 
   
    <script>
    $('#category_name').on('change', ()=> {            
        var text = $.trim($('#category_name').val()).toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        $('#slug').val(text);        
    });    
    
    $('.delete_image').on('click', (e)=>{

        let json_string = e.target.getAttribute('data-content')   
        let id = e.target.getAttribute('data-id')  
        
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
                    $('#imgdiv-outer-'+id).html(response.message)  
                    swal('Deleted!','Your file has been deleted.', 'success' )   
                }
            });  
        })	
    })
    </script>
    
@endsection