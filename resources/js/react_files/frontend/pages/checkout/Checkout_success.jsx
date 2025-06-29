import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import allFunction from '../../helper/allFunction';

//=== react-to-pdf ===
import generatePDF, { Resolution, Margin } from 'react-to-pdf';
//====

const Checkout_success = () => {

  const { file_storage_url, common_data, customer, pageData } = usePage().props  
  
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
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head> 
    <Header_banner />
    <Breadcrumb />    

    <section className="pt-5 pb-0">
      <div className="container h-100">
        <div className="row">
            <div className="col-lg-12 col-md-12 col-12 text-center">  
            <i className="fa-regular fa-circle-check" style={{color:"#00ff00",fontSize:"50px"}}></i>
            {parseWithLinks(''+pageData.page.content+'')}              
            </div> 
        </div>
      </div>
    </section>   
    
    </>
  )
}
Checkout_success.layout = page => <Layout children={page} />
export default Checkout_success