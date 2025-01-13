import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import anime from 'animejs/lib/anime.es.js';

const Services = ({ pageData }) => {    

    useEffect(()=> {      
        anime({
            targets: document.getElementById('anime-01-Services'),
            "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 900, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-02-Services'),
             "el": "childs",  "translateY": [0, 0], "perspective": [1200, 1200], "scale": [1.05, 1], "rotateX": [50, 0], "opacity": [0,1], "duration":600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
    },[])   

  return (
    <>
    <section className="cover-background pt-5 xs-pt-8" 
        style={{backgroundImage:"url(frontend-assets/images/demo-hosting-home-06.jpg)"}} 
        > 
        <div className="container">  
            <div className="row justify-content-center mb-3">
                <div className="col-lg-8 text-center" id="anime-01-Services">
                    <span className="text-base-color fw-600 mb-5px text-uppercase d-block">Hosting solutions</span>
                    <h2 className="text-dark-gray fw-700 ls-minus-2px">Hosting services</h2>
                </div>
            </div>
            <div className="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center" id="anime-02-Services">
                
                <div className="col icon-with-text-style-07 transition-inner-all md-mb-30px">
                    <div className="bg-white feature-box h-100 justify-content-start box-shadow-quadruple-large box-shadow-quadruple-large-hover text-start p-17 sm-p-14 border-radius-6px">
                        <div className="feature-box-icon mb-30px"> 
                            <img src="frontend-assets/images/demo-hosting-home-icon-02.svg" className="h-50px" alt="" />
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block fw-600 text-dark-gray fs-18 ls-minus-05px">Online store</span>
                            <p className="mb-10px">Lorem dummy printing type setting industry.</p>
                            <a href="demo-hosting-hosting.html" className="btn btn-link btn-hover-animation-switch btn-extra-large text-base-color text-uppercase-inherit">
                                <span>
                                    <span className="btn-text">Learn more</span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                </span> 
                            </a>
                        </div>                        
                    </div>
                </div>
                
                <div className="col icon-with-text-style-07 transition-inner-all md-mb-30px">
                    <div className="bg-white feature-box h-100 justify-content-start box-shadow-quadruple-large box-shadow-quadruple-large-hover text-start p-17 sm-p-14 border-radius-6px">
                        <div className="feature-box-icon mb-30px"> 
                            <img src="frontend-assets/images/demo-hosting-home-icon-03.svg" className="h-50px" alt="" />
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block fw-600 text-dark-gray fs-18 ls-minus-05px">Web hosting</span>
                            <p className="mb-10px">Lorem dummy printing type setting industry.</p>
                            <a href="demo-hosting-hosting.html" className="btn btn-link btn-hover-animation-switch btn-extra-large text-base-color text-uppercase-inherit">
                                <span>
                                    <span className="btn-text">Learn more</span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                </span> 
                            </a>
                        </div>                        
                    </div>
                </div>
                
                <div className="col icon-with-text-style-07 transition-inner-all xs-mb-30px">
                    <div className="bg-white feature-box h-100 justify-content-start box-shadow-quadruple-large box-shadow-quadruple-large-hover text-start p-17 sm-p-14 border-radius-6px">
                        <div className="feature-box-icon mb-30px"> 
                            <img src="frontend-assets/images/demo-hosting-home-icon-04.svg" className="h-50px" alt="" />
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block fw-600 text-dark-gray fs-18 ls-minus-05px">Business email</span>
                            <p className="mb-10px">Lorem dummy printing type setting industry.</p>
                            <a href="demo-hosting-hosting.html" className="btn btn-link btn-hover-animation-switch btn-extra-large text-base-color text-uppercase-inherit">
                                <span>
                                    <span className="btn-text">Learn more</span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                </span> 
                            </a>
                        </div>                        
                    </div>
                </div>
                
                <div className="col icon-with-text-style-07 transition-inner-all">
                    <div className="bg-white feature-box h-100 justify-content-start box-shadow-quadruple-large box-shadow-quadruple-large-hover text-start p-17 sm-p-14 border-radius-6px">
                        <div className="feature-box-icon mb-30px">
                            <img src="frontend-assets/images/demo-hosting-home-icon-05.svg" className="h-50px" alt="" />
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block fw-600 text-dark-gray fs-18 ls-minus-05px">Cloud storage</span>
                            <p className="mb-10px">Lorem dummy printing type setting industry.</p>
                            <a href="demo-hosting-hosting.html" className="btn btn-link btn-hover-animation-switch btn-extra-large text-base-color text-uppercase-inherit">
                                <span>
                                    <span className="btn-text">Learn more</span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                    <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                </span> 
                            </a>
                        </div>                        
                    </div>
                </div>
              
            </div>
        </div>
    </section>
    </>
  )
}
export default Services