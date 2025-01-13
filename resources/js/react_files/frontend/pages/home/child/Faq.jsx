import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Faq = ({ pageData }) => {  
    
    useEffect(()=> {      
        anime({
            targets: document.getElementById('anime-01-Faq'),
            "translateX": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('anime-02-Faq'),
            "translateX": [-50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
        anime({
            targets: document.getElementById('accordion-style-02'),
            "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad"
        })

       //===== accordion ====
       $('.accordion').each(function () {
            var _this = $(this),
                    activeIconClass = _this.attr('data-active-icon') || '',
                    inactiveIconClass = _this.attr('data-inactive-icon') || '';
            $('.collapse', this).on('show.bs.collapse', function () {
                var id = $(this).attr('id');
                $('a[data-bs-target="#' + id + '"]').closest('.accordion-header').parent('.accordion-item').addClass('active-accordion');
                $('a[data-bs-target="#' + id + '"] i').addClass(activeIconClass).removeClass(inactiveIconClass);
            }).on('hide.bs.collapse', function () {
                var id = $(this).attr('id');
                $('a[data-bs-target="#' + id + '"]').closest('.accordion-header').parent('.accordion-item').removeClass('active-accordion');
                $('a[data-bs-target="#' + id + '"] i').addClass(inactiveIconClass).removeClass(activeIconClass);
            });
        });
       //=====


    },[])   

  return (
    <>
    <section className="pt-0">
        <div className="container"> 
            <div className="row justify-content-center align-items-center mb-3">
                <div className="col-lg-7 col-md-8 sm-mb-15px" id="anime-01-Faq">
                    <h2 className="text-dark-gray fw-700 ls-minus-1px mb-0">Have a question?</h2>
                </div>
                <div className="col-lg-3 col-md-4 text-start text-md-end" id="anime-02-Faq">
                    <span className="text-dark-gray fs-30 align-middle fancy-text-style-4 ls-minus-1px">&#128075; Say <span className="fw-600" data-fancy-text='{ "effect": "rotate", "string": ["hello!", "hallå!", "salve!"] }'></span></span>
                </div>
            </div>
            <div className="row justify-content-center"> 
                <div className="col-lg-10"> 
                    <div className="accordion accordion-style-02" id="accordion-style-02" data-active-icon="icon-feather-chevron-up" data-inactive-icon="icon-feather-chevron-down">
                        
                        <div className="accordion-item active-accordion">
                            <div className="accordion-header border-bottom border-color-extra-medium-gray">
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-01" aria-expanded="true" data-bs-parent="#accordion-style-02">
                                    <div className="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                        <i className="feather icon-feather-chevron-up icon-extra-medium"></i><span className="fw-600 fs-18">How long is this site live?</span>
                                    </div>
                                </a>
                            </div>
                            <div id="accordion-style-02-01" className="accordion-collapse collapse show" data-bs-parent="#accordion-style-02">
                                <div className="accordion-body last-paragraph-no-margin border-bottom border-color-light-medium-gray">
                                    <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                </div>
                            </div>
                        </div>
                      
                        <div className="accordion-item">
                            <div className="accordion-header border-bottom border-color-extra-medium-gray">
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-02" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                    <div className="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                        <i className="feather icon-feather-chevron-down icon-extra-medium"></i><span className="fw-600 fs-18">Can i install/upload anything is want on there?</span>
                                    </div>
                                </a>
                            </div>
                            <div id="accordion-style-02-02" className="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                <div className="accordion-body last-paragraph-no-margin border-bottom border-color-light-medium-gray">
                                    <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div className="accordion-item">
                            <div className="accordion-header border-bottom border-color-light-medium-gray">
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-03" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                    <div className="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                        <i className="feather icon-feather-chevron-down icon-extra-medium"></i><span className="fw-600 fs-18">How can i migrate to another site?</span>
                                    </div>
                                </a>
                            </div>
                            <div id="accordion-style-02-03" className="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                <div className="accordion-body last-paragraph-no-margin border-bottom border-color-light-medium-gray">
                                    <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div className="accordion-item">
                            <div className="accordion-header border-bottom border-color-transparent">
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-04" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                    <div className="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                        <i className="feather icon-feather-chevron-down icon-extra-medium"></i><span className="fw-600 fs-18">Can i change the domain you give me?</span>
                                    </div>
                                </a>
                            </div>
                            <div id="accordion-style-02-04" className="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                <div className="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                    <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    </>
  )
}
export default Faq