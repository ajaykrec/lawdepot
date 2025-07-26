@php 
$steps = $steps ?? [];
@endphp
<option value="">-- select step --</option>
@foreach($steps as $val)
<option value="{{ $val['step_id'] }}">{{ $val['name'] }}</option>
@endforeach