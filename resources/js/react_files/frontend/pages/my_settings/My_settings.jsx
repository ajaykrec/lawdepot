import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect } from 'react';
import {Head, useForm, usePage, Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';

import validation from '../../helper/validation';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

const My_settings = ({ pageData }) => {

  const { file_storage_url, customer, common_data } = usePage().props

  const MySwal = withReactContent(Swal)

  const { data, setData, post, processing, errors } = useForm({
      name: customer.name ?? '',
      email: customer.email ?? '',
      phone: customer.phone ?? '',
      dob: customer.dob ?? '',
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
  
  const validate_name = (value)=>{	
      let err  = '';          
      let name = value ?? data.name
      if(!name){ 
        err  = 'Name is required';  
      } 
      setError({
        ...error,
        name:err
      });	  
      return err;	
  }
  const validate_email = (value)=>{	
      let err      = '';  
      let email    = value ?? data.email
      if(!email){        
        err  = 'Email is required';         
      }	  
      else if(!validation.validateEmail(email)){       
        err  = 'Email is not valid!';
      }		
      setError({
        ...error,
        email:err
      });	 
      return err;	
  }
  const validate_phone = (value)=>{	
    let err  = '';          
    let phone = value ?? data.phone
    if(!phone){ 
      err  = 'Phone is required';  
    } 
    setError({
      ...error,
      phone:err
    });	  
    return err;	
  }
  const validateForm = ()=>{		
    let error     = {};  
    let isValid   = true;   

    let name = validate_name()
    if( name !==''){
      error.name  = name;
      isValid = false;
    }
    
    let email = validate_email()
    if( email !==''){
      error.email  = email;
      isValid = false;
    }

    let phone = validate_phone()
    if( phone !==''){
      error.phone  = phone;
      isValid = false;
    }    

    setError(error);	
    return isValid;	
  }

  function submit(e) {
    e.preventDefault()
    if(validateForm()){	

        post(route('customer.settings.post'),{
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
                            <label className="form-label">Name</label>                          
                              <input type="text" className="form-control" 
                              name="name"
                              value={data.name} 
                              onChange={ (e) => {
                                setData('name', e.target.value)
                                validate_name(e.target.value)
                              }}
                              />
                              {error.name && 
                                <div className="error-msg">{error.name}</div>    
                              }  	
                          </div>
                    
                          <div className="my-3 mt-0">
                            <label className="form-label">Email</label>                          
                              <input type="text" className="form-control" 
                              name="email"
                              value={data.email} 
                              onChange={ (e) => {
                                setData('email', e.target.value)
                                validate_email(e.target.value)
                              }}
                              />
                              {error.email && 
                                <div className="error-msg">{error.email}</div>    
                              }  	
                          </div>
    
                          <div className="my-3 mt-0">
                            <label className="form-label">Phone</label>                          
                              <input type="text" className="form-control" 
                              name="phone"
                              value={data.phone} 
                              onChange={ (e) => {
                                setData('phone', e.target.value)
                                validate_phone(e.target.value)
                              }}
                              />
                              {error.phone && 
                                <div className="error-msg">{error.phone}</div>    
                              }  	
                          </div>
                    
                          <div className="my-3">
                            <label className="form-label">D.O.B</label>
                            <input type="date" className="form-control" 
                            name="dob"
                            value={data.dob} 
                            onChange={ (e) => {
                              setData('dob', e.target.value)
                            }}
                            style={{width:"200px"}}
                            />
                            {error.dob && 
                              <div className="error-msg">{error.dob}</div>    
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
My_settings.layout = page => <Layout children={page} />
export default My_settings