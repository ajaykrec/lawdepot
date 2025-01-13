import React, { useState, useEffect } from 'react';
import { Head, useForm, usePage } from '@inertiajs/react'
import $ from "jquery"

import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

const SweetAlert = () => {

    const { flash } = usePage().props
    
    const MySwal = withReactContent(Swal)

    let error_message = flash.error_message ?? ''
    let success_message = flash.success_message ?? ''

    if( error_message ){
        MySwal.fire({
            animation: false,
            title: "Error!",
            html: error_message,                        
            confirmButtonText: 'Ok', 
            confirmButtonColor: '#d33'
        });
    }
    else if( success_message ){
        MySwal.fire({
            animation: false,
            title: "Thanks!",
            html: success_message,                        
            confirmButtonText: 'Close', 
            confirmButtonColor: '#72bf6a'
        });
    }    

}
export default SweetAlert