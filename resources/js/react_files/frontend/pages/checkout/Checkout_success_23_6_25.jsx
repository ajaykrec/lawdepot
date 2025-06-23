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
  const document_id = pageData.document_id
  const document = pageData.document 
  const template = document.template ?? ''  

  const filename = (document.file_name) ? document.file_name + '.pdf' : ''
  const targetRef = useRef();
  const pdf_options = allFunction.reactPdfOtions(filename)
  
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

    {
      document_id &&
      <section className="pt-0 pb-5">
        <div className="container">  
            <div className="row"> 
              <div className="col-lg-12 col-md-12 col-12 text-center"> 

                <div className='p-2'>
                <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded"
                onClick={() =>{
                    generatePDF(targetRef, pdf_options)
                    const timeoutId = setTimeout(() => {
                      location.href = route('save.document')
                    }, 3000);
                    return () => clearTimeout(timeoutId);

                }} 
                >Save and Download</button> 
                </div>

                <div className="contractPreview">
                  <div className="contract" style={{userSelect:"none"}}>
                      <div className="outputVersion1">
                        <div id='pdf-id' ref={targetRef}> 
                        { parseWithLinks(''+template+'') }      
                        </div>
                      </div>
                  </div>   
                </div>   
                            
              </div>   
            </div> 
        </div>   
      </section>   
    }
    
    </>
  )
}
Checkout_success.layout = page => <Layout children={page} />
export default Checkout_success