import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, router,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

import allFunction from '../../helper/allFunction';


const Membership = () => {

    const { file_storage_url, common_data, pageData } = usePage().props  
    const membership_data = pageData.membership
    const country = common_data.country

    const { data, setData, post, get, delete: destroy,  processing, progress, errors } = useForm({})

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

    const select_membership = (membership_id) =>{

        let obj = {
            membership_id:membership_id
        }  
        router.post(route('select.membership.post'),{
            ...obj,               
            onSuccess: (res) => {  
                console.log(res)
            }
        })
        
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

        <section className="py-0 mb-5">
            <div className="container">            
            
                <div className="row justify-content-center">
                {
                    membership_data.map((item,i)=>{

                        let specification = item.specification.description ?? []                       

                        return(
                        <div key={i} className="col-lg-4 col-md-8 pricing-table-style-08">
                            <div className="pricing-table text-center box-shadow-quadruple-large border-radius-6px">
                                <div className="pricing-header ps-18 pe-18 md-ps-12 md-pe-12">
                                    
                                    <div className="d-inline-block fs-12 text-uppercase bg-white ps-20px pe-20px fw-600 text-dark-gray mb-30px border-radius-100px box-shadow-large border border-1 border-color-extra-medium-gray">
                                    { item.name }
                                    </div>

                                    <h2 className="text-dark-gray fw-600 mb-10px ls-minus-3px">
                                    { 
                                        item.price <= 0 ?
                                        <>FREE</>
                                        :
                                        allFunction.currency(item.price,item.currency_code) 
                                    }                                    
                                    </h2>
                                    <p className="mb-25px lh-28">
                                    {parseWithLinks(''+item.description+'')}
                                    </p>
                                    <button 
                                    className="btn btn-large btn-dark-gray btn-round-edge btn-switch-text btn-box-shadow"
                                    onClick={()=>{
                                        select_membership(item.membership_id)
                                    }}
                                    style={{background:`${item.button_color}`,border:"none"}}
                                    >
                                        <span>
                                            <span className="btn-double-text" data-text="Choose package">Choose package</span>
                                        </span>
                                    </button>                                    
                                </div>
                                <div className="pricing-body pt-15px pb-25px">
                                    <ul className="list-style-01 ps-0 mb-0">
                                        {
                                            specification.map((v,j)=>{
                                                return(
                                                <li key={j} className="border-color-transparent-dark-very-light pt-10px pb-10px">
                                                {parseWithLinks(''+v+'')}
                                                </li>    
                                                )
                                            })
                                        }                                
                                    </ul>
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
Membership.layout = page => <Layout children={page} />
export default Membership