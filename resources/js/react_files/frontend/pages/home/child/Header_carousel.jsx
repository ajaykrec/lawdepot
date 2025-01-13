import React, { useState, useEffect, useRef } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import anime from 'animejs/lib/anime.es.js';

const Header_carousel = ({ pageData }) => {  

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

  return (
    <>
    <section 
    className="cover-background full-screen bg-dark-gray ipad-top-space-margin position-relative section-dark md-h-auto"
    style={{backgroundImage:"url(frontend-assets/images/demo-hosting-home-bg.jpg)"}}
    > 
        <div id="particles-style-01" className="h-100 position-absolute left-0px top-0 w-100" ></div>
        <div className="container h-100">
            <div className="row align-items-center justify-content-center h-100">
                <div className="col-xl-7 col-lg-8 col-md-10 text-white position-relative text-center text-lg-start">  
                    <div className="fs-90 sm-fs-80 xs-fs-70 fw-600 mb-20px ls-minus-4px overflow-hidden">
                        <div className="d-inline-block" id='anime-01'>
                        Legal Documents <div className="highlight-separator" data-shadow-animation="true" data-animation-delay="1500">
                        Generator<span> <img src="frontend-assets/images/highlight-separator.svg" alt="" /></span>
                            </div>
                        </div>
                    </div>
                    <div className="fs-19 fw-300 mb-30px w-80 sm-w-100 opacity-6 d-block mx-auto mx-lg-0 overflow-hidden">
                        <span className="d-inline-block lh-32" id='anime-02'>Print or download your customized legal document in
                        5-10 minutes.</span>
                    </div>
                    <div className="overflow-hidden pt-5px">
                        <a href="demo-hosting-hosting.html" className="btn btn-extra-large btn-yellow btn-rounded btn-box-shadow btn-switch-text d-inline-block me-15px xs-m-10px align-middle fw-600" id='anime-03'>
                            <span>
                                <span className="btn-double-text" data-text="Get started">Get started</span>
                                <span><i className="feather icon-feather-arrow-right"></i></span>
                            </span>
                        </a>
                        <div className="text-white fs-15 d-inline-block last-paragraph-no-margin align-middle" id='anime-04'>
                            <p className="opacity-6 ls-minus-05px d-inline-block">Starting at only &nbsp;</p> 
                            <span className="fw-500 d-inline-block"> $2.78/mo*</span>
                        </div>
                    </div>
                </div>
                <div className="col-xl-5 col-lg-4">
                    <div className="outside-box-right-7 position-relative" id='anime-05'> 
                        <img className="w-100" src="frontend-assets/images/demo-hosting-home-slider-01.webp" alt="" /> 
                        <img className="w-100 position-absolute left-minus-2px top-minus-5px animation-float" src="frontend-assets/images/demo-hosting-home-slider-02.webp" alt="" />
                    </div>
                </div>
            </div> 
        </div>
    </section>
    </>
  )
}
export default Header_carousel