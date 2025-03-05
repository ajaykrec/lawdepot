@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
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
                            <form id="filterForm" name="filterForm" method="get" action="{{ route('orders.index') }}"> 
                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="Name" name="name" value="{{ $name ?? '' }}" placeholder="Name">                                
                                </div>  
                                </div>  

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="email" name="email" value="{{ $email ?? '' }}" placeholder="Email">                                
                                </div>  
                                </div> 

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $phone ?? '' }}" placeholder="Phone">                                
                                </div>  
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" id="order_status" name="order_status">
                                    <option value=""></option>
                                    <option value="0" {{ ($order_status=='0') ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ ($order_status=='1') ? 'selected' : '' }}>Completed</option>
                                    <option value="2" {{ ($order_status=='2') ? 'selected' : '' }}>Cancelled</option>
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
                                    
                        </div>                       
                        
                        <form id="applyForm" name="applyForm" method="post" action="{{ route('orders.index') }}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">
                                    <th style="width:5%;"><input class="form-check-input checkall" type="checkbox"></th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Order Status</th>                                    
                                    <th class="text-end px-5">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['order_id'] }}">
                                        <td><input class="form-check-input selected-chk" type="checkbox" name="id[]" value="{{ $val['order_id'] }}"></td>
                                        <td>{{ $start_count }}</td>
                                        <td>{{ $val['name'] }}</td>   
                                        <td>{{ $val['email'] }}</td>  
                                        <td>{{ $val['phone'] }}</td>    
                                        <td>{{ currency($val['total'], $val['currency_code']) }}</td>  
                                        <td>{{ full_date_format($val['created_at']) }}</td>                                                      
                                        <td>
                                            @if($val['order_status'] == '0')                                                
                                                <span class="badge rounded-pill bg-secondary">Pending</span>
                                            @elseif($val['order_status'] == '1') 
                                                <span class="badge rounded-pill bg-success">Completed</span>  
                                            @elseif($val['order_status'] == '2') 
                                                <span class="badge rounded-pill bg-danger">Cancelled</span>                                                  
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('orders.show',$val['order_id']) }}" class="btn btn-secondary btn-sm" title="View">View</a>

                                            @if(has_permision(['orders'=>'RW']))
                                            <a href="{{ route('orders.edit',$val['order_id']) }}" class="btn btn-success btn-sm" title="Edit">Edit</a>
                                            <button type="button" 
                                            class="btn btn-danger btn-sm delete" 
                                            onclick="delete_row({{ $val['order_id'] }})"         
                                            title="Delete">Delete</button>
                                            @endif
                                        </td>
                                    </tr> 
                                    @php $start_count++; @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>                        
                        </div>
                        @if(has_permision(['orders'=>'RW']))
                        <div class="d-flex justify-content-start py-0">
                            <div>
                            <select class="form-select" name="apply_action">
                                <option value="">Choose an action...</option>
                                <option value="Pending">Set as [Pending]</option>
                                <option value="Completed">Set as [Completed]</option>
                                <option value="Cancelled">Set as [Cancelled]</option>    
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

            var url = "{{ route('orders.destroy','id') }}"
            url = url.replace('id',id);       

            $.ajax({
                type: "delete",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                dataType: "json",
                url: url, 
                success: function(response){  
                    $('#row-'+id).hide() 
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