import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

const MyAccountNavBar = () => {

    const { file_storage_url, common_data, customer, pageData } = usePage().props 
    
    useEffect(()=> {  
         
    },[])      
    
    let ccp             = window.location.pathname;
	let ccp2     		= ccp.split('/')
	let current_path    = (ccp2[1]) ? ccp2[1] : ''   

    const membership_menu       = ['my-membership']; 
    const settings_menu         = ['my-account-settings']; 
    const change_password_menu  = ['change-password']; 
    const documents_menu        = ['my-documents']; 
    
    return (
        <> 
        <div className="my-account-navbar d-grid gap-1 pb-5">            
            <Link href={ route('customer.membership') }  className={`btn btn-very-small ${membership_menu.includes(current_path) ? 'present' : ''}`}>Subscription and license</Link>
            <Link href={ route('customer.settings') }  className={`btn btn-very-small ${settings_menu.includes(current_path) ? 'present' : ''}`}>Account Settings</Link>
            <Link href={ route('customer.changepassword') }  className={`btn btn-very-small ${change_password_menu.includes(current_path) ? 'present' : ''}`}>Change Password</Link>
            <Link href={ route('customer.documents') }  className={`btn btn-very-small ${documents_menu.includes(current_path) ? 'present' : ''}`}>My Documents</Link>
        </div>   
        </>
    )
}
MyAccountNavBar.layout = page => <Layout children={page} />
export default MyAccountNavBar