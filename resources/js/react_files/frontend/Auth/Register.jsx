import React, { useState, useEffect } from 'react';
import Layout from '../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import allFunction from '../helper/allFunction';

import validation from '../helper/validation';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

import Header_banner from '../components/banner/Header_banner';
import Breadcrumb from '../components/breadcrumb/Breadcrumb';

const Register = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props  
  const settings = common_data.settings 

  const MySwal = withReactContent(Swal)

  const { data, setData, post, processing, errors } = useForm({
    name: '',
    email: '',
    phone: '',
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
const validate_confirm_password = (value)=>{	
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

    let password = validate_password()
    if( password !==''){
      error.password  = password;
      isValid = false;
    }

    let confirm_password = validate_confirm_password()
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

      post(route('customer.register.post'),{
        preserveScroll: true,
        onSuccess: () => {
          setData({
            ...data,
            name: '',
            email: '',
            phone: '',
            password: '',
            confirm_password: '',
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

                <div className="col-12 pb-5">
                {parseWithLinks(''+pageData.page.content+'')} 
                </div>
                
                <div className="col-lg-5 col-md-12 col-12 text-center contact">
                  <img src="/frontend-assets/images/register.png" alt="" className="w-65 img-fluid border-radius-6px" data-no-retina="" />
                  
                </div>

                <div className="col-lg-7 col-md-12 col-12">
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
                        <label className="form-label">Password</label>
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
                            validate_confirm_password(e.target.value)
                          }}
                          />
                          {error.confirm_password && 
                            <div className="error-msg">{error.confirm_password}</div>    
                          }  	
                      </div>   

                      <div className="my-3">
                        <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit" disabled={processing}>Create account</button>
                      </div>

                      <p>
                      Already have an account? <Link href={route('customer.login')}>Sign In</Link>
                      </p>
                                      
                
                </form>   
                </div>
            </div>
          </div>
        </section>    
    </>
  )
}
Register.layout = page => <Layout children={page} />
export default Register