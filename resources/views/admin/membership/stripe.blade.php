<div class="my-3">
<label class="form-label">Stripe Product ID</label>
<input type="text" class="form-control" id="stripe_product_id" name="stripe_product_id" value="{{ old('stripe_product_id', $data['stripe_product_id'] ?? '') }}"> 
<span class="err" id="error-stripe_product_id">
@error('stripe_product_id')
{{$message}}
@enderror 
</span>                 
</div>

<div class="my-3">
<label class="form-label">Stripe Buy Button ID</label>
<input type="text" class="form-control" id="stripe_buy_button_id" name="stripe_buy_button_id" value="{{ old('stripe_buy_button_id', $data['stripe_buy_button_id'] ?? '') }}"> 
<span class="err" id="error-stripe_buy_button_id">
@error('stripe_buy_button_id')
{{$message}}
@enderror 
</span>                 
</div>