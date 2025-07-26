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
                <li class="breadcrumb-item active">Questions</li>
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
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row my-3">
                            <div class="col-lg-10 col-md-12 col-12">
                            <form id="filterForm" name="filterForm" method="get" action="{!! $url_1 !!}"> 
                            @if($step_id)
                            <input type="hidden" name="step_id" value="{{ $step_id }}">
                            @else
                            <input type="hidden" name="option_id" value="{{ $option_id }}">
                            @endif
                            <div class="row">                                

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="question" name="question" value="{{ $question ?? '' }}" placeholder="Question">                                
                                </div>  
                                </div>   

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="field_name" name="field_name" value="{{ $field_name ?? '' }}" placeholder="Field Name">                                
                                </div>  
                                </div>   
                                
                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" id="answer_type" name="answer_type">
                                    <option value="">Answer Type</option>
                                    @foreach($answer_types as $val)
                                    <option value="{{ $val }}" {{ ($answer_type==$val) ? 'selected' : '' }}>{{ $val }}</option>     
                                    @endforeach                               
                                </select>                             
                                </div>  
                                </div>     
                                
                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" id="display_type" name="display_type">
                                    <option value="">Display Type</option>
                                    <option value="0" {{ ($display_type=='0') ? 'selected' : '' }}>vertical</option>
                                    <option value="1" {{ ($display_type=='1') ? 'selected' : '' }}>horizontal</option>
                                </select>                             
                                </div>  
                                </div>     

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                                </div>

                            </div>
                            </form> 
                            </div> 
                            @if(has_permision(['document'=>'RW']))
                            <div class="col-lg-2 col-md-12 col-12">
                                <div class="text-end">
                                <a href="{!! $url_2 !!}" class="btn btn-secondary">+ Add new question</a>
                                </div>
                            </div>   
                            @endif                      
                        </div>                       
                        
                        <form id="applyForm" name="applyForm" method="post" action="{!! $url_1 !!}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped" style="table-layout: fixed; width: 100%;">                            
                            <thead>                                                         
                                <tr class="table-dark">
                                    <th style="width:3%;"><input class="form-check-input checkall" type="checkbox"></th>
                                    <th style="width:3%;">#</th>
                                    <th>Question</th>                                     
                                    <th>Field Name</th> 
                                    <th>Group</th>                                                               
                                    <th>Answer Type</th>                       
                                    <th>Display Type</th>  
                                    <th class="text-end px-5" style="width:18%;">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['step_id'] }}">
                                        <td>
                                            @if( count($val['options']) < 1)
                                            <input class="form-check-input selected-chk" type="checkbox" name="id[]" value="{{ $val['question_id'] }}">
                                            @endif
                                        </td>
                                        <td>{{ $start_count }}</td>
                                        <td>{{ $val['question'] }}</td>                                          
                                        <td>
                                            <div class="break-word">                                               
                                            @if($val['add_another_max'] > 0 )
                                                @for($i=1; $i<= $val['add_another_max']; $i++)
                                                  {{ $val['field_name'].'_'.$i }}<br />
                                                @endfor
                                            @else
                                            {{ $val['field_name'] }}
                                            @endif                                            
                                            </div>
                                        </td> 
                                        <td>{{ $val['label_group'] }}</td>  
                                        <td>{{ $val['answer_type'] }}</td> 
                                        <td>
                                            @if($val['display_type'] == '1')                                                
                                                horizontal
                                            @else
                                                vertical                                        
                                            @endif
                                        </td>
                                        <td class="text-end">                                           

                                            @if(has_permision(['document'=>'RW']))    
                                            
                                            @if($step_id)
                                            <a                                             
                                            class="btn btn-sm btn-primary" 
                                            title="Copy"                                            
                                            data-bs-toggle="modal" 
                                            href="{{ route('copy.questions.create',$val['question_id']) }}"
                                            data-bs-target="#large_modal"                                                         
                                            >Copy                                             
                                            </a>
                                            @endif



                                            <a href="{{ route('document.options.index',$val['question_id']) }}" class="btn btn-md" title="Options">Options ({{ count($val['options'])}})</a>

                                            <a href="{{ route('questions.edit',$val['question_id']) }}" class="btn btn-md" title="Edit"><i class="bi bi-pencil-square text-success"></i></a>
                                            
                                                @if( count($val['options']) < 1)
                                                <button type="button" class="btn btn-md delete"                                            
                                                onclick="delete_row({{ $val['question_id'] }})"                      
                                                title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                                @endif

                                            @endif
                                        </td>
                                    </tr> 
                                    @php $start_count++; @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="8">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>                        
                        </div>
                        @if(has_permision(['document'=>'RW']))
                        <div class="d-flex justify-content-start py-0">
                            <div>
                            <select class="form-select" name="apply_action">
                                <option value="">Choose an action...</option>                                
                                <option value="delete">Delete</option>                                         
                            </select> 
                            </div>
                            <div>
                            <button type="button" class="btn btn-primary mx-2" onclick="validate_applyForm()">Apply to selected</button>
                            </div>
                        </div>
                        @endif
                        </form>
                        
                        
                        <div class="d-flex justify-content-end py-2">                         
                         {!! $paginate !!}
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <script>
    const delete_row = (id) =>{ 
        
        swal({		  
            title				: 'Are you sure?',
            text				: 'You want to delete this item',
            type				: 'warning',
            showCancelButton	: true,
            confirmButtonColor  : '#3085d6',
            cancelButtonColor	: '#d33',
            confirmButtonText	: 'Yes, delete it!',
            cancelButtonText	: 'No, cancel!',
            confirmButtonClass  : 'btn btn-success',
            cancelButtonClass	: 'btn btn-danger',
            buttonsStyling	: false,
            closeOnConfirm	: false	
        }).then(function () {

            var url = "{{ route('questions.destroy','id') }}"
            url = url.replace('id',id);       

            $.ajax({
                type: "delete",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                dataType: "json",
                url: url, 
                success: function(response){  
                    $('#row-'+id).hide()                   
                    setTimeout(()=>{
                        location.href = response.url
                    }, 1000)
                }
            });  
    
	    })	
    
    }

    const validate_applyForm = ()=>{
        let count_ckbox  = document.querySelectorAll('.selected-chk:checked').length;
        let apply_action = document.querySelector('[name="apply_action"]').value;

        if( count_ckbox > 0 && apply_action){   
            swal({		  
                title				: 'Are you sure?',
                text				: 'You want to apply this action',
                type				: 'warning',
                showCancelButton	: true,
                confirmButtonColor  : '#3085d6',
                cancelButtonColor	: '#d33',
                confirmButtonText	: 'Yes, do it!',
                cancelButtonText	: 'No, cancel!',
                confirmButtonClass  : 'btn btn-success',
                cancelButtonClass	: 'btn btn-danger',
                buttonsStyling	    : false,
                closeOnConfirm	    : false	
            }).then(function () { 
                document.getElementById('applyForm').submit()
            })                
        }        
        return false;
    }    
    </script>
    
@endsection