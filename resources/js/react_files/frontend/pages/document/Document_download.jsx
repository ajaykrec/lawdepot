import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Category_banner from '../../components/banner/Category_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

import anime from 'animejs/lib/anime.es.js';

const Document_download = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props

  const document = pageData.document
  const steps = pageData.steps
  const percent = pageData.percent

  useEffect(()=>{  
         
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
    
    <section className="ipad-top-space-margin py-5" style={{background:"#152bca"}}> 
        <div className="container">
            <div className="row text-center">
                
                <div className="col-12 page-title-extra-small">                    
                    <h2 className="text-white fw-600 ls-minus-1px">                    
                    { document.name }                   
                    </h2>                                                       
                </div>
                <div className="col-12 mb-2"> 
                  
                  <div className="steps">
                    {
                        steps.map((val,i)=>{
                          return(
                            <Link key={i} href={ route('doc.index',document.slug)+'?step_id='+val.step_id+'&group=1' } className="btn btn-very-small bg-info">{val.name}<i className="fa-solid fa-arrow-right"></i></Link>
                          )                          
                        })

                    }                    
                    <Link href={ route('doc.download',document.slug) } className="btn btn-very-small bg-light">Print/Download</Link>                    
                  </div>                  
                  
                  <div className="progress-bar-style-03 m-1" style={{width:"70%"}}>                               
                    <div className="progress bg-info text-dark-gray ">
                        {/* <div className="fs-18 fw-600 progress-bar-title d-inline-block text-white">Progress</div> */}
                        <div className="progress-bar bg-light m-0 border-radius-3px" 
                        role="progressbar" 
                        aria-valuenow={percent} 
                        aria-valuemin="0" 
                        aria-valuemax="100" 
                        aria-label="consulting" 
                        style={{width:percent+"%"}}>
                        </div>
                        {/* <span className="progress-bar-percent fs-16 fw-600 text-white">83%</span> */}
                    </div>                                
                  </div>                        

                </div>                
            </div>
        </div>
    </section>  
    
    <section className="py-5">
      <div className="container h-100">  

          <div className="row text-center"> 
            <div className="col-12 pb-5">   
              <h6>To download and print your Residential Rental Agreement, you must select a free or premium licence.</h6> 
              <Link href={ route('membership.index')} className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded">Select Membership</Link>             
            </div>

          </div>

      </div>
    </section>  
    
    </>
  )
}
Document_download.layout = page => <Layout children={page} />
export default Document_download