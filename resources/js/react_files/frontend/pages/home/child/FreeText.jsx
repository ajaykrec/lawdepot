import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import anime from 'animejs/lib/anime.es.js';

const FreeText = ({ pageData }) => {    

  useEffect(()=> {
  
          anime({
              targets: document.getElementById('anime-01-FreeText'),
              "opacity": [0, 1], "translateY": [0, 0], "easing": "easeOutQuad", "duration": 1000,"staggervalue": 300, "delay": 600
          })
  },[])   

  return (
    <>
    <section className="bg-very-light-gray pt-20px pb-20px sm-pt-40px" id='anime-01-FreeText'>
        <div className="container overlap-section">
            <div className="row justify-content-center overlap-section border-radius-6px overflow-hidden g-0 box-shadow-extra-large">
                <div className="col-lg-9 text-center fw-600 fs-24 lg-fs-22 ls-minus-05px text-dark-gray bg-white p-30px md-p-20px"><a href="demo-hosting-domain.html" className="fw-700 text-base-color text-decoration-line-bottom-medium">Get free domain</a> with managed WordPress dedicated hosting.</div>
                <div className="col-lg-3 text-center bg-yellow pt-30px pb-30px md-p-20px"><a href="demo-hosting-pricing.html" className="fw-700 text-dark-gray text-dark-gray-hover fs-24 lg-fs-20 ls-minus-05px">Just $5.99 month<i className="feather icon-feather-arrow-right ms-5px"></i></a></div>
            </div>
        </div>
    </section>
    </>
  )
}
export default FreeText