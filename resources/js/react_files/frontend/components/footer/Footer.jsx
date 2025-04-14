import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import Newsletter from './../newsletter/Newsletter'
import $ from "jquery"

const Footer = () => {


    let ccp   	        = window.location.pathname;
	let ccp2     		= ccp.split('/')
	let current_path    = (ccp2[1]) ? ccp2[1] : ''
       
    const about_menu    = ['about-us']; 
    const car_menu      = ['cars']; 
    const team_menu     = ['teams']; 
    const contact_menu  = ['contact']; 
    const terms_condition_menu  = ['terms-and-condition']; 

    const { file_storage_url, customer, common_data } = usePage().props
    const settings = common_data.settings      

    useEffect(()=> {
		initjQueryMethods()
	},[]) 

    var initjQueryMethods = function () {
          
    };
    
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

    return (
        <>
       <footer className="footer-dark bg-dark-blue pb-0 cover-background background-position-left-top pt-4" 
       style={{backgroundImage:"url('/frontend-assets/images/demo-hosting-footer-bg.jpg')"}} >
            <div className="container">
                <div className="row justify-content-center mb-5 md-mb-8 sm-mb-40px">

                    <div className="col-12 col-lg-6 last-paragraph-no-margin order-sm-1 md-mb-40px xs-mb-30px">
                        <Link href={ route('home') } className="footer-logo mb-15px d-inline-block">
                        <img src="/frontend-assets/images/logo.png" alt="" className="logo" />
                        </Link>
                        <p className="w-90 lg-w-100">{parseWithLinks(''+settings.footer_about_us_text+'')}</p>

                        <div className="elements-social social-icon-style-02 mt-20px xs-mt-15px">
                            <ul className="small-icon light">

                                {
                                    settings.facebook_url &&
                                    <li className="my-0">
                                        <a className="facebook" href={ settings.facebook_url } target="_blank">
                                            <i className="fa-brands fa-facebook-f"></i>
                                        </a>
                                    </li>
                                }

                                {
                                    settings.linkedIn_url &&
                                    <li className="my-0">
                                        <a className="linkedin" href={ settings.linkedIn_url } target="_blank">
                                            <i className="fa-brands fa-linkedin"></i>
                                        </a>
                                    </li>
                                }

                                {
                                    settings.twitter_url &&
                                    <li className="my-0">
                                        <a className="twitter" href={ settings.twitter_url } target="_blank">
                                            <i className="fa-brands fa-twitter"></i>
                                        </a>
                                    </li>
                                }

                                {
                                    settings.instagram_url &&
                                    <li className="my-0">
                                        <a className="instagram" href={ settings.instagram_url } target="_blank">
                                            <i className="fa-brands fa-instagram"></i>
                                        </a>
                                    </li>
                                }                                
                                
                            </ul>
                        </div>
                    </div>

                    <div className="col-6 col-lg-2 col-sm-4 xs-mb-30px order-sm-3 order-lg-2">
                        <span className="fs-17 fw-500 d-block text-white mb-5px">Company</span>
                        <ul>
                            <li>
                                <Link href={ route('home') }>Home</Link>
                            </li>
                            <li>
                                <Link href={ route('about') }>About</Link>
                            </li>
                            <li>
                                <Link href={ route('contact') }>Contact</Link>
                            </li>                            
                        </ul>
                    </div>

                    <div className="col-6 col-lg-2 col-sm-4 xs-mb-30px order-sm-4 order-lg-3">
                        <span className="fs-17 fw-500 d-block text-white mb-5px">Customer</span>
                        <ul>  
                            <li>
                                <Link href={ route('customer.account') }>My account</Link>
                            </li>   
                            <li>
                                <Link href={ route('terms') }>Terms of Use</Link>
                            </li>  
                            <li>
                                <Link href={ route('help') }>Help Center</Link>
                            </li>
                        </ul>
                    </div>

                    <div className="col-6 col-lg-2 col-sm-4 xs-mb-30px order-sm-5 order-lg-4">
                        <span className="fs-17 fw-500 d-block text-white mb-5px">Need support?</span>
                        { settings.contact_email &&
                                <>
                                {/* <i className="feather icon-feather-mail text-white"></i> :  */}
                                <a
                                href={`mailto:${settings.contact_email}`}
                                className="mb-20px">{settings.contact_email}</a>
                                
                                </>                               
                        }        
                        
                        { settings.contact_phone &&
                            <>
                            <br />
                            {/* <i className="feather icon-feather-phone text-white"></i> :  */}
                            <a href={`tel:${settings.contact_phone}`} className="lh-22 d-inline-flex">{settings.contact_phone}</a>
                            
                            </>                               
                        }  
                    </div>

                    
                </div>
                
            </div>
            <div className="container-fluid">
                <div className="row justify-content-center" style={{background:"#ccc"}}>   
                <div className="col-12">
                <div className="border-top py-3 text-center">
                    <span className=" lg-w-70 md-w-100 d-block mx-auto lh-22" style={{color:"#333"}}>
                    {parseWithLinks(''+settings.copyrights+'')}
                    </span>
                </div>
                </div>
                </div>
            </div>
        </footer>

        {
           ( current_path =='' || current_path == '/' ) &&
           <>
            <div
                className="sticky-wrap z-index-1 d-none d-xl-inline-block"
                data-animation-delay="100"
                data-shadow-animation="true">
                <div className="elements-social social-icon-style-10">
                    <ul className="fs-14">

                    {
                        settings.facebook_url &&
                        <li className="me-30px">
                            <a className="facebook" href={ settings.facebook_url } target="_blank">
                                <i className="fa-brands fa-facebook-f me-10px"></i>
                                <span className="alt-font">Facebook</span>
                            </a>
                        </li>
                    }

                    {
                        settings.linkedIn_url &&
                        <li className="me-30px">
                            <a className="linkedin" href={ settings.linkedIn_url } target="_blank">
                                <i className="fa-brands fa-linkedin me-10px"></i>
                                <span className="alt-font">LinkedIn</span>
                            </a>
                        </li>
                    }

                    {
                        settings.twitter_url &&
                        <li className="me-30px">
                            <a className="twitter" href={ settings.twitter_url } target="_blank">
                                <i className="fa-brands fa-twitter me-10px"></i>
                                <span className="alt-font">Twitter</span>
                            </a>
                        </li>
                    }

                    {
                        settings.instagram_url &&
                        <li>
                            <a className="instagram" href={ settings.instagram_url } target="_blank">
                                <i className="fa-brands fa-instagram me-10px"></i>
                                <span className="alt-font">Instagram</span>
                            </a>
                        </li>
                    } 

                    </ul>
                </div>
            </div>
           </>

        }        

        <div className="scroll-progress d-none d-xxl-block">
        <a href="#" className="scroll-top" aria-label="scroll">
            <span className="scroll-text">Scroll</span>
            <span className="scroll-line">
                <span className="scroll-point"></span>
            </span>
        </a>
        </div>  
        </>
    )

}
export default Footer