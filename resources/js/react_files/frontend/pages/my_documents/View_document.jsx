import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect, useRef } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import allFunction from '../../helper/allFunction';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';
import $ from "jquery"

//=== react-to-pdf ===
import generatePDF, { Resolution, Margin } from 'react-to-pdf';
//====

const View_document = () => {

  const { file_storage_url, customer, common_data, pageData } = usePage().props
  const document = pageData.document ?? []  
  const filename = document.file_name + '.pdf'
  const targetRef = useRef();
  const pdf_options = allFunction.reactPdfOtions(filename)
  
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
    <section className="section py-5">
      <div className="container">
          <div className="row">           
            <div className="col-lg-3 col-md-12 col-12">   
            <MyAccountNavBar />          
            </div>
            <div className="col-lg-9 col-md-12 col-12">   
            
              <div className='p-2 text-center'>
              <button type='button' className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded"
                onClick={() =>{
                    generatePDF(targetRef, pdf_options)
                }}              
              >
              <i className="fa-solid fa-file-arrow-down" style={{fontSize:"18px"}}></i> Download                
              </button> 
              </div>

              <div className="contractPreview">
                <div className="contract" style={{userSelect:"none"}}>
                    <div className="outputVersion1">
                      <div> 
                      <div className='p-3' id='pdf-id' ref={targetRef}>                        
                        { parseWithLinks(''+document.openai_document+'') }                         
                      </div>   
                      </div>
                    </div>
                </div>   
              </div> 
            
            </div>            
          </div>
      </div> 
    </section>  
    </>
  )
}
View_document.layout = page => <Layout children={page} />
export default View_document