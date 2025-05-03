import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Category_banner from '../../components/banner/Category_banner';
import Steps_header from './Steps_header';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

import anime from 'animejs/lib/anime.es.js';

import OpenAI from 'openai';

const Document_download = () => {

  const { file_storage_url, open_api_key, common_data, pageData } = usePage().props

  const document = pageData.document
  const steps = pageData.steps
  const percent = pageData.percent
  const templateApiJsonData = pageData.templateApiJsonData  

  useEffect( ()=>{  
    
  },[])  

  const get_openai_data = async () =>{
    /*
    const client = new OpenAI({
      apiKey:open_api_key, 
      dangerouslyAllowBrowser: true
    });

    const messagesArr = [
        { role: 'system', content: `You are a  ${templateApiJsonData.country} based legal document professional.` },
        { role: 'user', content: `Generate a elaborated and well formatted legal  ${templateApiJsonData.document_name} for the following details: ${JSON.stringify(templateApiJsonData.question)}`},
    ]
    console.log(messagesArr)       

    const response = await client.chat.completions.create({
        model: 'gpt-4o',
        messages: messagesArr,
    });
    console.log(response)
    */
  }

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

  //console.log(templateApiJsonData)
 
  return (
    <>
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head> 
    <Steps_header /> 
    <Breadcrumb /> 
    
    <section className="py-5">
      <div className="container h-100">  
          <div className="row text-center"> 
            <div className="col-12">   
              {
                pageData.active_membership ?
                <>                
                <Link href={ route('save.document') } className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded">Save Document</Link> 
                </>
                :
                <>
                <h6>To download and print your Residential Rental Agreement, you must select a free or premium licence.</h6> 
                <Link href={ route('membership.index')} className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded">Select Membership</Link> 
                </>
              }                          
            </div>
          </div>
      </div>
    </section> 
    
    <section className="pt-0 pb-5">
      <div className="container">  
          <div className="row"> 
            <div className="col-lg-12 col-md-12 col-12"> 

              <div className="contractPreview">
                <div className="contract" style={{userSelect:"none"}}>
                    <div className="outputVersion1">
                      <div style={{background:"url(/frontend-assets/images/draft_bg.png) repeat-y center top/contain #fff"}}> 
                      { parseWithLinks(''+document.template+'') }  
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
Document_download.layout = page => <Layout children={page} />
export default Document_download