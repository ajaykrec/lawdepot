<div class="my-3">
    <label class="form-label">Specification</label>
    @php
    $specification = old('specification', (array)json_decode($data['specification'] ?? ''));
    $specification_description = $specification['description'] ?? [];   
    @endphp

    @if($specification)
        @foreach($specification_description as $key=>$val)
        @php
        $description = $specification_description[$key] ?? '';        
        @endphp
        <div class="row control-group">  
            
            <div class="col-lg-10 col-md-10 col-12 p-2">
            <div class="form-group">            
			<textarea class="form-control" rows="5" name="specification[description][]" placeholder="Specify">{{ $description }}</textarea>	            
            </div>
            </div>             
            
            <div class="col-lg-2 col-md-2 col-12 p-2">
            <div class="form-group d-grid">
            <button  type="button" class="btn btn-primary btn-md remove">X</button>
            </div>
            </div>
		</div>
        @endforeach
    @endif
    <div class="row after-add-more text-left">
    <div class="col-12">     
    <a href="javascript:void(0);" class="add-more" type="button">+Add new specification</a>
    </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {	  
	  
	  var html ='';
	  html    += '<div class="row control-group">';	  
	  
	  html    += '<div class="col-lg-10 col-md-10 col-12 p-2">';
	  html    += '<div class="form-group">';	
	  html    += '<textarea class="form-control" rows="5" name="specification[description][]" placeholder="Specify"></textarea>';
	  html    += '</div>';
	  html    += '</div>';		 
	  
	  html    += '<div class="col-lg-2 col-md-2 col-12 p-2">';	   
	  html    += '<div class="form-group d-grid">';	
	  html    += '<button type="button" class="btn btn-primary btn-md remove">X</button>';	
	  html    += '</div>';	
	  html    += '</div>';	
	  
	  html    += '</div>';	  
	  
      $(".add-more").click(function(){ 
          $(".after-add-more").before(html);
      });
      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });

});
</script>
 