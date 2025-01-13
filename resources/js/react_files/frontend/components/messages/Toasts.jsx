import React, { useState, useEffect } from 'react';
import { Head, useForm, usePage } from '@inertiajs/react'
import $ from "jquery"

const Toasts = () => {

    const { flash } = usePage().props
    //console.log(flash)

    const showToaster = (obj)=>{    
        let status  = obj.status;
        let message = obj.message;

        $('.toast').removeClass('bg-danger')
        $('.toast').removeClass('bg-warning')
        $('.toast').removeClass('bg-success')
        $('.toast').removeClass('bg-secondary')

        if(status=='error'){
            $('.toast').addClass('bg-danger')
        }
        else if(status=='warning'){
            $('.toast').addClass('bg-warning')
        }    
        else if(status=='success'){
            $('.toast').addClass('bg-success')
        }
        else{
            $('.toast').addClass('bg-secondary')
        }    
        $('.toast-body').html(message)
        new bootstrap.Toast('.toast').show();
    }
    const hideToaster = (obj)=>{    
        new bootstrap.Toast('.toast').hide();    
    }

    if( flash.error_message ){
        showToaster({
            'status':'error',
            'message':flash.error_message
        })
    }
    else if( flash.success_message ){
        showToaster({
            'status':'success',
            'message':flash.success_message
        })
    }

    return (
        <>
        <div className="position-fixed bottom-0 end-0 p-3" style={{zIndex:"11"}}>
                <div className="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div className="d-flex">
                        <div className="toast-body"></div>
                        {
                            (flash.error_message || flash.success_message) ?
                            <>
                            <button type="button" className="btn-close btn-close-white me-2 m-auto" style={{fontSize:"45px",position:"absolute",top:"5px",right:"0px",zIndex:"100",color:"#fff"}} data-bs-dismiss="toast" aria-label="Close"></button>
                            </>
                            :''
                        }        
                    </div>
                </div>
            </div>            
        </>
    )

}
export default Toasts