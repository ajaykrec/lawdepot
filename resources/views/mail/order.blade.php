@php 
$show_tag = $data['show_tag'] ?? '';
@endphp

<div style="font-size:14px;border:2px dashed #ccc; background: #eee" id="mailcontent"> 

@if($show_tag == '1')
    @if($data['payment_status']=='0')
    <div class="discount-label">
      <span class="text-light">Unpaid</span>
    </div> 
    @elseif($data['payment_status']=='1')
    <div class="discount-label">
      <span class="text-light">Paid</span>
    </div> 
    @endif
@endif
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
      <div style="border-bottom:1px solid #ccc; padding:10px;">
	    <img src="{{ $data['setting']['logo'] ?? '' }}" alt="" width="100">		
      </div>    
      </td>
    </tr>
    <tr>
      <td>
        <div style="padding:15px;">        
            <div class="col-sm-4" style="padding:10px;float:left;"> 
            <strong>From</strong><br>
            {{ $data['setting']['site_name'] ?? '' }}<br>
            Email : {{ $data['setting']['contact_email'] ?? '' }}<br>
            Phone : {{ $data['setting']['contact_phone'] ?? '' }}<br>
            Address : {!! $data['setting']['contact_address'] ?? '' !!}<br>
            </div>
            
            <div class="col-sm-4" style="padding:10px;float:left;"> 
            <strong>To </strong><br>
            {{ $data['name'] ?? '' }}<br>
            Email : {{ $data['email'] ?? '' }}<br>
            Phone : {{ $data['phone'] ?? '' }}<br>
            {{ $data['address'] ?? '' }} 
            {{ $data['billing_city'] ?? '' }} <br>
            {{ $data['billing_zone'] ?? '' }} {{ $data['billing_postcode'] ?? '' }}<br>
            {{ $data['billing_country'] ?? '' }}
            </div>
        
            <div class="col-sm-4" style="padding:10px;float:left;"> 
            <b>Invoice ID:</b> {{ $data['invoice_number'] }}<br>
            <b>Order Date:</b> {{ full_date_format($data['created_at']) }}<br>
            <b>Amount:</b> {{ currency($data['total']) }}<br>
            <b>Payment Methods:</b> {{ $data['payment_method'] }}
            </div>            
        </div>
      </td>
    </tr>
  </table>
  <div class="row" style="margin:10px;">
    <div class="table-responsive">
      <table border="0" cellpadding="5" cellspacing="0" class="table table-striped" 
      style="width:100%;border:1px solid #ccc;">
        <thead style="background:#ccc;">
          <tr>            
            <td width="30%">Product</td>  
            <td width="30%">Option</td> 
            <td width="10%" align="center">Qty</td>             
            <td width="15%" align="center">Price</td>            
            <td width="15%" align="right" style="padding-right:15px;">Subtotal</td>
          </tr>
        </thead>
        <tbody>
        @php
        $orderitems = $data['orderitems'] ?? [];
        if($orderitems){			
          $count     = 0;
          $sub_total = 0.00;			
          foreach($orderitems as $val){				
            $count++; 				
            if( ($count%2)==0 ){
              $tr_bg = 'style="background:#fff;"';
            }
            else{
              $tr_bg = 'style="background:#eee;"';
            }	
            
            $options_total	   = 0;			
            $option_value_html = '';								
            $options 		   = json_decode($val['options']);			
            
            if( $options ){					
              $val_count = 0;							
              foreach( $options as $key=>$valarr ){							
                $val_count++;
                $tax           = $valarr;
                $options_total = $options_total;
              }
            }
            
            $options_total  = $options_total*$val['quantity'];
            $item_total 	= $val['quantity']*$val['price'] + $options_total;
            $sub_total  	= $sub_total + $item_total;	
            @endphp
                    <tr {{ $tr_bg }}>                
                    <td>
            @php
                    $item_name = '';
            if(!empty($val['item_name'])){
              $item_name .= '<strong>'.$val['item_name'].'</strong><br />'; 
            }
            if( !empty($val['item_description']) ){
              $item_name .= '<span style="font-style:italic; font-size:12px;">'.$val['item_description'].'</span>';
                        
            }
            echo $item_name;
				    @endphp
                </td> 
                <td>{{ $option_value_html }}</td>              
                <td align="center">{{ $val['quantity'] }}</td>
                <td align="center">{{ currency($val['price']) }}</td>
                <td align="right" style="padding-right:15px;">{{ currency($item_total) }}</td>
                </tr>
                @php
			    }
			
		}
		@endphp        
        </tbody>
      </table>
    </div>
  </div>
  <div style="clear:both"></div>
  <div class="row" style="margin:10px;">    
    <div class="col-sm-12">
      <div class="table-responsive text-right">      
        <table border="0" cellpadding="0" cellspacing="15" style="float:right;">
          <tr>
            <td align="right" style="width:250px;">Subtotal : </td>
            <td align="right">&nbsp;{{ currency($data['sub_total']) }}</td>
          </tr>
          
          @if( $data['discount'] > 0 )				
				<tr>
				<td align="right">Discount : </td>
				<td align="right">&nbsp;-{{ currency($data['discount']) }}</td>
				</tr>				
		  @endif

		  @if( $data['delivery_charge'] > 0 )
				<tr>
				<td align="right">Shipping and handling : </td>
				<td align="right">&nbsp;{{ currency($data['delivery_charge']) }}</td>
				</tr>
          @endif
          
          @if( $data['tax'] > 0 )
				<tr>
				<td align="right">Tax : </td>
				<td align="right">&nbsp;{{ currency($data['tax']) }}</td>
				</tr>
		  @endif
          
          <tr>
            <td align="right"><strong>Total : </strong></td>
            <td align="right">&nbsp;{{ currency($data['total']) }}</td>
          </tr>
          
        </table>
      </div>
    </div>
  </div>
  <div style="clear:both"></div>
  @if( !empty($data['comment']) )		
		<div class="row" style="padding:25px;">
		<div class="col-sm-12"> <strong>Special Instruction : </strong><br />
		{{ $data['comment'] }}
        </div>
		</div>
  @endif
  <div style="clear:both; margin-bottom:10px;"></div>
</div>