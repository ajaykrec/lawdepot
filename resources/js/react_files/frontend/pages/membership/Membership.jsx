import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

const Membership = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props  

    useEffect(()=> {  
         
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
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head> 
    <Header_banner />
    <Breadcrumb />    

    <section className="py-5">
      <div className="container h-100">
        <div className="row text-center">
            <div className="col-12"> 
            {parseWithLinks(''+pageData.page.content+'')}
            </div> 
        </div>
      </div>
    </section>  

    <section className="py-0">
      <div className="container">            
          
      <div className="row align-items-center justify-content-center">
                            <div
                                className="col-lg-4 col-md-8 pricing-table-style-08 md-mb-30px" id="anime-02-Document_download">

                                <div
                                    className="pricing-table text-center pb-35px bg-white box-shadow-quadruple-large border-radius-6px">
                                    <div className="pricing-header ps-18 pe-18 md-ps-12 md-pe-12">
                                        <div
                                            className="d-inline-block fs-12 text-uppercase bg-white ps-20px pe-20px fw-600 text-dark-gray mb-30px border-radius-100px box-shadow-large border border-1 border-color-extra-medium-gray">Standard</div>
                                        <h2 className="text-dark-gray fw-600 mb-10px ls-minus-3px">
                                            <sup className="fs-30">$</sup>500</h2>
                                        <p className="mb-25px lh-28">All the basics for businesses that are just getting started.</p>
                                        <a
                                            href="#"
                                            className="btn btn-large btn-dark-gray btn-round-edge btn-switch-text btn-box-shadow">
                                            <span>
                                                <span className="btn-double-text" data-text="Choose package">Choose package</span>
                                            </span>
                                        </a>
                                        <span className="fs-13 w-100 d-block mt-5px">Monthly billing</span>
                                    </div>
                                    <div className="pricing-body pt-15px pb-25px">
                                        <ul className="list-style-01 ps-0 mb-0">
                                            <li className="border-color-transparent-dark-very-light pt-10px pb-10px">Unlimited bandwidth</li>
                                            <li className="border-color-transparent-dark-very-light pt-10px pb-10px">
                                                <span className="opacity-6">Full backup systems</span>
                                            </li>
                                            <li
                                                className="border-color-transparent-dark-very-light border-bottom pt-10px pb-10px">
                                                <span className="opacity-6">Unlimited database</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="pricing-footer">
                                        <a
                                            href="#"
                                            className="text-decoration-line-bottom d-inline-block text-dark-gray fw-500 ls-minus-05px">Get your 30 day free trial</a>
                                    </div>
                                </div>
                            </div>

                            <div
                                className="col-lg-4 col-md-8 pricing-table-style-08 md-mb-30px" id="anime-03-Document_download">

                                <div
                                    className="pricing-table text-center pb-35px bg-white box-shadow-quadruple-large border-radius-6px">
                                    <div className="pricing-header ps-18 pe-18 md-ps-12 md-pe-12">
                                        <div
                                            className="d-inline-block fs-12 text-uppercase bg-white ps-20px pe-20px fw-600 text-dark-gray mb-30px border-radius-100px box-shadow-large border border-1 border-color-extra-medium-gray">Business</div>
                                        <h2 className="text-dark-gray fw-600 mb-10px ls-minus-3px">
                                            <sup className="fs-30">$</sup>850</h2>
                                        <p className="mb-25px lh-28">All the basics for businesses that are just getting started.</p>
                                        <a
                                            href="#"
                                            className="btn btn-large btn-yellow btn-round-edge btn-switch-text btn-box-shadow">
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
                                            <li
                                                className="border-color-transparent-dark-very-light border-bottom pt-10px pb-10px">
                                                <span className="opacity-6">Unlimited database</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="pricing-footer">
                                        <a
                                            href="#"
                                            className="text-decoration-line-bottom d-inline-block text-dark-gray fw-500 ls-minus-05px">Get your 30 day free trial</a>
                                    </div>
                                </div>
                            </div>

                            <div
                                className="col-lg-4 col-md-8 pricing-table-style-08" id="anime-04-Document_download">
                                <div
                                    className="pricing-table text-center pb-35px bg-white box-shadow-quadruple-large border-radius-6px">
                                    <div className="pricing-header ps-18 pe-18 md-ps-12 md-pe-12">
                                        <div
                                            className="d-inline-block fs-12 text-uppercase bg-white ps-20px pe-20px fw-600 text-dark-gray mb-30px border-radius-100px box-shadow-large border border-1 border-color-extra-medium-gray">Ultimate</div>
                                        <h2 className="text-dark-gray fw-600 mb-10px ls-minus-3px">
                                            <sup className="fs-30">$</sup>950</h2>
                                        <p className="mb-25px lh-28">All the basics for businesses that are just getting started.</p>
                                        <a
                                            href="#"
                                            className="btn btn-large btn-dark-gray btn-round-edge btn-switch-text btn-box-shadow">
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
                                            <li
                                                className="border-color-transparent-dark-very-light border-bottom pt-10px pb-10px">Unlimited database</li>
                                        </ul>
                                    </div>
                                    <div className="pricing-footer">
                                        <a
                                            href="#"
                                            className="text-decoration-line-bottom d-inline-block text-dark-gray fw-500 ls-minus-05px">Get your 30 day free trial</a>
                                    </div>
                                </div>
                            </div>

            </div>

      </div>
    </section>  

    </>
  )
}
Membership.layout = page => <Layout children={page} />
export default Membership