import React, { useState, useEffect } from 'react';
import Layout from '../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import allFunction from '../helper/allFunction';

import validation from '../helper/validation';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

import Header_banner from '../components/banner/Header_banner';
import Breadcrumb from '../components/breadcrumb/Breadcrumb';

const Reset_password = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props  
  const settings = common_data.settings 
  
  const MySwal = withReactContent(Swal)

  const { data, setData, post, processing, errors } = useForm({
    email:pageData.email,
    token:pageData.token,
    password: '',    
    confirm_password: '',    
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

  const validate_password = (value)=>{	
      let err      = '';  
      let password = value ?? data.password
      if(!password){        
        err  = 'Password is required';         
      }	
      else if(password && password.length < 6){        
        err  = 'Password should be minimum 6 characters';         
      }	
      setError({
        ...error,
        password:err
      });	 
      return err;	
  }
  const validate_password_confirmation = (value)=>{	
    let err      = '';  
    let confirm_password = value ?? data.confirm_password
    if(!confirm_password){        
      err  = 'Confirm Password is required';         
    }	
    else if(data.password != confirm_password){
      err  = 'Password mismatch';         
    }
    setError({
      ...error,
      confirm_password:err
    });	 
    return err;	
  }
  const validateForm = ()=>{		
    let error     = {};  
    let isValid   = true;   
    
    let password = validate_password()
    if( password !==''){
      error.password  = password;
      isValid = false;
    }  
    let confirm_password = validate_password_confirmation()
    if( confirm_password !==''){
      error.confirm_password  = confirm_password;
      isValid = false;
    }      
    setError(error);	
    return isValid;	
  }
  
  function submit(e) {
    e.preventDefault()
    if(validateForm()){	

      post(route('customer.reset.password.post'),{
        preserveScroll: true,
        onSuccess: () => {
          setData({
            ...data,
            password:'',
            confirm_password:''
          })
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
                  <div className="row justify-content-center">
                    <div className="col-lg-6 col-md-12">   
      
                          <div className="col-12 pb-5">
                          {parseWithLinks(''+pageData.page.content+'')} 
                          </div>                    
      
                          <div className="col-12">
                              <form onSubmit={submit}>
      
                                  <div className="my-3 mt-0">
                                      <label className="form-label">New Password</label>                          
                                      <input type="password" className="form-control" 
                                      name="password"
                                      value={data.password} 
                                      onChange={ (e) => {
                                        setData('password', e.target.value)
                                        validate_password(e.target.value)
                                      }}
                                      />
                                      {error.password && 
                                        <div className="error-msg">{error.password}</div>    
                                      }  	
                                  </div>    

                                  <div className="my-3 mt-0">
                                      <label className="form-label">Confirm Password</label>                          
                                      <input type="password" className="form-control" 
                                      name="confirm_password"
                                      value={data.confirm_password} 
                                      onChange={ (e) => {
                                        setData('confirm_password', e.target.value)
                                        validate_password_confirmation(e.target.value)
                                      }}
                                      />
                                      {error.confirm_password && 
                                        <div className="error-msg">{error.confirm_password}</div>    
                                      }  	
                                  </div>                                     
                              
                                  <div className="my-3">
                                    <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit" disabled={processing}>submit</button>
                                  </div>    
                                
                                </form>
                            </div>
                    </div>
                  </div>
                </div>
          </section>      
    </>
  )
}
Reset_password.layout = page => <Layout children={page} />
export default Reset_password