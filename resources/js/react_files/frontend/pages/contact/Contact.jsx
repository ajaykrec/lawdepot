import React, { useState, useEffect, useRef } from 'react';
import Layout from '../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

import validation from '../../helper/validation';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

const Contact = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props  
  const settings = common_data.settings      

  const { data, setData, post, delete: destroy,  processing, progress, errors } = useForm({
    name: '',    
    email:'',
    phone: '',    
    subject: '',    
    message: '',
    _method: 'POST'  
  })

    const [error, setError] = useState(errors)     
    const MySwal = withReactContent(Swal)

    useEffect(()=> {  
          anime({
              targets: document.getElementById('anime-01-page'),
              "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad"
          }) 
          anime({
            targets: document.getElementById('anime-02-page'),
            "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 500, "staggervalue": 300, "easing": "easeOutQuad"
        }) 
    },[])  

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
        let err     = '';  
        let name    = value ?? data.name
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
        let err = '';  
        let phone  = value ?? data.phone
        if(!phone){        
          err  = 'Phone number is required';         
        }	 
        setError({
          ...error,
          phone:err
        });	 
        return err;	
    }

    const validate_message = (value)=>{	
        let err = '';  
        let message  = value ?? data.message
        if(!message){        
          err  = 'Message is required';         
        }	 
        setError({
          ...error,
          message:err
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

        let message = validate_message()
        if( message !==''){
          error.message  = message;
          isValid = false;
        }

        setError(error);	
        return isValid;	
    }

    function submit(e) {
        e.preventDefault()
        if(validateForm()){	

          post(route('post.contact'), {
            forceFormData: true,
            onSuccess: (res) => {

                setData({
                    ...data,
                    name: '',    
                    email:'',
                    phone: '',   
                    subject: '',     
                    message: '',
                })
                
                let error_message = res.props.flash.error_message ?? ''
                let success_message = res.props.flash.success_message ?? ''
                if(success_message){
                    MySwal.fire({
                        animation: false,
                        title: "Good job!",
                        text: success_message,                        
                        confirmButtonText: 'Ok', 
                        confirmButtonColor: '#d33'
                    });
                }
               
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

    <section className="py-5">
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-12">
                    <div className="bg-very-light-gray px-5 border-radius-8px contact">
                        <div className="col-12 text-center mb-5" id="anime-01-page">
                        {parseWithLinks(''+pageData.page.content+'')}
                        </div>

                        <div className="row justify-content-center">
                            
                           { settings.contact_address &&
                                <div className="col-lg-4 col-md-12 col-12">                                    
                                    <div className="info-box mb-4"> 
                                        <i className="fa-sharp fa-solid fa-location-dot"></i>
                                        <h3>Our Address</h3>
                                        <p>{parseWithLinks(''+settings.contact_address+'')}</p>
                                    </div>
                                </div>
                            }
                            
                            { settings.contact_email &&
                                <div className="col-lg-4 col-md-12 col-12">                                    
                                    <div className="info-box mb-4">   
                                        <i className="fa-solid fa-envelope"></i>
                                        <h3>Email Us</h3>
                                        <p><a href={`mailto:${settings.contact_email}`}>{settings.contact_email}</a></p>
                                    </div>
                                </div>                                
                            }    

                            { settings.contact_phone &&

                                <div className="col-lg-4 col-md-12 col-12">                                    
                                <div className="info-box mb-4">    
                                    <i className="fa-solid fa-phone"></i>
                                    <h3>Call Us</h3>
                                    <p><a href={`tel:${settings.contact_phone}`}>{settings.contact_phone}</a></p>
                                </div>
                                </div>                                
                            }  
                            
                        </div>

                        <form onSubmit={submit} className="contact-form-style-05">                            
                            <div className="row justify-content-center" id="anime-02-page">

                                <div className="col-lg-6 col-md-6 col-12">
                                    <div className="my-3">
                                    <label className="form-label">Your name<span className="required">*</span></label>
                                    <input type="text" className="form-control" placeholder="" autoComplete='off'
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
                                </div>

                                <div className="col-lg-6 col-md-6 col-12">
                                    <div className="my-3">
                                    <label className="form-label">Your email address<span className="required">*</span></label>
                                    <input type="text" className="form-control" placeholder="" autoComplete='off'
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
                                </div>

                                <div className="col-lg-6 col-md-6 col-12">
                                    <div className="my-3">
                                    <label className="form-label">Your phone<span className="required">*</span></label>
                                    <input type="text" className="form-control" placeholder="" autoComplete='off'
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
                                </div>

                                <div className="col-lg-6 col-md-6 col-12">
                                    <div className="my-3">
                                    <label className="form-label">Subject</label>
                                    <input type="text" className="form-control" placeholder="" autoComplete='off'
                                    name="subject"
                                    value={data.subject} 
                                    onChange={ (e) => {
                                        setData('subject', e.target.value)                                        
                                    }}
                                    />
                                    {error.subject && 
                                        <div className="error-msg">{error.subject}</div>    
                                    }  	      
                                    </div>
                                </div>  
                               
                                <div className="col-12">
                                    <div className="my-3">
                                    <label className="form-label">Your message<span className="required">*</span></label>
                                        <textarea
                                        className="form-control" style={{height:"160px"}}
                                        name="message"
                                        value={data.message} 
                                        onChange={ (e) => {
                                        setData('message', e.target.value)
                                        validate_message(e.target.value)
                                        }}
                                        ></textarea>
                                        {error.message && 
                                            <div className="error-msg">{error.message}</div>    
                                        }  
                                    </div>
                                </div>


                                <div className="col-12 text-start  mt-30px sm-mt-20px">                                    
                                    <button className="btn btn-medium btn-dark-gray btn-box-shadow btn-rounded" type="submit" disabled={processing}>
                                    Send message
                                    </button>
                                </div>
                                
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
Contact.layout = page => <Layout children={page} />
export default Contact