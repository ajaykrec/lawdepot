import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

const Are_you_ready = ({ pageData }) => {    

  return (
    <>
     <section className="overflow-hidden">
        <div className="container">
            <div className="row align-items-center justify-content-center border-radius-8px p-4 xs-p-7 text-center text-lg-start g-0 cover-background" 
            style={{backgroundImage:"url(frontend-assets/images/demo-hosting-home-03.jpg)"}}
            data-bottom-top="transform:scale(1.1, 1.1) translateY(30px);" data-top-bottom="transform:scale(1.0, 1.0) translateY(-30px);"> 
                <div className="col-lg-6 col-md-9 md-mb-10px icon-with-text-style-08">
                    <div className="feature-box feature-box-left-icon-middle overflow-hidden">
                        <div className="feature-box-icon feature-box-icon-rounded w-100px h-100px rounded-circle border border-2 border-color-transparent-white-light me-30px xs-me-25px">
                            <img src="frontend-assets/images/demo-hosting-home-icon.svg" className="w-50px h-50px" alt="" /> 
                        </div>
                        <div className="feature-box-content last-paragraph-no-margin">
                            <h5 className="d-inline-block fw-600 text-white mb-0">Are you ready for a better productive business?</h5> 
                        </div>
                    </div>
                </div>
                <div className="col-lg-6 text-center text-lg-end"> 
                    <div className="text-white d-inline-block last-paragraph-no-margin me-20px xs-m-10px">
                        <p className="opacity-8 d-inline-block">Starting at only &nbsp;</p> 
                        <span className="fw-600 d-inline-block text-decoration-line-bottom">$2.78 per month</span>
                    </div>
                    <a href="#" className="btn btn-medium btn-yellow btn-rounded fw-600 btn-switch-text btn-box-shadow">
                        <span>
                            <span className="btn-double-text" data-text="Sign up free">Sign up free</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    </>
  )
}
export default Are_you_ready