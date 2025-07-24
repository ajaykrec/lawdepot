
<div class="modal-header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Copy <b>{{ $step['name'] }}</b> to <i class="bi bi-arrow-down"></i></h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form id="STEP-COPY-FORM" name="STEP-COPY-FORM" method="post" 
enctype="multipart/form-data" onsubmit="return validate_form()">
@csrf
<input type="hidden" name="step_id" value="{{ $step['step_id'] }}">

<div class="row">
<div class="col-12">

<div class="m-3">
<label class="form-label">Document</label>
<select class="form-select" name="document_id">
  <option value="">-- select document --</option>
  @foreach($documents as $val)
  <option value="{{ $val['document_id'] }}">{{ $val['name'] }}</option>
  @endforeach
</select>
<span class="err" id="error-document_id">
@error('document_id')
{{ $message }}
@enderror 
</span>             
</div>

<div class="m-3">
<button 
  type="submit" 
  class="btn btn-sm btn-primary" 
  title="Copy"
  id="step-{{ $step['step_id'] }}"                                                         
  >Copy 
  <span id="step-spinner-{{ $step['step_id'] }}"></span>
</button>
</div>

</div>
</div>
</form>
</div>

 <script>
    var formStep = document.getElementById('STEP-COPY-FORM');

    formStep.querySelector('[name="document_id"]')
    .addEventListener('keyup',(e)=>{
        validate_document_id('document_id')
    })      

    var validate_document_id = (field_name)=>{	
        let input = formStep.elements[field_name]

        if (input.value.trim() === "") {
            input.classList.add("error")
            document.getElementById('error-'+field_name).innerHTML = 'This is required'
            return 1
        }    
        else{
            input.classList.remove("error")
            document.getElementById('error-'+field_name).innerHTML = ''
            return 0
        }
    }     

    var validate_form = ()=>{
        var total_error = 0;
        total_error = total_error + validate_document_id('document_id') 
        if( total_error == 0 ){ 
           copy_step()
        }
        return false;        
    }  
   
    var copy_step = () =>{ 

        swal({		  
            title				: 'Are you sure?',
            text				: 'You want to copy this step',
            type				: 'warning',
            showCancelButton	: true,
            confirmButtonColor  : '#3085d6',
            cancelButtonColor	: '#d33',
            confirmButtonText	: 'Yes, Copy it!',
            cancelButtonText	: 'No, cancel!',
            confirmButtonClass  : 'btn btn-success',
            cancelButtonClass	: 'btn btn-danger',
            buttonsStyling	: false,
            closeOnConfirm	: false	
        }).then(function () {            
            
            const formData = new FormData(formStep); 
            
            var url = "{{ route('copy.steps.store') }}"  
            var step_id = "{{ $step['step_id'] }}"        
           
            $('#step-'+step_id).prop('disabled', true);
            $('#step-spinner-'+step_id).html('<i class="spinner-border spinner-border-sm" role="status"></i>') 

            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                dataType: "json",
                url: url,   
                processData: false, 
                contentType: false, 
                data: formData, 
                success: function(response){  
                    if(response.status=='success'){
                        $('#step-'+step_id).prop('disabled', false);
                        $('#step-spinner-'+step_id).html('') 
                        location.href = response.url
                    }
                }
            });  
    
	    })	
    
    }   
    
    </script>