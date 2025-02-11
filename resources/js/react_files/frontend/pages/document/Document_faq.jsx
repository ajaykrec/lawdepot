import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Document_faq = () => {

    const { file_storage_url, common_data, pageData } = usePage().props   
  
    useEffect(()=> {  
         
    },[])  

    const faqs = pageData.faqs
    
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
      { 
        faqs.length > 0 &&       
        <div className="row justify-content-center my-4 documentfaq">
            <div className="col-lg-12 col-md-12 col-12 align-items-center">
                <h6 className="text-dark-gray mb-0">Frequently Asked Questions</h6>
            </div> 
            <div className="col-lg-12 col-md-12 col-12"> 
                <div className="accordion accordion-style-02" id="accordion-style-02" data-active-icon="icon-feather-chevron-up" data-inactive-icon="icon-feather-chevron-down">                  
                    
                    {
                        faqs.map((item,i)=>{

                            return(
                            <div key={i} className={ i == 0 ? 'accordion-item active-accordion' : 'accordion-item' } >
                                <div className="accordion-header border-bottom border-color-extra-medium-gray">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target={`#accordion-${i}`} aria-expanded="false" data-bs-parent="#accordion-style-02">
                                        <div className="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                            <i className="feather icon-feather-chevron-down icon-extra-medium"></i>
                                            <span className="question">{parseWithLinks(''+item.question+'')}</span>
                                        </div>
                                    </a>
                                </div>
                                <div id={`accordion-${i}`} className={ i == 0 ? 'accordion-collapse collapse show' : 'accordion-collapse collapse' } data-bs-parent="#accordion-style-02">
                                    <div className="accordion-body last-paragraph-no-margin border-bottom border-color-light-medium-gray answer">
                                        <p>{parseWithLinks(''+item.answer+'')}</p>
                                    </div>
                                </div>
                            </div>
                            )
                        })
                    }                  
                    
                </div>
            </div>
        </div>  
      }
      </>
    )
}
Document_faq.layout = page => <Layout children={page} />
export default Document_faq