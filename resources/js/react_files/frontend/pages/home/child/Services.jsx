import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import anime from 'animejs/lib/anime.es.js';

const Services = () => {    

    const { file_storage_url, common_data, pageData } = usePage().props
    const documents = pageData.documents

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
    <section className="cover-background pt-5 xs-pt-8" 
        style={{backgroundImage:"url(frontend-assets/images/demo-hosting-home-06.jpg)"}} 
        > 
        <div className="container">  
            <div className="row justify-content-center mb-3">
                <div className="col-lg-8 text-center" id="anime-01-Services">
                    <span className="text-base-color fw-600 mb-5px text-uppercase d-block">Our</span>
                    <h2 className="text-dark-gray fw-700 ls-minus-2px">Documents </h2>
                </div>
            </div>
            <div className="row row-cols-1 row-cols-lg-3 row-cols-sm-2 justify-content-center" id="anime-02-Services">

            {
                  documents.map( (val,i)=>{
                    return(
                    <div key={i} className="col icon-with-text-style-07 transition-inner-all mb-30px">
                        <div className="bg-white feature-box h-100 justify-content-start box-shadow-quadruple-large box-shadow-quadruple-large-hover text-start p-17 sm-p-14 border-radius-6px">
                            <div className="feature-box-icon mb-30px">                                 
                            {
                                val.image ?
                                <img src={`${file_storage_url}/uploads/document/${val.image}`} className="h-50px" alt="" />
                                :
                                <img src="/frontend-assets/images/no-photos.png" className="h-50px" alt="" />
                            }
                            </div>
                            <div className="feature-box-content">
                                <span className="d-inline-block fw-600 text-dark-gray fs-18 ls-minus-05px">{ val.name }</span>
                                <p className="mb-10px">{ parseWithLinks(''+val.short_description+'') }</p>
                                <Link href={ route('doc.index',val.slug) } className="btn btn-link btn-hover-animation-switch btn-extra-large text-base-color text-uppercase-inherit">
                                    <span>
                                        <span className="btn-text">Get Started</span>
                                        <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                        <span className="btn-icon"><i className="feather icon-feather-arrow-right"></i></span>
                                    </span> 
                                </Link>
                            </div>                        
                        </div>
                    </div>
                    )
                  })

            }
              
            </div>
        </div>
    </section>
    </>
  )
}
export default Services