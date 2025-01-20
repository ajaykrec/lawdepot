import React, { useState, useEffect } from 'react';
import Layout from './../../layouts/GuestLayout'
import { Head } from '@inertiajs/react'
import { useForm, usePage,  Link } from '@inertiajs/react'
import { Route } from 'react-router-dom'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

const Page_not_found = ({ pageData }) => {

  useEffect(()=> {
      anime({
        targets: document.getElementById('anime-01-Page_not_found'),
        "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
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
      <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
      </Head>      

      <section className="cover-background full-screen ipad-top-space-margin md-h-550px" 
      style={{backgroundImage:"url(frontend-assets/images/404-bg.jpg)"}}
      >
        <div className="container h-100">
            <div className="row align-items-center justify-content-center h-100">
                <div className="col-12 col-xl-6 col-lg-7 col-md-9 text-center" id="anime-01-Page_not_found">
                    <>
                    { parseWithLinks(''+pageData.page.content+'')}
                    </>
                    <Link href={ route('home') } className="btn btn-large left-icon btn-rounded btn-dark-gray btn-box-shadow text-transform-none">
                    <i className="fa-solid fa-arrow-left"></i>Back to homepage
                    </Link>
                </div>
            </div>
        </div>
    </section>
    </>
  )
}
//Page_not_found.layout = page => <Layout children={page} />
export default Page_not_found