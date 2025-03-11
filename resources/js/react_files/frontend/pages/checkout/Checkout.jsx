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

  console.log(customer)
 
  return (
    <>
     {
        customer ?  
        <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />            
        <script src="https://secure.nochex.com/exp/jquery.js"></script>        
        <script src="https://secure.nochex.com/exp/nochex_lib.js"></script> 
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
                <h6>{ membership.name }</h6>
                <h6><b>{ allFunction.currency(membership.price,membership.currency_code) }</b></h6>                  

                <button id="ncx-show-checkout" title="Checkout" className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded">Pay</button> 
                <form id="nochexForm" className="ncx-form" name="nochexForm">
                  <script 
                  id="ncx-config"
                  ncxfield-api_key="nvkd236fb549072428dbb0d2e98a40272b0"
                  ncxfield-merchant_id="Instantly_Legal"
                  ncxfield-amount={membership.price}
                  ncxfield-fullname={customer.name}
                  ncxfield-email={customer.email}
                  ncxfield-phone={customer.phone}
                  ncxfield-order_id={pageData.order_id}
                  ncxfield-test_transaction="true"
                  ncxfield-use_apc="true"                      
                  ncxfield-success_url={ route('membership.checkout.success') }
                  ncxfield-callback_url={ route('membership.checkout.callback') }                 
                  ncxfield-optional_1="xcdfggg"                   
                  ></script>
                </form>

                <p className="p-2">
                By selecting Place Secure Order, you agree to the 
                <Link href={ route('terms') } style={{color:"rgb(19 111 254)"}}><b>Terms of Use</b></Link>.
                </p>
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