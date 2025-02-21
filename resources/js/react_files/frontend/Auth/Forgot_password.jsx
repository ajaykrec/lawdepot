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

const Forgot_password = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props  
  const settings = common_data.settings 

  const MySwal = withReactContent(Swal)

  const { data, setData, post, processing, errors } = useForm({
    email: '',    
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

      post(route('customer.forgot.password.post'),{
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
                                <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit" disabled={processing}>submit</button>
                              </div>

                              <div className="my-3" style={{display:"flex",justifyContent:"space-between"}}> 
                                  <Link href={route('customer.login')}>&larr; Back to login</Link>  
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
Forgot_password.layout = page => <Layout children={page} />
export default Forgot_password