import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Simple = ({ pageData }) => {    

    useEffect(()=> {      
        anime({
            targets: document.getElementById('anime-01-Simple'),
            "effect": "slide", "color": "#ffffff", "direction":"lr", "easing": "easeOutQuad", "delay":50
        })
        anime({
            targets: document.getElementById('anime-02-Simple'),
            "el": "childs", "opacity": [0, 1], "rotateY": [-90, 0], "rotateZ": [-10, 0], "translateY": [80, 0], "translateZ": [50, 0], "staggervalue": 200, "duration": 900, "delay": 300, "easing": "easeOutCirc"
        })
    },[])   

  return (
    <>
    <section className="overflow-hidden">
        <div className="container">
            <div className="row align-items-center justify-content-center mb-6 sm-mb-50px position-relative">
                <div className="col-lg-6 col-md-10 position-relative md-mb-30px" id="anime-01-Simple"> 
                    <img className="w-100" src="frontend-assets/images/demo-hosting-home-01.webp" data-bottom-top="transform: translateY(-50px)" data-top-bottom="transform: translateY(50px)" alt="" /> 
                </div>
                <div className="col-lg-5 offset-lg-1 last-paragraph-no-margin" id="anime-02-Simple">
                    <span className="text-base-color fw-600 mb-15px text-uppercase d-block">Simple and intuitive</span>
                    <h2 className="fw-600 text-dark-gray w-90 lg-w-100 text-dark-gray fw-700 ls-minus-2px">Solutions for your business.</h2>
                    <p className="w-90 sm-w-100">Getting your website live is as simple as a click of a button. Everything you need provided in a clear way.</p>
                    <ul className="p-0 mb-25px mt-15px list-style-01 w-90 lg-w-100">
                        <li className="border-color-extra-medium-gray fw-600 text-dark-gray d-flex align-items-center pt-15px pb-15px">
                            <div className="feature-box-icon feature-box-icon-rounded w-35px h-35px rounded-circle bg-solitude-blue me-10px text-center d-flex align-items-center justify-content-center flex-shrink-0"><i className="fa-solid fa-check fs-13 text-base-color"></i></div>
                            Get 30% discount qualifying purchases.
                        </li>
                        <li className="border-color-extra-medium-gray fw-600 text-dark-gray d-flex align-items-center pt-15px pb-15px">
                            <div className="feature-box-icon feature-box-icon-rounded w-35px h-35px rounded-circle bg-solitude-blue me-10px text-center d-flex align-items-center justify-content-center flex-shrink-0"><i className="fa-solid fa-check fs-13 text-base-color"></i></div>
                            Grow and connect with developers.
                        </li>
                    </ul>
                    <a href="demo-hosting-pricing.html" className="btn btn-large btn-dark-gray btn-box-shadow btn-rounded btn-switch-text">
                        <span>
                            <span className="btn-double-text" data-text="Lowest pricing">Premium pricing</span>
                            <span><i className="feather icon-feather-arrow-right"></i></span>
                        </span>
                    </a>
                </div> 
            </div>
            <div className="row align-items-center justify-content-center border border-color-extra-medium-gray border-radius-100px md-border-radius-6px p-50px lg-p-20px m-0 box-shadow-quadruple-large" data-bottom-top="transform:scale(1.1, 1.1) translateY(30px);" data-top-bottom="transform:scale(1, 1) translateY(-30px);">  
                
                <div className="col-lg-4 col-md-6 process-step-style-07 position-relative md-mb-30px">
                    <div className="process-step-item d-flex align-items-center">
                        <div className="process-step-icon-wrap position-relative">
                            <div className="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-60px w-60px bg-base-color fs-17 fw-500">
                                <span className="number position-relative z-index-1 text-white">01</span> 
                            </div>  
                        </div>
                        <div className="process-content ps-20px last-paragraph-no-margin">
                            <span className="d-block fw-600 text-dark-gray fs-17 ls-minus-05px alt-font">Choose a hosting plan</span>
                            <p>Lorem ipsum simply printing</p>
                        </div>
                    </div> 
                </div>
                
                <div className="col-lg-4 col-md-6 process-step-style-07 position-relative md-mb-30px">
                    <div className="process-step-item d-flex align-items-center">
                        <div className="process-step-icon-wrap position-relative">
                            <div className="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-60px w-60px bg-base-color fs-17 fw-500">
                                <span className="number position-relative z-index-1 text-white">02</span> 
                            </div>  
                        </div>
                        <div className="process-content ps-20px last-paragraph-no-margin">
                            <span className="d-block fw-600 text-dark-gray fs-17 ls-minus-05px alt-font">Select a domain name</span>
                            <p>Lorem ipsum simply printing</p>
                        </div>
                    </div> 
                </div>
                
                <div className="col-lg-4 col-md-6 process-step-style-07 position-relative">
                    <div className="process-step-item d-flex align-items-center">
                        <div className="process-step-icon-wrap position-relative">
                            <div className="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-60px w-60px bg-base-color fs-17 fw-500">
                                <span className="number position-relative z-index-1 text-white">03</span> 
                            </div>  
                        </div>
                        <div className="process-content ps-20px last-paragraph-no-margin">
                            <span className="d-block fw-600 text-dark-gray fs-17 ls-minus-05px alt-font">Upload your website</span>
                            <p>Lorem ipsum simply printing</p>
                        </div>
                    </div> 
                </div>
                
            </div>
        </div>
    </section>
    </>
  )
}
export default Simple