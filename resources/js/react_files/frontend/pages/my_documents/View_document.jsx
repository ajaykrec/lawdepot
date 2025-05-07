import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import allFunction from '../../helper/allFunction';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';
import $ from "jquery"
//=== react-to-pdf ===
import generatePDF, { Resolution, Margin } from 'react-to-pdf';
import { useRef } from 'react';
//====

const View_document = () => {

  const { file_storage_url, customer, common_data, pageData } = usePage().props
  const document = pageData.document ?? []  
  const filename = document.file_name + '.pdf'
  const targetRef = useRef();
  const options = {
    filename: filename,
    method: "save",
    // default is Resolution.MEDIUM = 3, which should be enough, higher values
    // increases the image quality but also the size of the PDF, so be careful
    // using values higher than 10 when having multiple pages generated, it
    // might cause the page to crash or hang.
    resolution: Resolution.MEDIUM,
    page: {
      // margin is in MM, default is Margin.NONE = 0
      margin: 10,
      // default is 'A4'
      format: "letter",
      // default is 'portrait'
      orientation: "portrait"
    },
    canvas: {
      // default is 'image/jpeg' for better size performance
      mimeType: "image/jpeg",
      qualityRatio: 1
    },
    // Customize any value passed to the jsPDF instance and html2canvas
    // function. You probably will not need this and things can break,
    // so use with caution.
    overrides: {
      // see https://artskydj.github.io/jsPDF/docs/jsPDF.html for more options
      pdf: {
        compress: true
      },
      // see https://html2canvas.hertzen.com/configuration for more options
      canvas: {
        useCORS: true
      }
    }
  };
  
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
              onClick={() => generatePDF(targetRef, options)}              
              >
              <i className="fa-solid fa-file-arrow-down" style={{fontSize:"18px"}}></i> Download                
              </button> 
              </div>

              <div className="contractPreview">
                <div className="contract" style={{userSelect:"none"}}>
                    <div className="outputVersion1">
                      <div style={{background:"url(/frontend-assets/images/draft_bg.png) repeat-y center top/contain #fff"}}> 
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