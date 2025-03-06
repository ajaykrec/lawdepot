import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Category_banner = () => {

  const { file_storage_url, common_data, pageData } = usePage().props  
  const header_banner = pageData.header_banner ?? {}
  
    useEffect(()=> { 
        
        anime({
            targets: document.getElementById('anime-01-banner'),
            "translateY": [30, 0], "opacity": [0, 1], "easing": "easeOutCubic", "duration": 500, "staggervalue": 300          
        })

        anime({
            targets: document.getElementById('anime-02-banner'),
            "translateY": [30, 0], "opacity": [0, 1], "easing": "easeOutCubic", "duration": 500, "staggervalue": 300, "delay": 200
        })
         
    },[])  

    var banner_style = ''
    if(header_banner.banner_image){
        banner_style = {
            backgroundImage:`url(${file_storage_url}/uploads/document-category/${header_banner.banner_image})`
        }        
    }
    else{
        banner_style = {
            background:"#191E44"
        }    
    }
    
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
    {
        (header_banner.banner_image || header_banner.banner_text) &&       
        <section className="page-title-big-typography bg-dark-gray cover-background ipad-top-space-margin md-py-0" 
        style={banner_style}> 
            <div className="container">
                <div className="row align-items-center small-screen">
                    <div className="col-lg-5 col-sm-7 position-relative page-title-extra-small">
                        <h1 className="mb-15px text-white opacity-7 fw-300 overflow-hidden">
                        <span className="d-inline-block" id='anime-01-banner'>{parseWithLinks(''+header_banner.title+'')}</span>
                        </h1>
                        <h2 className="m-auto pb-5px pt-5px text-white fw-600 ls-minus-1px overflow-hidden">
                        <span className="d-inline-block" id='anime-02-banner'>
                        {parseWithLinks(''+header_banner.banner_text+'')} 
                        </span>
                        </h2>                                                       
                    </div>
                </div>
            </div>
        </section>       
    } 
    </>
  )
}
Category_banner.layout = page => <Layout children={page} />
export default Category_banner