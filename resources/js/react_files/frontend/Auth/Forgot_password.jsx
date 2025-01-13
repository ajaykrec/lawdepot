import React, { useState, useEffect } from 'react';
import Layout from './../Layouts/GuestLayout'
import { Head, useForm, usePage, Link } from '@inertiajs/react'
import validation from '../Helper/validation';
import allFunction from './../Helper/allFunction';

const Forgot_password = ({ pageData }) => {

  const { data, setData, post, processing, errors } = useForm({
    email: '',    
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
  const validateForm = ()=>{		
    let error     = {};  
    let isValid   = true;   
    
    let email = validate_email()
    if( email !==''){
      error.email  = email;
      isValid = false;
    }    
    setError(error);	
    return isValid;	
  }
  
  function submit(e) {
    e.preventDefault()
    if(validateForm()){	

      post(route('forgot.password.post'),{
        preserveScroll: true,
        onSuccess: () => {
          setData('email', '')
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
                      <h5 className="card-title text-center pb-0 fs-4">Forgot password</h5>
                      <p className="text-center small">Enter your email for the verification proccess, we will send Password reset link to your email adress.</p>
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
                        <button className="btn btn-primary w-100" type="submit" disabled={processing}>Login</button>
                      </div>
                      <div className="col-12" style={{display:"flex",justifyContent:"space-between"}}>                        
                        <div>                          
                          <Link href={route('login')}>&larr; Back to login</Link> 
                          {/* &rarr; */}
                        </div>
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
Forgot_password.layout = page => <Layout children={page} />
export default Forgot_password