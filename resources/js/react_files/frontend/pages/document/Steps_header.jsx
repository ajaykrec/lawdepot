import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Steps_header = () => {

    const { file_storage_url, common_data, pageData } = usePage().props 
  
    const document = pageData.document
    const steps = pageData.steps
    const step_id = pageData.step_id ?? ''
    const group = pageData.group ?? ''
    const percent = pageData.percent 

    useEffect(()=> {  
         
    },[])  
 
    return (
      <>      
        <section className="py-5" style={{background:"#191E44"}}> 
            <div className="container">
                <div className="row text-center">
                    
                    <div className="col-12 page-title-extra-small">                    
                        <h2 className="text-white fw-600 ls-minus-1px">                    
                        { document.name }                   
                        </h2>                                                       
                    </div>

                    {
                      steps.length > 0 &&
                      <div className="col-12 mb-2"> 
                        
                        <div className="steps">
                          {
                              steps.map((val,i)=>{
                                return(
                                  <Link key={i} href={ route('doc.index',document.slug)+'?step_id='+val.step_id+'&group=1' } className={ (val.step_id == step_id) ? 'btn btn-very-small bg-info bg-light' : 'btn btn-very-small bg-info' }>
                                    {val.name}<i className="fa-solid fa-arrow-right"></i>
                                  </Link>
                                )                          
                              })
      
                          }                    
                          <Link href={ route('doc.download',document.slug) } 
                          className={ (step_id) ? 'btn btn-very-small bg-info' : 'btn btn-very-small bg-info bg-light' }
                          >
                          <i className="fa-solid fa-file-arrow-down" style={{fontSize:"18px"}}></i> &nbsp;
                          Print/Download
                          </Link>                    
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
                    }               
                </div>
            </div>
        </section> 
      </>
    )
}
Steps_header.layout = page => <Layout children={page} />
export default Steps_header