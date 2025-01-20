import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

const Breadcrumb = () => {

  const { file_storage_url, common_data, pageData } = usePage().props 
  const header_banner = pageData.header_banner ?? {}
  const breadcrumb = pageData.breadcrumb ?? []

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
    <section className={ (header_banner.banner_image || header_banner.banner_text) ? 'breadcrumbs' : 'breadcrumbs ipad-top-space-margin' }>
        <div className="container">
        <div className="d-flex justify-content-between align-items-center">
            {/* <h2>{parseWithLinks(''+header_banner.title+'')}</h2> */}
            <ol>
                {
                    breadcrumb.map( (val,i)=>{
                        console.log(i)
                        if(val.url){

                            return(
                                <li key={i}>
                                    <Link href={ val.url }>
                                    {
                                        i == 0 ?
                                        <i className="fa-solid fa-house"></i>  
                                        :
                                        val.name
                                    }                                    
                                    </Link>
                                </li>
                            )
                        }
                        else{
                            return(
                                <li key={i}>{val.name}</li>
                            )
                        }                        
                    })
                }
            </ol>
        </div>
        </div>
    </section>
    </>
  )
}
Breadcrumb.layout = page => <Layout children={page} />
export default Breadcrumb