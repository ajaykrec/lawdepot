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

  const data = props.data 

  return reactDOM.createPortal(   
	  <>      
      <Modal show={membershipModelState.show} size="lg" onHide={()=>dispatch(membershipAction(false))} backdrop="static" id=" membership_modal" className='modal-dialog-centered'>
      <Modal.Header closeButton style={{background:"#e2e3e5"}}>
        <Modal.Title className='mb-0'>
        { data.name }
        </Modal.Title> 
      </Modal.Header>
      <Modal.Body className="modal-body">
        <ul className="list-group list-group-flush">          
          <li className="list-group-item px-0">
            <b>Price : </b> { allFunction.currency(data.price, data.currency_code) } 
          </li>
          <li className="list-group-item px-0">
            <b>Time Period : </b> { data.time_period +' '+data.time_period_sufix }
          </li>
          <li className="list-group-item px-0">
            <b>Description : </b> 
            { data.description }
          </li>
        </ul>
      </Modal.Body>      
      </Modal>       
    </>, document.querySelector('#main-modal')    
    );
 
}
export default Membership_modal;

