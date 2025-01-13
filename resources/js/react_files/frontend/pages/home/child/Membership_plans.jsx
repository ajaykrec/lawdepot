import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Membership_plans = ({ pageData }) => {  
    
    useEffect(()=> {      
        anime({
            targets: document.getElementById('anime-01-Membership_plans'),
            "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-02-Membership_plans'),
            "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-03-Membership_plans'),
            "translateX": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-04-Membership_plans'),
            "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-05-Membership_plans'),
            "translateX": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad"
        })
    },[])   

  return (
    <>
    <section className="pb-0">
        <div className="container"> 
            <div className="row justify-content-center mb-3">
                <div className="col-lg-8 text-center" id="anime-01-Membership_plans">
                    <span className="text-base-color fw-600 mb-5px text-uppercase d-block">Pricing plans</span>
                    <h2 className="fw-600 text-dark-gray text-dark-gray fw-700 ls-minus-2px">Hosting plans</h2>
                </div>
            </div>
            <div className="row align-items-center justify-content-center mb-6 md-mb-8">
              
                <div className="col-lg-4 col-md-8 pricing-table-style-08 md-mb-30px" id="anime-02-Membership_plans">
                    
                    <div className="pricing-table text-center pt-16 pb-35px bg-white box-shadow-quadruple-large border-radius-6px">
                        <div className="pricing-header ps-18 pe-18 md-ps-12 md-pe-12">
                            <div className="d-inline-block fs-12 text-uppercase bg-white ps-20px pe-20px fw-600 text-dark-gray mb-30px border-radius-100px box-shadow-large border border-1 border-color-extra-medium-gray">Standard</div>
                            <h2 className="text-dark-gray fw-600 mb-10px ls-minus-3px"><sup className="fs-30">$</sup>250</h2>
                            <p className="mb-25px lh-28">All the basics for businesses that are just getting started.</p>
                            <a href="demo-hosting-pricing.html" className="btn btn-large btn-dark-gray btn-round-edge btn-switch-text btn-box-shadow">
                                <span>
                                    <span className="btn-double-text" data-text="Choose package">Choose package</span>
                                </span>
                            </a>
                            <span className="fs-13 w-100 d-block mt-5px">Monthly billing</span>
                        </div>
                        <div className="pricing-body pt-15px pb-25px">
                            <ul className="list-style-01 ps-0 mb-0">
                                <li className="border-color-transparent-dark-very-light pt-10px pb-10px">Unlimited bandwidth</li>
                                <li className="border-color-transparent-dark-very-light pt-10px pb-10px"><span className="opacity-6">Full backup systems</span></li>
                                <li className="border-color-transparent-dark-very-light border-bottom pt-10px pb-10px"><span className="opacity-6">Unlimited database</span></li> 
                            </ul>
                        </div>
                        <div className="pricing-footer">
                            <a href="demo-hosting-pricing.html" className="text-decoration-line-bottom d-inline-block text-dark-gray fw-500 ls-minus-05px">Get your 30 day free trial</a>
                        </div>
                    </div>
                </div>
                
                <div className="col-lg-4 col-md-8 pricing-table-style-08 md-mb-30px" id="anime-03-Membership_plans" >
                  
                    <div className="pricing-table text-center pt-16 pb-35px bg-white box-shadow-quadruple-large border-radius-6px">
                        <div className="pricing-header ps-18 pe-18 md-ps-12 md-pe-12">
                            <div className="d-inline-block fs-12 text-uppercase bg-white ps-20px pe-20px fw-600 text-dark-gray mb-30px border-radius-100px box-shadow-large border border-1 border-color-extra-medium-gray">Business</div>
                            <h2 className="text-dark-gray fw-600 mb-10px ls-minus-3px"><sup className="fs-30">$</sup>350</h2>
                            <p className="mb-25px lh-28">All the basics for businesses that are just getting started.</p>
                            <a href="demo-hosting-pricing.html" className="btn btn-large btn-yellow btn-round-edge btn-switch-text btn-box-shadow">
                                <span>
                                    <span className="btn-double-text" data-text="Choose package">Choose package</span>
                                </span>
                            </a>
                            <span className="fs-13 w-100 d-block mt-5px">Monthly billing</span>
                        </div>
                        <div className="pricing-body pt-15px pb-25px">
                            <ul className="list-style-01 ps-0 mb-0">
                                <li className="border-color-transparent-dark-very-light pt-10px pb-10px">Unlimited bandwidth</li>
                                <li className="border-color-transparent-dark-very-light pt-10px pb-10px">Full backup systems</li>
                                <li className="border-color-transparent-dark-very-light border-bottom pt-10px pb-10px"><span className="opacity-6">Unlimited database</span></li> 
                            </ul>
                        </div>
                        <div className="pricing-footer">
                            <a href="demo-hosting-pricing.html" className="text-decoration-line-bottom d-inline-block text-dark-gray fw-500 ls-minus-05px">Get your 30 day free trial</a>
                        </div>
                    </div>
                </div>
                
                <div className="col-lg-4 col-md-8 pricing-table-style-08" id="anime-04-Membership_plans">
                  
                    <div className="pricing-table text-center pt-16 pb-35px bg-white box-shadow-quadruple-large border-radius-6px">
                        <div className="pricing-header ps-18 pe-18 md-ps-12 md-pe-12">
                            <div className="d-inline-block fs-12 text-uppercase bg-white ps-20px pe-20px fw-600 text-dark-gray mb-30px border-radius-100px box-shadow-large border border-1 border-color-extra-medium-gray">Ultimate</div>
                            <h2 className="text-dark-gray fw-600 mb-10px ls-minus-3px"><sup className="fs-30">$</sup>450</h2>
                            <p className="mb-25px lh-28">All the basics for businesses that are just getting started.</p>
                            <a href="demo-hosting-pricing.html" className="btn btn-large btn-dark-gray btn-round-edge btn-switch-text btn-box-shadow">
                                <span>
                                    <span className="btn-double-text" data-text="Choose package">Choose package</span>
                                </span>
                            </a>
                            <span className="fs-13 w-100 d-block mt-5px">Monthly billing</span>
                        </div>
                        <div className="pricing-body pt-15px pb-25px">
                            <ul className="list-style-01 ps-0 mb-0">
                                <li className="border-color-transparent-dark-very-light pt-10px pb-10px">Unlimited bandwidth</li>
                                <li className="border-color-transparent-dark-very-light pt-10px pb-10px">Full backup systems</li>
                                <li className="border-color-transparent-dark-very-light border-bottom pt-10px pb-10px">Unlimited database</li> 
                            </ul>
                        </div>
                        <div className="pricing-footer">
                            <a href="demo-hosting-pricing.html" className="text-decoration-line-bottom d-inline-block text-dark-gray fw-500 ls-minus-05px">Get your 30 day free trial</a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div className="row" id="anime-05-Membership_plans">
                <div className="col-12 text-center">
                    <div className="bg-dark-gray fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12 me-10px xs-m-5px d-inline-block align-middle">Limited offer</div>
                    <div className="text-dark-gray fw-500 d-inline-block align-middle ls-minus-05px fs-18">Save 20% on annual plans. <a href="demo-hosting-pricing.html" className="text-decoration-line-bottom text-dark-gray d-inline-block">Explore pricing plans<span className="bg-dark-gray"></span></a></div>
                </div>
            </div>
        </div>
    </section>
    </>
  )
}
export default Membership_plans