import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Category_banner from '../../components/banner/Category_banner';
import Steps_header from './Steps_header';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import Document_faq from './Document_faq';

//=== answer_type == 
import Add_more from '../../components/answer_type/Add_more';
import Radio from '../../components/answer_type/Radio';
import Checkbox from '../../components/answer_type/Checkbox';
import Dropdown from '../../components/answer_type/Dropdown';
import Text from '../../components/answer_type/Text';
import Textarea from '../../components/answer_type/Textarea';
import Date from '../../components/answer_type/Date';
//=====
import $ from "jquery"

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

const Document = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props

  const document = pageData.document
  const steps = pageData.steps
  const step_id = pageData.step_id
  const group = pageData.group
  const percent = pageData.percent
  const questions = pageData.questions
  const fields = Object.assign({}, pageData.fields)   
  const previous_url = pageData.previous_url
  const next_url = pageData.next_url
  const faqs = pageData.faqs
  
  const formRef = useRef();
  const { data, setData, post, processing, errors } = useForm({
      ...fields,      
  })  

  const [error, setError] = useState(errors) 

  useEffect(() => {
    dispatch(fieldAction(data))    
  }, []);

  const dispatch     = useDispatch()
  const fieldState   = useSelector( (state)=> state.fields ) 

  useEffect(() => {
    setData(fieldState)
  }, [fieldState]);
  
   
  const handleChildInputChange = (arg) => {
    setData(arg);
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
  
  function submit(e) {
      e.preventDefault()
      let url = route('doc.post',document.slug)+'?group='+group+'&step_id='+step_id 
      
      let formData = new FormData() 
      formData.append('fields', JSON.stringify(data)); 
      router.post(url,formData)       
  }
 
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
          <div className="row"> 
          <div className={ faqs.length > 0 ? 'col-lg-8 col-md-12 col-12 pb-5' : 'col-lg-12 col-md-12 col-12 pb-5' }>          
            <form onSubmit={submit} id="documentForm" ref={formRef}> 
                    {
                        questions.map((val, i) => { 

                          const answer_type = val.answer_type
                          const display_type = val.display_type
                          const options = val.options
                          const is_add_another = val.is_add_another

                          return(
                            <div key={i} className="my-3"> 
                              { 
                                is_add_another == 1 ?  
                                <Add_more propsData={val} />                                             
                                :
                                answer_type == 'radio' ?  
                                <Radio propsData={val} />                                             
                                :
                                answer_type == 'checkbox' ?  
                                <Checkbox propsData={val} />                                             
                                :
                                answer_type == 'dropdown' ?  
                                <Dropdown propsData={val} />                                             
                                :
                                answer_type == 'text' ?  
                                <Text propsData={val} />                                             
                                :
                                answer_type == 'textarea' ?  
                                <Textarea propsData={val} />                                             
                                :                            
                                answer_type == 'date' ?  
                                <Date propsData={val} />                                             
                                :                            
                                ''                            
                              }                                                                      
                            </div>
                          )
                      })

                    }

                    {
                      questions && questions.length > 0 &&
                          <div className="mt-3">
                          {
                            previous_url &&
                            <Link href={previous_url} className="btn btn-medium btn-light btn-box-shadow btn-rounded mx-1 b-1" style={{border:"1px solid #ccc"}}>
                            <i className="fa fa-arrow-left-long"></i> Back
                            </Link>
                          }                   
                          <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded mx-1" type="submit" disabled={processing}>
                            Save and Continue
                          </button>
                          {
                            next_url &&
                            <Link href={next_url} className="text-secondary mx-2">Skip this step for now</Link>
                          }                    
                        </div>             
                    }                 
                
            </form>  
          </div>
          <div className={ faqs.length > 0 ? 'col-lg-4 col-md-12 col-12 pb-5' : 'col-lg-12 col-md-12 col-12 pb-5' } >          
          <Document_faq />
          </div>
          </div>
      </div>
    </section>  

    {/*
        document.description &&
        <section className="section">
          <div className="container">
            <div className="row">
              <div className="col-12 pb-5">
              { parseWithLinks(''+document.description+'') } 
              </div>
            </div>
          </div>
        </section>
    */} 
    
    </>
  )
}
Document.layout = page => <Layout children={page} />
export default Document