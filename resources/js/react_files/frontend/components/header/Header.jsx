import React, { useState, useEffect } from 'react';
import { Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import allFunction from './../../helper/allFunction';
import $ from "jquery"

const Header = (props) => {   

    let ccp   	                = window.location.pathname;
	let ccp2     		        = ccp.split('/')
	let current_path            = (ccp2[1]) ? ccp2[1] : ''

    const home_menu     = ['']; 
    const about_menu    = ['about-us']; 
    const service_menu  = ['services']; 
    const blog_menu     = ['blog']; 
    const contact_menu  = ['contact']; 
    const pages_menu    = ['features','cars','teams','testimonial'];   

    const { file_storage_url, customer, common_data, pageData } = usePage().props

    const settings = common_data.settings
    const categories = common_data.categories  

    const country = common_data.country
    const countries = common_data.countries    
    
    const { data, setData, post, get,  processing, errors } = useForm({
        s: pageData.s ?? '',       
    })  
    
    useEffect(()=> {
		//spinner(0)
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

    var spinner = function () {
        setTimeout(function () {
            if($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };

    const openMenu =(id,option)=>{        
      if(option == true){
        $('#'+id).addClass('open');
      }
      else{
        $('#'+id).removeClass('open');
      }       
    }

    function submit(e) {
        e.preventDefault()
        get(route('search.post')) 
        $('.search-close').click()
    }

    return (
        <>
        <header className="header-with-topbar">
            <div className="header-top-bar top-bar-dark cover-background" style={{backgroundImage:"url('/frontend-assets/images/demo-hosting-header-bg.jpg')"}} >
                <div className="container-fluid">
                    <div className="row h-42px align-items-center m-0">
                        <div className="col-md-7 text-center text-md-start">
                            <div className="fs-13 text-white">
                                {parseWithLinks(''+settings.header_top_text+'')}             
                            </div>
                        </div>
                        <div className="col-5 text-end d-none d-md-flex">
                            { settings.contact_phone &&
                                <a href={`tel:${settings.contact_phone}`} className="widget fs-13 me-20px text-white opacity-8 d-none d-lg-inline-block">
                                <i className="feather icon-feather-phone"></i> {settings.contact_phone}
                                </a> 
                            }
                            
                            { settings.contact_email &&
                                <a href={`mailto:${settings.contact_email}`} className="widget fs-13 text-white text-white-hover opacity-8">
                                <i className="feather icon-feather-mail text-white position-relative top-1px"></i> {settings.contact_email}
                                </a>
                            }                            
                        </div>
                    </div>
                </div>
            </div>   
            <nav className="navbar navbar-expand-lg navBg header-reverse sticky-header" data-header-hover="light">
                <div className="container-fluid">
                    <div className="col-auto col-lg-2 me-lg-0 me-auto">
                        <Link className="navbar-brand" href={ route('home') }>

                        {/* <img src="/frontend-assets/images/demo-hosting-logo-white.png" data-at2x="/frontend-assets/images/demo-hosting-logo-white@2x.png" alt="" className="default-logo" /> */}

                        {/* <img src="/frontend-assets/images/demo-hosting-logo-black.png" data-at2x="/frontend-assets/images/demo-hosting-logo-black@2x.png" alt="" className="" /> */}
                        <img src="/frontend-assets/images/logo.png" alt="" className="logo" />

                        {/* <img src="/frontend-assets/images/demo-hosting-logo-black.png" data-at2x="/frontend-assets/images/demo-hosting-logo-black@2x.png" alt="" className="mobile-logo" />  */}

                        </Link>
                    </div>
                    <div className="col-auto col-lg-6 menu-order position-static">
                        <button className="navbar-toggler float-start" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">  
                            <span className="navbar-toggler-line"></span>
                            <span className="navbar-toggler-line"></span>
                            <span className="navbar-toggler-line"></span>
                            <span className="navbar-toggler-line"></span>
                        </button>
                        <div className="collapse navbar-collapse" id="navbarNav"> 
                            <ul className="navbar-nav"> 
                                {
                                    categories.map((val,i)=>{

                                        let document = val.document
                                        let liid = '001-'+i

                                        if(document && document.length > 0){
                                            return(
                                            <li key={i} className="nav-item dropdown dropdown-with-icon-style02" id={liid}
                                            onMouseEnter={()=>openMenu(liid,true)} 
                                            onMouseLeave={()=>openMenu(liid,false)}>
                                                <Link href={ route('category.index',val.slug) } className="nav-link">{val.name}</Link>
                                                <i className="fa-solid fa-angle-down dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                <ul className="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
                                                    {
                                                        document.map((val2,j)=>{
                                                            return(
                                                                <li key={j}>
                                                                    <Link href={ route('doc.index',val2.slug) }>{ val2.name }
                                                                    <i className="feather icon-feather-arrow-right"></i>
                                                                    </Link>
                                                                </li>   
                                                            )
                                                        })
                                                    }   

                                                    <li>
                                                    <Link href={ route('category.index', val.slug) }>Get More...                                                    
                                                    </Link>
                                                    </li>   

                                                                                            
                                                </ul>
                                            </li>
                                            )
                                        }
                                        else{
                                            return (
                                                <li key={i} className="nav-item"><Link href={ route('category.index',val.slug) } className="nav-link">{val.name}</Link></li>
                                            )
                                        }
                                    })
                                }
                            </ul>
                        </div>
                    </div>
                    <div className="col-auto col-lg-4 text-end">
                        <div className="header-icon">

                            <div className="header-account-icon icon alt-font mx-2 text-start">
                                
                                <a href="#" className="search-form-icon header-search-form">
                                <i className="align-middle feather icon-feather-search fs-18 me-5px xl-me-0"></i>
                                <br />
                                <span className="align-middle d-none d-xxl-inline-block">Search</span>
                                </a> 

                                <div className="search-form-wrapper">
                                    <button title="Close" type="button" className="search-close">×</button>
                                    
                                    <form id="search-form" className="search-form text-left" onSubmit={submit}>
                                        <div className="search-form-box">
                                            <h2 className="text-dark-gray fw-700 ls-minus-2px text-center mb-4 alt-font">What are you looking for?</h2>
                                            <input className="search-input px-2" placeholder="Enter your keywords..." autoComplete="off" 
                                            type="text" 
                                            name="s"
                                            value={data.s} 
                                            onChange={ (e) => {
                                              setData('s', e.target.value)                                              
                                            }}
                                            />
                                            {errors.s && 
                                              <div className="error-msg">{errors.s}</div>    
                                            }  
                                            <button type="submit" className="search-button">
                                            <i className="feather icon-feather-search" aria-hidden="true"></i> 
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div> 

                            { countries.length > 1 &&                   
                            
                                <div className="header-account-icon icon alt-font mx-2 text-start">
                                    <div className="header-account dropdown" id="country-menu-01" 
                                    onMouseEnter={()=>openMenu('country-menu-01',true)} 
                                    onMouseLeave={()=>openMenu('country-menu-01',false)}>                                     
                                        <a className="fw-500" style={{cursor:"pointer"}}>
                                        <span className="icon-country">
                                            <img src={`${file_storage_url}/uploads/country/${country.image}`} alt="" />
                                        </span>
                                        <br />
                                        <span className="d-none d-sm-inline-block">{ country.name }</span>
                                        </a>
                                        <ul className="account-item-list"> 
                                            {
                                                countries.map((val,i)=>{
                                                    return(
                                                        <li key={i} className="account-item">
                                                            <Link href={`${route('home')}?loc=${val.code}`}>
                                                                <span className="icon-country"> 
                                                                <img src={`${file_storage_url}/uploads/country/${val.image}`} alt="" data-no-retina="" />
                                                                </span> {val.name}
                                                            </Link>
                                                        </li>
                                                    )
                                                })
                                            }                                        
                                        </ul>
                                    </div> 
                                </div>
                            }

                            {
                                customer  ? 
                                <div className="header-account-icon icon alt-font text-start">
                                    <div className="header-account dropdown" id="account-menu-01" 
                                    onMouseEnter={()=>openMenu('account-menu-01',true)}                                 
                                    onMouseLeave={()=>openMenu('account-menu-01',false)}>                                     
                                        <a style={{cursor:"pointer"}} className="fw-500">                                        
                                            <span className="icon-country"><img src="/frontend-assets/images/user.png" alt="" style={{width:"20px"}} /></span>
                                            <br />
                                            <span className="d-none d-sm-inline-block">{ customer.email }</span>
                                        </a>
                                        <ul className="account-item-list">                                            
                                            <li className="account-item"><Link href={ route('customer.account') }>My Account</Link></li>      
                                            <li className="account-item"><Link href={ route('customer.documents') }>My Documents</Link></li>   
                                            <li className="account-item"><Link href={ route('membership.index') }>Upgrade Account</Link></li>  
                                            <li className="account-item"><Link href={ route('customer.logout') }>Logout</Link></li>
                                        </ul>
                                    </div> 
                                </div>
                                :
                                <div className="header-button ms-30px xxl-ms-10px xs-ms-0 text-start">
                                    <Link 
                                    href={ route('customer.login') } 
                                    className="fw-500"
                                    >                                   
                                    <span className="btn btn-white btn-small btn-rounded btn-box-shadow fw-600 d-sm-inline-block" style={{padding:"2px 5px"}}>
                                        <span className="btn-double-text">Sign In</span> 
                                    </span>
                                    </Link> 
                                </div>
                            }   

                        </div>                          
                    </div>
                </div>
            </nav>
   
        </header>
        </>
    )

}
export default Header