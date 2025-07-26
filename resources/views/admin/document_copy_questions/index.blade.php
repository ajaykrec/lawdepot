
<div class="modal-header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Copy <b>{{ $question['question'] }}</b> to <i class="bi bi-arrow-down"></i></h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form id="QUESTION-COPY-FORM" name="QUESTION-COPY-FORM" method="post" 
enctype="multipart/form-data" onsubmit="return validate_form()"> 
@csrf
<input type="hidden" name="question_id" value="{{ $question['question_id'] }}">

<div class="row">
<div class="col-12">

<div class="m-3">
<label class="form-label">Document</label>
<select class="form-select" name="document_id" onchange="get_steps(this.value)">
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
<label class="form-label">Step</label>
<select class="form-select" name="step_id" id="document-step-box">
@include('admin.document_copy_questions.steps')
</select>
<span class="err" id="error-step_id">
@error('step_id')
{{ $message }}
@enderror 
</span>             
</div>

<div class="m-3">
<button 
  type="submit" 
  class="btn btn-sm btn-primary" 
  title="Copy"
  id="question-{{ $question['question_id'] }}"                                                         
  >Copy 
  <span id="question-spinner-{{ $question['question_id'] }}"></span>
</button>
</div>

</div>
</div>
</form>
</div>

 <script>
    var formQue = document.getElementById('QUESTION-COPY-FORM');

    formQue.querySelector('[name="document_id"]')
    .addEventListener('keyup',(e)=>{
        validate_document_id('document_id')
    })    
    
    formQue.querySelector('[name="step_id"]')
    .addEventListener('keyup',(e)=>{
        validate_step_id('step_id')
    })      

    var validate_document_id = (field_name)=>{	
        let input = formQue.elements[field_name]
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
    
    var validate_step_id = (field_name)=>{	
        let input = formQue.elements[field_name]
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
        total_error = total_error + validate_step_id('step_id') 
        if( total_error == 0 ){ 
           copy_question()
        }
        return false;        
    }  

    var get_steps = (document_id)=>{

        var url = "{{ route('copy.questions.steps','document_id') }}"  
        url = url.replace("document_id", document_id);        

        $.ajax({
            type: "get",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: "json",
            url: url, 
            data: {}, 
            success: function(response){  
                if(response.status=='success'){                   
                    $('#document-step-box').html(response.html)                    
                }
            }
        });  
    }
   
    var copy_question = () =>{ 

        swal({		  
            title				: 'Are you sure?',
            text				: 'You want to copy this question',
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
            
            const formData = new FormData(formQue); 
            
            var url = "{{ route('copy.questions.store') }}"  
            var question_id = "{{ $question['question_id'] }}"        
           
            $('#question-'+question_id).prop('disabled', true);
            $('#question-spinner-'+question_id).html('<i class="spinner-border spinner-border-sm" role="status"></i>') 

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
                        $('#question-'+question_id).prop('disabled', false);
                        $('#question-spinner-'+question_id).html('') 
                        location.href = response.url
                    }
                }
            });  
    
	    })	
    
    }  
    </script>