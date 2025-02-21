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

const Login = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props  
  const settings = common_data.settings 

  const MySwal = withReactContent(Swal)

  const { data, setData, post, processing, errors } = useForm({
    email: pageData.email,
    password: pageData.password,
    remember: pageData.remember,
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
  const validate_password = (value)=>{	
      let err      = '';          
      let password = value ?? data.password
      if(!password){ 
        err  = 'Password is required';  
      } 
      setError({
        ...error,
        password:err
      });	  
      return err;	
  }

  const validateForm = ()=>{		
    let error     = {};  
    let isValid   = true;   
    
    let email = validate_email()
    if( email !==''){
      error.email  = email;
      isValid = false;
    }

    let password = validate_password()
    if( password !==''){
      error.password  = password;
      isValid = false;
    }
    setError(error);	
    return isValid;	
  }
  
  function submit(e) {
    e.preventDefault()
    if(validateForm()){	
      post(route('customer.login.post'))   
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
              
              <div className="col-lg-5 col-md-12 col-12 text-center">
                <img src="/frontend-assets/images/login.png" alt="" className="w-65 border-radius-6px" data-no-retina="" />
              </div>

              <div className="col-lg-7 col-md-12 col-12">
                <form onSubmit={submit}>
                
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
                                      
                    <div className="my-3" style={{display:"flex",justifyContent:"space-between"}}>
                      <div className="form-check">
                        <input className="form-check-input" type="checkbox" name="remember" 
                        checked={data.remember} onChange={e => setData('remember', e.target.checked)}
                        />
                        <label className="form-check-label" htmlFor="rememberMe">&nbsp;Remember me</label>
                      </div>
                      <div>                          
                        <Link href={route('customer.forgot.password')}>Forgot password ?</Link>
                      </div>
                    </div>

                    <div className="my-3">
                      <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit" disabled={processing}>Login</button>
                    </div>

                    <p>
                    Don't have an account? <Link href={route('customer.register')}>Create a Free Account</Link>
                    </p>
                                    
                
                </form>   
              </div>
          </div>
        </div>
      </section>    
    </>
  )
}
Login.layout = page => <Layout children={page} />
export default Login