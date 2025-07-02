import React, { useState, useEffect } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import reactDOM from 'react-dom'; 
import { Navigate, useParams } from 'react-router-dom'; 
import allFunction from '../../helper/allFunction';
import Modal from 'react-bootstrap/Modal';
import { useSelector, useDispatch } from 'react-redux'
import { membershipAction } from '../../actions/modal'

const Membership_modal = (props)=>{ 
 
  const dispatch = useDispatch()  
  const membershipModelState = useSelector( (state)=> state.membership_modal )  
  
  const { file_storage_url, customer, common_data, pageData } = usePage().props
  const country = common_data.country

	useEffect(() => {	
	},[props]);  

  const subscription = props.subscription 
  const membership = subscription.membership 
  const order = subscription.order 
  const orderitems = subscription.orderitems 

  return reactDOM.createPortal(   
	  <>      
      <Modal show={membershipModelState.show} size="lg" onHide={()=>dispatch(membershipAction(false))} backdrop="static" id=" membership_modal" className='modal-dialog-centered'>
      <Modal.Header closeButton style={{background:"#e2e3e5"}}>
        <Modal.Title className='mb-0'>
        { subscription.subscription_name }
        </Modal.Title> 
      </Modal.Header>
      <Modal.Body className="modal-body">
        <div style={{fontSize:"14px",border:"2px dashed #ccc",background:"#eee"}}  id="mailcontent">       
        <table width="100%" border="0" cellPadding="0" cellSpacing="0">
        <tbody>
        <tr>
          <td>
            <div style={{padding:"10px",borderBottom:"1px solid #ccc"}}>
            <img src="/frontend-assets/images/logo.png" alt="" width="100" />
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div style={{padding:"15px"}}>
            <div className="col-sm-4" style={{padding:"10px",float:"left"}}>
            <strong>From</strong>
            <br />
            { common_data.settings.site_name }<br />
            <b>Email : </b> { common_data.settings.contact_email }<br />
            <b>Phone : </b> { common_data.settings.contact_phone }<br />
            <b>Address : </b> { common_data.settings.contact_address }<br /></div>
            <div className="col-sm-4" style={{padding:"10px",float:"left"}}>
            <strong>To</strong>
            <br />
            { order.name }<br />
            <b>Email : </b>{ order.email }<br />
            <b>Phone : </b>{ order.phone }<br />
            { order.billing_country }
            </div>

            <div className="col-sm-4" style={{padding:"10px",float:"left"}}>
            <b>Invoice ID : </b>{ order.invoice_number }<br/>
            <b>Order Date : </b>{ allFunction.dateFormat(order.created_at)  }<br/>
            <b>Amount : </b>{ allFunction.currency( order.total, order.currency_code)  }<br/>
            <b>Transaction ID : { order.transaction_id }</b><br/>
            <b>Payment Methods : { order.payment_method }</b> 
            </div>
            </div>
          </td>
        </tr>
        </tbody>
        </table>
        <div className="row" style={{margin:"10px"}}>
        <div className="table-responsive">
        <table
            border="0"
            cellPadding="5"
            cellSpacing="0"
            className="table table-striped"
            style={{width:"100%",border:"1px solid #ccc"}}
            >
            <thead style={{background:"ccc"}}>
                <tr>
                    <td width="30%">Product</td>
                    <td width="30%">Option</td>
                    <td width="10%" align="center">Qty</td>
                    <td width="15%" align="center">Price</td>
                    <td width="15%" align="right" style={{paddingRight:"15px"}}>Subtotal</td>
                </tr>
            </thead>
            <tbody>
              {
                orderitems.map((val,i)=>{     
                  let total = val.price * val.quantity             
                  return(
                    <tr key={i} style={{background:"eee"}}>
                        <td>
                        <strong>{ val.item_name }</strong>
                        </td>
                        <td></td>
                        <td align="center">{ val.quantity }</td>
                        <td align="center">{ allFunction.currency( val.price, order.currency_code)  }</td>
                        <td align="right" style={{paddingRight:"15px"}}>{ allFunction.currency( total.toFixed(2), order.currency_code)  }</td>
                    </tr>
                  )

                })
              }
            </tbody>
            </table>
        </div>
        </div>        
        <div className="row" style={{margin:"10px"}}>
        <div className="col-sm-12">
            <div className="table-responsive text-right">
                <table border="0" cellPadding="0" cellSpacing="15" style={{float:"right",marginRight:"15px"}}>
                    <tbody>
                        <tr>
                            <td align="right" style={{width:"250px"}}>Subtotal : </td>
                            <td align="right">{ allFunction.currency( order.sub_total, order.currency_code) }</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Total : </strong></td>
                            <td align="right">{ allFunction.currency( order.total, order.currency_code) }</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>       
        
        </div>
      </Modal.Body>      
      </Modal>       
    </>, document.querySelector('#main-modal')    
    );
 
}
export default Membership_modal;

