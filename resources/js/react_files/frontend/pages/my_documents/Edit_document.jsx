import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect, useRef } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import allFunction from '../../helper/allFunction';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';
import $ from "jquery"

import validation from '../../helper/validation';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

//==== tinymce
import { Editor } from '@tinymce/tinymce-react';
//===

const Edit_document = () => {

  const { file_storage_url, customer, common_data, pageData } = usePage().props
  const document = pageData.document ?? []  
  const cus_document_id = document.cus_document_id ?? ''

  const MySwal = withReactContent(Swal)

  const { data, setData, post, processing, errors } = useForm({
    file_name: document.file_name ?? '',
    openai_document: document.openai_document ?? '',   
  })  

  const [error, setError] = useState(errors)   
  const editorRef = useRef(null);
  
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

  const validate_file_name = (value)=>{	
      let err  = '';          
      let file_name = value ?? data.file_name
      if(!file_name){ 
        err  = 'File Name is required';  
      } 
      setError({
        ...error,
        file_name:err
      });	  
      return err;	
  }

  const validate_openai_document = (value)=>{	
      let err  = '';          
      let openai_document = value ?? data.openai_document
      if(!openai_document){ 
        err  = 'Document is required';  
      } 
      setError({
        ...error,
        openai_document:err
      });	  
      return err;	
  }

  const validateForm = ()=>{		
    let error     = {};  
    let isValid   = true;   

    let file_name = validate_file_name()
    if( file_name !==''){
      error.file_name  = file_name;
      isValid = false;
    }
    
    let openai_document = validate_openai_document()
    if( openai_document !==''){
      error.openai_document  = openai_document;
      isValid = false;
    }

    setError(error);	
    return isValid;	
  }

  function submit(e) {
    e.preventDefault()
    if(validateForm()){	

        post(route('customer.documents.update',cus_document_id),{
          preserveScroll: true,
          onSuccess: () => {
          //===
          }
        })   

    }
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
                
                    <form onSubmit={submit}>
                
                          <div className="my-3 mt-0">
                            <label className="form-label">File Name</label>                          
                              <input type="text" className="form-control" 
                              name="file_name"
                              value={data.file_name} 
                              onChange={ (e) => {
                                setData('file_name', e.target.value)
                                validate_file_name(e.target.value)
                              }}
                              />
                              {error.file_name && 
                                <div className="error-msg">{error.file_name}</div>    
                              }  	
                          </div>                    
                          
    
                          <div className="my-3 mt-0">
                            <label className="form-label">Document</label> 
                              <Editor
                                tinymceScriptSrc={'/frontend-assets/tinymce/tinymce.min.js'}
                                onInit={(evt, editor) => editorRef.current = editor}                               
                                value={data.openai_document}
                                init={{
                                  height: 500,
                                  menubar: false,
                                  branding: false,
                                  statusbar: false,
                                  verify_html: false,
                                  toolbar_sticky: true,                                  
                                  plugins: 'code',
                                  toolbar: 'code | undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                                }}
                                onEditorChange={ (newValue, editor) => {                                 
                                  setData('openai_document', newValue)
                                  validate_openai_document(newValue)
                                }}
                              />
                              {error.openai_document && 
                                <div className="error-msg">{error.openai_document}</div>    
                              }  	
                          </div>   
                          
                          <div className="my-3">
                            <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit" disabled={processing}>Save</button>
                          </div>
                    
                    </form> 
                </div>            
          </div>
      </div> 
    </section>  
    </>
  )
}
Edit_document.layout = page => <Layout children={page} />
export default Edit_document