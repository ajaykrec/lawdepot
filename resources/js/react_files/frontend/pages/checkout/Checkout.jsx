import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import allFunction from '../../helper/allFunction';

const Checkout = () => {

  const { file_storage_url, common_data, customer, pageData } = usePage().props  
  const country = common_data.country
  const membership = pageData.membership
  const stripe_publishable_key = pageData.stripe_publishable_key
  

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
     {
        customer ?  
        <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />            
        <script async src="https://js.stripe.com/v3/buy-button.js"></script>                          
        </Head>                
        :
        <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />  
        </Head>                     
    }
    <Header_banner />
    <Breadcrumb />    

    <section className="py-5">
      <div className="container h-100">
        <div className="row">
            <div className="col-lg-12 col-md-12 col-12"> 
            {parseWithLinks(''+pageData.page.content+'')}
            
              <div className="text-center pt-5">
              {
                customer ?
                <>  
                <stripe-buy-button
                  buy-button-id={membership.stripe_buy_button_id}                                
                  publishable-key={stripe_publishable_key}
                >
                </stripe-buy-button>
                </>
                :                
                <p className="p-2">
                Please <Link href={ route('customer.login')+'?return_url=' + route('membership.checkout') } style={{color:"rgb(19 111 254)"}}><b>login</b></Link> or <Link href={ route('customer.register')+'?return_url=' + route('membership.checkout') } style={{color:"rgb(19 111 254)"}}><b>create an account</b></Link> to continue checkout.                
                </p>               
              }
              </div>
            </div> 
        </div>
      </div>
    </section>      
    </>
  )
}
Checkout.layout = page => <Layout children={page} />
export default Checkout