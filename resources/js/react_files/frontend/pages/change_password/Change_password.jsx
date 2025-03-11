import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';

import validation from '../../helper/validation';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

const Change_password = ({ pageData }) => {

  const { file_storage_url, customer, common_data } = usePage().props
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

  const { data, setData, post, processing, errors } = useForm({
      password: '',
      new_password: '',
      renew_password: '',
  }) 
  
  const [error, setError] = useState(errors)   
  
  useEffect(() => {
    setError(errors)
  }, [errors]);

  const validate_password = (value)=>{	
    let err = '';  
    let password = value ?? data.password
    if(!password){        
      err = 'Current Password is required';         
    }	    
    setError({
      ...error,
      password:err
    });	 
    return err;	
  }

  const validate_new_password = (value)=>{	
    let err = '';  
    let new_password = value ?? data.new_password
    if(!new_password){        
      err = 'New Password is required';         
    }	
    else if(new_password && new_password.length < 6){        
      err = 'New Password should be minimum 6 characters';         
    }	
    setError({
      ...error,
      new_password:err
    });	 
    return err;	
  }

  const validate_renew_password = (value)=>{	
    let err = '';  
    let new_password = document.getElementById('new_password').value
    let renew_password = value ?? data.renew_password
    if(!renew_password){        
      err = 'Confirm Password is required';         
    }	
    else if( new_password!=renew_password){        
      err = 'Password mismatched';         
    }	
    setError({
      ...error,
      renew_password:err
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
    
    let new_password = validate_new_password()
    if( new_password !==''){
      error.new_password  = new_password;
      isValid = false;
    }

    let renew_password = validate_renew_password()
    if( renew_password !==''){
      error.renew_password  = renew_password;
      isValid = false;
    }    

    setError(error);	
    return isValid;	
  }

  function submit(e) {
    e.preventDefault()
    if(validateForm()){	

        post(route('customer.changepassword.post'),{
          preserveScroll: true,
          onSuccess: () => {
            setData({
              ...data,
              password: '',
              new_password: '',
              renew_password: '',
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
              <div className="row">           
                <div className="col-lg-3 col-md-12 col-12">   
                <MyAccountNavBar />          
                </div>
                <div className="col-lg-9 col-md-12 col-12">    
                { pageData.page.content ? <>{parseWithLinks(''+pageData.page.content+'')}</> : '' }  
                
                    <form onSubmit={submit}>
                
                          <div className="my-3 mt-0">
                            <label className="form-label">Current Password</label>                          
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
                            <label className="form-label">New Password</label>                          
                              <input type="password" className="form-control" 
                              id='new_password'
                              name="new_password"
                              value={data.new_password} 
                              onChange={ (e) => {
                                setData('new_password', e.target.value)
                                validate_new_password(e.target.value)
                              }}
                              />
                              {error.new_password && 
                                <div className="error-msg">{error.new_password}</div>    
                              }  	
                          </div>
    
                          <div className="my-3 mt-0">
                            <label className="form-label">Confirm Password</label>                          
                              <input type="password" className="form-control" 
                              name="renew_password"
                              value={data.renew_password} 
                              onChange={ (e) => {
                                setData('renew_password', e.target.value)
                                validate_renew_password(e.target.value)
                              }}
                              />
                              {error.renew_password && 
                                <div className="error-msg">{error.renew_password}</div>    
                              }  	
                          </div>
                          
                          <div className="my-3">
                            <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit" disabled={processing}>Update</button>
                          </div>
                    
                    </form> 
                </div>            
              </div>
          </div> 
        </section>         
    </>
  )
}
Change_password.layout = page => <Layout children={page} />
export default Change_password