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

  console.log(membership)
 
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
            <div className="col-lg-12 col-md-12 col-12"> 
            {parseWithLinks(''+pageData.page.content+'')}
            
              <div className="text-center pt-5">
              {
                customer ?
                <>
                <h6>{ membership.name }</h6>
                <h6><b>{ allFunction.currency(membership.price,membership.currency_code) }</b></h6>                
                <form action="https://secure.nochex.com/" method="post" name="nochexForm">
                  <input type="hidden" name="merchant_id" value="Instantly_legal" />
                  <input type="hidden" name="description" value={membership.name} />
                  <input type="hidden" name="order_id" value={pageData.order_id} />
                  <input type="hidden" name="initial_amount" value={membership.price} />
                  <input type="hidden" name="amount" value={membership.price} />
                  <input type="hidden" name="interval_number" value="1" />
                  <input type="hidden" name="interval_unit" value="M" />
                  <input type="hidden" name="recurrence_number" value="N" />
                  <input type="hidden" name="recurring_payment" value="1" />
                  <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit">Place Secure Order</button>                  
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