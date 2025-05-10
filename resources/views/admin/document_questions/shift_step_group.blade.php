<option value=""></option> 
@if($group_count)
    @for( $i=1; $i<=$group_count; $i++ )     
    <option value="{{ $i }}" {{ (old('label_group')==$i) ? 'selected' : '' }}>{{ $i }}</option> 
    @endfor
@endif