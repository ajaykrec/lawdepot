import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

const Checkout = ({ pageData }) => {

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
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head> 
    <Header_banner />
    <Breadcrumb />    

    <section className="py-5">
      <div className="container h-100">
        <div className="row">
            <div className="col-12"> 
            {parseWithLinks(''+pageData.page.content+'')}
            </div> 
        </div>
      </div>
    </section>      
    </>
  )
}
Checkout.layout = page => <Layout children={page} />
export default Checkout