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
                            <form id="filterForm" name="filterForm" method="get" action="{{ route('settings.index') }}"> 
                            <div class="row">

                                <div class="col-lg-3 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="title" name="title" value="{{ $title ?? '' }}" placeholder="Title">                                
                                </div>  
                                </div>  
                                
                                <div class="col-lg-3 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="key" name="key" value="{{ $key ?? '' }}" placeholder="Key">                                
                                </div>  
                                </div>  
                                
                                <div class="col-lg-3 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="value" name="value" value="{{ $value ?? '' }}" placeholder="Value">                                
                                </div>  
                                </div>  

                                <div class="col-lg-3 col-md-6 col-12">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                                </div>

                            </div>
                            </form> 
                            </div> 
                            <div class="col-lg-2 col-md-12 col-12">
                                <div class="text-end">
                                &nbsp;
                                </div>
                            </div>                         
                        </div>                       
                        
                        <form id="applyForm" name="applyForm" method="post" action="{{ route('settings.index') }}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">                                    
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Key</th>    
                                    <th>Value</th>                                                        
                                    <th class="text-end px-5">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['setting_id'] }}">                                        
                                        <td>{{ $start_count }}</td>
                                        <td>{{ $val['title'] }}</td>                                    
                                        <td>{{ $val['key'] }}</td>      
                                        <td>
                                        @if($val['field_type']=='Image')  
                                            <img src="{{ url('/storage/uploads/settings/'.$val['value']) }}" class="img-thumb" width="100">            
                                        @elseif($val['field_type']=='File')    
                                            <a href="{{ url('download/settings/'.$val['value']) }}" title="">{!! $val['value'] !!}</a>
                                              
                                        @else
                                            {!! $val['value'] !!}
                                        @endif
                                        </td>      
                                        <td class="text-end">  
                                            @if(has_permision(['settings'=>'RW']))                                          
                                            <a href="{{ route('settings.edit',$val['setting_id']) }}" class="btn btn-md" title="Edit">
                                                <i class="bi bi-pencil-square text-success"></i>
                                            </a>    
                                            @endif                                        
                                        </td>
                                    </tr> 
                                    @php $start_count++; @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>                        
                        </div>                        
                        </form>
                        
                        
                        <div class="d-flex justify-content-end py-2">                         
                         {!! $paginate !!}
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>    
    
@endsection