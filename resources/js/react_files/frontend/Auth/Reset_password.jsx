import React, { useState, useEffect } from 'react';
import Layout from './../Layouts/GuestLayout'
import { Head, useForm, usePage, Link } from '@inertiajs/react'
import validation from '../Helper/validation';
import allFunction from './../Helper/allFunction';

const Reset_password = ({ pageData }) => {

  const { data, setData, post, processing, errors } = useForm({
    email:pageData.email,
    token:pageData.token,
    password: '',    
    password_confirmation: '',    
  }) 

  const [error, setError] = useState(errors) 

  useEffect(() => {
    setError(errors)
  }, [errors]);

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
    let password_confirmation = value ?? data.password_confirmation
    if(!password_confirmation){        
      err  = 'Confirm Password is required';         
    }	
    else if(data.password != password_confirmation){
      err  = 'Password mismatch';         
    }
    setError({
      ...error,
      password_confirmation:err
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
    let password_confirmation = validate_password_confirmation()
    if( password_confirmation !==''){
      error.password_confirmation  = password_confirmation;
      isValid = false;
    }      
    setError(error);	
    return isValid;	
  }
  
  function submit(e) {
    e.preventDefault()
    if(validateForm()){	

      post(route('reset.password.post'),{
        preserveScroll: true,
        onSuccess: () => {
          setData({
            ...data,
            password:'',
            password_confirmation:''
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

      <section className="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div className="container">
            <div className="row justify-content-center">
              <div className="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">                
                {
                  pageData.logo &&
                  <>
                  <div className="d-flex justify-content-center py-4">
                    <Link href={route('forgot.password')} className="logo d-flex align-items-center w-auto">
                      <img src={pageData.logo} alt="" />                    
                    </Link>
                  </div>
                  </>                  
                }                

                <div className="card mb-3">
                  <div className="card-body">

                    <div className="pt-4 pb-2">
                      <h5 className="card-title text-center pb-0 fs-4">Reset password</h5>                      
                    </div>

                    <form className="row g-3 needs-validation" onSubmit={submit}>                                              

                      <div className="col-12">
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

                      <div className="col-12">
                        <label className="form-label">Confirm Password</label>                          
                          <input type="password" className="form-control" 
                          name="password_confirmation"
                          value={data.password_confirmation} 
                          onChange={ (e) => {
                            setData('password_confirmation', e.target.value)
                            validate_password_confirmation(e.target.value)
                          }}
                          />
                          {error.password_confirmation && 
                            <div className="error-msg">{error.password_confirmation}</div>    
                          }  	
                      </div>                         
                      
                      <div className="col-12">
                        <button className="btn btn-primary w-100" type="submit" disabled={processing}>Submit</button>
                      </div>
                     

                    </form>

                  </div>
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