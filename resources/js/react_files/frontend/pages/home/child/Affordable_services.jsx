import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Affordable_services = ({ pageData }) => {  
    
    useEffect(()=> {      
        anime({
            targets: document.getElementById('anime-01-Affordable_services'),
            "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 900, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-02-Affordable_services'),
            "el": "childs", "translateY": [30, 0], "scale":[0.8,1], "opacity": [0,1], "duration": 500, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-03-Affordable_services'),
            "translateX": [-50, 0], "opacity": [0,1], "duration": 900, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-04-Affordable_services'),
            "translateX": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
    },[])   
    

  return (
    <>
    <section className="cover-background section-dark bg-midnight-dark-blue" 
    style={{backgroundImage:"url(frontend-assets/images/demo-hosting-home-02.png)"}}
    data-0-top="background-color:rgb(25,30,61);" data-center-bottom="background-color:rgb(14,16,29);">
        <div className="container"> 
            <div className="row justify-content-center mb-3">
                <div className="col-lg-8 text-center" id="anime-01-Affordable_services">
                    <span className="text-white opacity-5 mb-5px text-uppercase d-block">What we offers</span>
                    <h2 className="text-white fw-700 ls-minus-1px">What do you want to accomplish?</h2>
                </div>
            </div>
            <div className="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 justify-content-center ps-8 pe-8 lg-px-0" id="anime-02-Affordable_services">
              
                <div className="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-18 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-URL-Window icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">Domain name<br />generator</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
                <div className="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-18 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-Cloud-Email icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">SQL server<br />hosting</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
                <div className="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-18 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-Network-Window icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">Cheap web<br />hosting</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
                <div className="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-18 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-Envelope icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">Website email<br />hosting</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
                <div className="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-18 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-Wordpress icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">WordPress<br />installation</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
                <div className="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-18 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-Big-Data icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">Game server<br />hosting</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
                <div className="col icon-with-text-style-04 transition-inner-all xs-mb-30px">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-15 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-Data-Password icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">VPS server<br />hosting</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
                <div className="col icon-with-text-style-04 transition-inner-all">
                    <div className="feature-box hover-box h-100 transition light-hover border-radius-6px p-18 xs-p-12 last-paragraph-no-margin overflow-hidden border border-1 box-shadow-quadruple-large-hover border-color-transparent-white-light border-color-transparent-on-hover">
                        <div className="feature-box-icon">
                            <i className="line-icon-Globe icon-extra-large text-white mb-15px"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="d-inline-block text-white fw-500 lh-24">Free website<br />hosting</span> 
                        </div>
                        <div className="feature-box-overlay bg-white"></div>
                    </div>  
                </div>
                
            </div>

            {/* <div className="row justify-content-center mt-6">
                <div className="col-auto icon-with-text-style-08 sm-mb-10px" id="anime-03-Affordable_services">
                    <div className="feature-box feature-box-left-icon-middle">
                        <div className="feature-box-icon me-10px">
                            <i className="bi bi-envelope icon-small text-yellow"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="alt-font text-white fs-18">Looking for help? <a href="#" className="text-decoration-line-bottom text-white fw-500">Submit a ticket</a></span>
                        </div>
                    </div>
                </div>
                <div className="col-auto icon-with-text-style-08" id="anime-04-Affordable_services">
                    <div className="feature-box feature-box-left-icon-middle">
                        <div className="feature-box-icon me-10px">
                            <i className="bi bi-chat-dots icon-small text-yellow"></i>
                        </div>
                        <div className="feature-box-content">
                            <span className="alt-font text-white fs-18">Keep in Touch. <a href="#" className="text-decoration-line-bottom text-white fw-500">Like us on Facebook</a></span>
                        </div>
                    </div>
                </div>                
            </div> */}

        </div>
    </section>
    </>
  )
}
export default Affordable_services