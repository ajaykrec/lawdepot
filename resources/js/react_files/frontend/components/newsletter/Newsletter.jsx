import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Newsletter = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props  

    useEffect(()=> {  
         
    },[])  
    
    const parseWithLinks = (html) =>{
        const options = {     
            replace: ({ name, attribs, children }) => {
                if (name === 'a' && attribs.href) {
                    return <Link href={attribs.href} className={attribs.class}>{domToReact(children)}</Link>;
                }
            }
        }     
        return Parser(html, options);
    }    
 
  return (
    <>
    <span className="fs-17 fw-500 d-block text-white mb-5px">Subscribe our newsletter</span>
    <p className="mb-20px">Subscribe our newsletter to get the latest news and updates!</p>
    <div className="d-inline-block w-100 newsletter-style-02 position-relative mb-15px">
        <form
        action="email-templates/subscribe-newsletter.php"
        method="post"
        className="position-relative w-100">
        <input
            className="input-small bg-transparent-white-light border-color-transparent w-100 form-control pe-50px ps-20px lg-ps-15px required"
            type="text"
            name="email"
            placeholder="Enter your email" autoComplete='off'/>
            <input type="hidden" name="redirect" />
            <button className="btn pe-20px submit" aria-label="submit">
                <i className="icon bi bi-envelope icon-small text-white"></i>
            </button>
            <div className="form-results border-radius-4px pt-5px pb-5px ps-15px pe-15px fs-14 lh-22 mt-10px w-100 text-center position-absolute d-none"></div>
        </form>
    </div>
    </>
  )
}
Newsletter.layout = page => <Layout children={page} />
export default Newsletter