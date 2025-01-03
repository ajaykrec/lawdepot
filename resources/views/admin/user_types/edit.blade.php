@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-types.index') }}">User Types</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('user-types.update',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="my-3">
                <label class="form-label">User Type</label>
                <input type="text" class="form-control" name="user_type" value="{{ old('user_type', $data['user_type'] ?? '' ) }}"> 
                <span class="err" id="error-user_type">
                @error('user_type')
                {{$message}}
                @enderror 
                </span>                 
                </div> 
                
                
                <label class="form-label">User authentication module</label>
                <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Module Name</th>
                    <th scope="col"><input class="form-check-input" onClick="check_column(this.checked,'chk_001');"  type="checkbox"> Read</th>
                    <th scope="col"><input class="form-check-input" onClick="check_column(this.checked,'chk_002');" type="checkbox"> Read-Write</th>                    
                  </tr>
                </thead>
                <tbody>
                @php
                if($modules){
                  $count = 0;
                  foreach($modules as $val){
                    $count++;
                    $selected_modules   = old('modules', (array)json_decode($data['modules']) ?? []);
                    $modules_row        = $selected_modules[$val['code']] ?? [];
                    @endphp
                    <tr>
                        <th scope="row">{{ $count }}</th>
                        <th><input class="form-check-input" onClick="check_row(this.checked,'{{ $val['code'].'-ck' }}');"  type="checkbox"> {{ $val['name'] }}</th>
                        
                        <td><input class="form-check-input chk_001 {{ $val['code'].'-ck' }}" type="checkbox" name="modules[{{ $val['code'] }}][]" value="R" 
                        {{ (in_array('R',$modules_row)) ? 'checked' : ''}}></td>

                        <td><input class="form-check-input chk_002 {{ $val['code'].'-ck' }}" type="checkbox" name="modules[{{ $val['code'] }}][]" value="RW"
                        {{ (in_array('RW',$modules_row)) ? 'checked' : ''}}></td>                        

                    </tr> 
                    @php
                  }
                }
                @endphp
                </tbody>
              </table>

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
    const check_column = (isChecked,myclass)=>{  
        if(isChecked) {
            $('.'+myclass).each(function() { 
                this.checked = true; 
            });
        } else {    
            $('.'+myclass).each(function() { 
                this.checked = false;
            });
        }
    }
    
    const check_row = (isChecked,myclass)=>{  
        if(isChecked) {
            $('.'+myclass).each(function() { 
                this.checked = true; 
            });
        } else {    
            $('.'+myclass).each(function() { 
                this.checked = false;
            });
        }
    }
    
    </script>
    
@endsection