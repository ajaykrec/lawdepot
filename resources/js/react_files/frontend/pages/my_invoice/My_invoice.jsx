import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';
import allFunction from '../../helper/allFunction';

import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

const My_invoice = () => {

  const { file_storage_url, customer, common_data, pageData } = usePage().props

  const [invoice_data, set_invoice_data] = useState({})    
  const MySwal = withReactContent(Swal)

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

  const results = pageData.results ?? []
  var start_count = 0

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
                              <th scope="col">Total</th>                               
                              <th scope="col">Invoice Number</th>
                              <th scope="col">Created</th>
                              <th scope="col">Renewal date</th>                              
                              <th scope="col" className='text-center'>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            {
                              results ?                        
                              results.map((val,i)=>{
                                start_count++

                                let created_date = (new Date(val.created * 1000)).toUTCString() 
                                let renewal_date = (new Date(val.lines.data[0].period.end * 1000)).toUTCString() 

                                console.log('created:'+val.created+'  end:'+val.lines.data[0].period.end)
                               
                                return(
                                  <tr key={i}>
                                    <th scope="row">{start_count}</th>                                     
                                    <td>{ allFunction.currency((val.total/100), val.currency) }</td>  
                                    <td>{ val.id }</td>   
                                    <td>{ allFunction.dateFormat(created_date)  }</td>                                                                       
                                    <td>{ allFunction.dateFormat(renewal_date)  }</td>        
                                    
                                    <td className='text-center'>
                                      { 
                                        val.status == 'paid' ?
                                        <span className="badge rounded-pill bg-success">Paid</span>                                        
                                        :
                                        val.status == 'draft' ?
                                        <span className="badge rounded-pill bg-secondary">Draft</span>
                                        :
                                        val.status == 'open' ?
                                        <span className="badge rounded-pill bg-warning">Open</span>
                                        :
                                        val.status == 'uncollectible' ?
                                        <span className="badge rounded-pill bg-danger">Uncollectible</span>
                                        :
                                        val.status == 'void' ?
                                        <span className="badge rounded-pill bg-danger">Void</span>
                                        :
                                        ''
                                      }                                      
                                    </td>                 
                                  </tr>
                                )
                              })
                              :
                              <tr>
                                  <td colspan="6">No record found</td>
                              </tr>
                            }
                          </tbody>
                        </table>
                    </div>                    
                </div>            
              </div>
          </div> 
        </section>          
    </>
  )
}
My_invoice.layout = page => <Layout children={page} />
export default My_invoice