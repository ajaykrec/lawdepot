import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import allFunction from '../../helper/allFunction';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';


const My_documents = () => {

  const { file_storage_url, customer, common_data, pageData } = usePage().props

  const results = pageData.results ?? []
  const paginate = pageData.paginate ?? []
  const country = common_data.country
  var start_count = pageData.start_count ?? 1
  start_count= start_count-1 
  
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
    <section className="section py-5">
      <div className="container">
          <div className="row">           
            <div className="col-lg-3 col-md-12 col-12">   
            <MyAccountNavBar />          
            </div>
            <div className="col-lg-9 col-md-12 col-12">   
                { pageData.page.content ? <>{parseWithLinks(''+pageData.page.content+'')}</> : '' }  
            
                <div className="table-responsive">                          
                    <table className="table table-hover table-striped">
                      <thead>
                        <tr className='table-secondary'>
                          <th scope="col">#</th>
                          <th scope="col">File name</th>                         
                          <th scope="col">Date</th>
                          <th scope="col" className='text-center'>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        {
                          results ?                        
                          results.map((val,i)=>{
                            start_count++
                            const document = val.document
                            return(
                              <tr key={i}>
                                <th scope="row">{start_count}</th>
                                <td>{ (val.file_name) ? val.file_name : document.name }</td>
                                <td>{ allFunction.dateTimeFormat(val.created_at) }</td>  
                                <td className='text-center'>
                                 <Link type='button' href={ route('customer.documents.view', val.cus_document_id) } className="btn1">View</Link>
                                 <Link type='button' href={ route('customer.documents.edit', val.cus_document_id) } className="btn1">Edit</Link>
                                </td>
                              </tr>
                            )
                          })
                          :
                          <tr>
                              <td colspan="4">No record found</td>
                          </tr>
                        }
                      </tbody>
                    </table>
                </div>
                <div className="d-flex justify-content-end py-2">                         
                { parseWithLinks(''+paginate+'') }
                </div>
            </div>            
          </div>
      </div> 
    </section>  
    </>
  )
}
My_documents.layout = page => <Layout children={page} />
export default My_documents