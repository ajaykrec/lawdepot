import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Category_banner from '../../components/banner/Category_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

const Document = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props

  const document = pageData.document
  const steps = pageData.steps
  const step_id = pageData.step_id
  const percent = pageData.percent

  const { data, setData, post, processing, errors } = useForm({
      email: '',
      password: '',
      remember: '',
  })  
  
  const [error, setError] = useState(errors) 

  useEffect(() => {
    setError(errors)
  }, [errors]);
  

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
  
  function submit(e) {
    e.preventDefault()
    //post(route('customer.login.post'))       
  }
 
  return (
    <>
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head>    
    
    <section className="ipad-top-space-margin py-5" style={{background:"#152bca"}}> 
        <div className="container">
            <div className="row text-center">
                
                <div className="col-12 page-title-extra-small">                    
                    <h2 className="text-white fw-600 ls-minus-1px">                    
                    { document.name }                   
                    </h2>                                                       
                </div>
                <div className="col-12 mb-2"> 
                  
                  <div className="steps">
                    {
                        steps.map((val,i)=>{
                          return(
                            <Link key={i} href={ route('doc.index',document.slug)+'?step_id='+val.step_id+'&group=1' } className={ (val.step_id == step_id) ? 'btn btn-very-small bg-info bg-light' : 'btn btn-very-small bg-info' }>{val.name}<i className="fa-solid fa-arrow-right"></i></Link>
                          )                          
                        })

                    }                    
                    <Link href={ route('doc.download',document.slug) } className="btn btn-very-small bg-info">Print/Download</Link>                    
                  </div>                  
                  
                  <div className="progress-bar-style-03 m-1" style={{width:"70%"}}>                               
                    <div className="progress bg-info text-dark-gray ">
                        {/* <div className="fs-18 fw-600 progress-bar-title d-inline-block text-white">Progress</div> */}
                        <div className="progress-bar bg-light m-0 border-radius-3px" 
                        role="progressbar" 
                        aria-valuenow={percent} 
                        aria-valuemin="0" 
                        aria-valuemax="100" 
                        aria-label="consulting" 
                        style={{width:percent+"%"}}>
                        </div>
                        {/* <span className="progress-bar-percent fs-16 fw-600 text-white">83%</span> */}
                    </div>                                
                  </div>                        

                </div>                
            </div>
        </div>
    </section> 
    {/* <Breadcrumb />    */}

    <section className="py-5">
      <div className="container h-100">  
          <div className="row"> 
          <div className="col-12 pb-5">
          <form onSubmit={submit}>
                          
                  <div className="my-3 mt-0">
                    <label className="form-label">Email</label>   

                    <input type="radio" className="btn-check" name="options" id="option1" autocomplete="off" />
                    <label className="btn btn-secondary" for="option1">Checked</label>

                      
                  </div>
                  

                  <div className="my-3">
                    {/* <Link href='#' className="btn btn-medium btn-light btn-box-shadow btn-rounded mx-1 b-1" style={{border:"1px solid #ccc"}}>
                    <i className="fa fa-arrow-left-long"></i> Back
                    </Link> */}
                    <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded mx-1" type="submit" disabled={processing}>Save and Continue</button>
                    <Link href='#' className="text-secondary mx-2">Skip this step for now</Link>
                  </div>                                  
              
              </form>  
          </div>
          </div>
      </div>
    </section>  

    {
        document.description &&
        <section className="section">
          <div className="container">
            <div className="row">
              <div className="col-12 pb-5">
              {/* {parseWithLinks(''+document.description+'')}  */}
              </div>
            </div>
          </div>
        </section>
    } 
    
    </>
  )
}
Document.layout = page => <Layout children={page} />
export default Document