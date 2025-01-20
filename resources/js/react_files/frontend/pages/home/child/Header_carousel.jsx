import React, { useState, useEffect, useRef } from 'react';
import { Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import anime from 'animejs/lib/anime.es.js';

const Header_carousel = () => {  

    const { file_storage_url, customer, common_data, pageData } = usePage().props
    
    const banners = pageData.banners    

    useEffect(()=> {

        anime({
            targets: document.getElementById('anime-01'),
            "translateY": [100, 0], "easing": "easeOutCubic", "duration": 200            
        })

        anime({
            targets: document.getElementById('anime-02'),
            "translateY": [100, 0], "easing": "easeOutCubic", "duration": 900, "delay": 300
        })

        anime({
            targets: document.getElementById('anime-03'),
            "translateY": [100, 0], "easing": "easeOutCubic", "duration": 900, "delay": 500 
        })

        anime({
            targets: document.getElementById('anime-04'),
            "translateY": [100, 0], "easing": "easeOutCubic", "duration": 900, "delay": 700
        })

        anime({
            targets: document.getElementById('anime-05'),
            "opacity": [0, 1], "translateY": [100, 0], "easing": "easeOutQuad", "duration": 1200, "delay": 200 
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

  return (
    <>
    <section 
    className="cover-background full-screen bg-dark-gray ipad-top-space-margin position-relative section-dark md-h-auto"
    style={{backgroundImage:"url(/frontend-assets/images/demo-hosting-home-bg.jpg)",paddingTop:"0px"}}
    > 
        <div id="particles-style-01" className="h-100 position-absolute left-0px top-0 w-100" ></div>
        <div className="container h-100">
            <div className="row align-items-center justify-content-center h-100">
                <div className="col-xl-7 col-lg-8 col-md-10 text-white position-relative text-center text-lg-start">  
                    <>
                    { parseWithLinks(''+banners.banner_text+'') }
                    </>
                    <div className="overflow-hidden pt-5px">                        
                        {
                            banners.url &&
                            <>
                            <Link href={ banners.url } 
                                className="btn btn-extra-large btn-yellow btn-rounded btn-box-shadow btn-switch-text d-inline-block me-15px xs-m-10px align-middle fw-600" 
                                id='anime-03'>
                                <span>
                                    <span className="btn-double-text" data-text="Get started">Get started</span>
                                    <span><i className="feather icon-feather-arrow-right"></i></span>
                                </span>
                            </Link>
                            </>
                        }                        
                    </div>
                </div>
                <div className="col-xl-5 col-lg-4">
                    <div className="outside-box-right-7 position-relative" id='anime-05'> 
                        {
                            banners.banner_image &&
                            <img className="w-100" src={`${file_storage_url}/uploads/banners/${banners.banner_image}`} alt="" />
                        }

                        {
                            banners.floating_image &&
                            <img className="w-100 position-absolute left-minus-2px top-minus-5px animation-float" src={`${file_storage_url}/uploads/banners/${banners.floating_image}`} alt="" />
                        }                       
                    </div>
                </div>
            </div>             
        </div>
    </section>
    </>
  )
}
export default Header_carousel