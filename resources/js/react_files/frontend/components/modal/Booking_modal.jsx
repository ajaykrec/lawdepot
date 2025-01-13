import React, { useState, useEffect } from 'react';
import reactDOM from 'react-dom'; 
import Modal from 'react-bootstrap/Modal';

const Booking_modal = ( {resetModal, data} )=>{   

  const [show, set_show] = useState(data.show);    

  return reactDOM.createPortal(   
	  <>      
      <Modal 
      size="lg"
      backdrop="static" id="booking_modal" className='modal-dialog-centered'
      show={show} 
      onHide={()=>{
        set_show(false)
        resetModal({
           show:false,
           portfolio_id:'', 
           portfolio_name:'',               
        })
      }} 
      >
      <Modal.Header closeButton>
      <Modal.Title>
      Booking
      </Modal.Title> 
      </Modal.Header>
      <Modal.Body className="modal-body">
      <div className="bg-secondary rounded p-5">
      
      </div>
      </Modal.Body>      
      </Modal>       
    </>, document.querySelector('#main-modal')    
    );
 
}
export default Booking_modal;

