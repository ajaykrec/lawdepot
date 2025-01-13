import React, { useState, useEffect } from 'react';
import Layout from './../Layouts/GuestLayout'
import { Head, useForm, usePage, Link } from '@inertiajs/react'
import validation from '../Helper/validation';
import allFunction from './../Helper/allFunction';
const Login = ({ pageData }) => {

  const { data, setData, post, processing, errors } = useForm({
    email: pageData.email,
    password: pageData.password,
    remember: pageData.remember,
  })  

  const [error, setError] = useState(errors) 

  useEffect(() => {
    setError(errors)
  }, [errors]);

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
      post(route('login.post'))   
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
                    <Link href={route('login')} className="logo d-flex align-items-center w-auto">
                      <img src={pageData.logo} alt="" />                    
                    </Link>
                  </div>
                  </>                  
                }

                <div className="card mb-3">

                  <div className="card-body">

                    <div className="pt-4 pb-2">
                      <h5 className="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                      <p className="text-center small">Enter your Email & password to login</p>
                    </div>

                    <form className="row g-3 needs-validation" onSubmit={submit}>

                      <div className="col-12">
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

                      <div className="col-12">
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
                      
                      <div className="col-12" style={{display:"flex",justifyContent:"space-between"}}>
                        <div className="form-check">
                          <input className="form-check-input" type="checkbox" name="remember" 
                          checked={data.remember} onChange={e => setData('remember', e.target.checked)}
                          />
                          <label className="form-check-label" htmlFor="rememberMe">Remember me</label>
                        </div>
                        <div>                          
                          <Link href={route('forgot.password')}>Forgot password ?</Link>
                        </div>
                      </div>
                      <div className="col-12">
                        <button className="btn btn-primary w-100" type="submit" disabled={processing}>Login</button>
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
Login.layout = page => <Layout children={page} />
export default Login