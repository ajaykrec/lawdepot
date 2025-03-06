import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

const Search_result = () => {

  const { file_storage_url, common_data, pageData } = usePage().props  

  const documents = pageData.documents

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
    <Breadcrumb />

    <section className="py-5">
      <div className="container h-100">
        <div className="row">
            <div className="col-12"> 
            {/* {parseWithLinks(''+pageData.page.content+'')} */}
            </div>             
        </div>
        <div className="row row-cols-1 row-cols-lg-3 row-cols-sm-2 justify-content-center">  
          
        <div className="col-12 text-center w-100">
          <h6>Search result for : <b>{pageData.s ?? ''}</b></h6>  
          </div>
          
        {
              documents && documents.length > 0 ?
                  documents.map( (val,i)=>{
                    return(
                    <div key={i} className="col icon-with-text-style-07 transition-inner-all mb-30px">
                        <div className="bg-white feature-box h-100 justify-content-start box-shadow-quadruple-large box-shadow-quadruple-large-hover text-start p-17 sm-p-14 border-radius-6px">
                            <div className="feature-box-icon mb-30px">                                 
                            {
                                val.image ?
                                <img src={`${file_storage_url}/uploads/document/${val.image}`} className="h-50px" alt="" />
                                :
                                <img src="/frontend-assets/images/no-photos.png" className="h-50px" alt="" />
                            }
                            </div>
                            <div className="feature-box-content">
                                <span className="d-inline-block fw-600 text-dark-gray fs-18 ls-minus-05px">{ val.name }</span>
                                <p className="mb-10px">{ parseWithLinks(''+val.short_description+'') }</p>
                                <Link href={ route('doc.index',val.slug) } className="btn btn-link btn-hover-animation-switch btn-extra-large text-base-color text-uppercase-inherit">
                                    <span>
                                        <span className="btn-text">Get Started</span>
                                        <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                        <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                    </span> 
                                </Link>
                            </div>                        
                        </div>
                    </div>
                    )
                  })
                :                
                <div className="col-12 text-center w-100">
                <p>No record found!.</p>
                </div>
          }                      
          </div>
      </div>
    </section>      
    </>
  )
}
Search_result.layout = page => <Layout children={page} />
export default Search_result