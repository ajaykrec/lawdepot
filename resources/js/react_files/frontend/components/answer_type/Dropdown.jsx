import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==

//=====

//=== Tooltip ==
import OverlayTrigger from 'react-bootstrap/OverlayTrigger';
import Tooltip from 'react-bootstrap/Tooltip';

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

const Dropdown = ({propsData, parentIndex, addMoreIndex}) => { 

    const { file_storage_url, pageData } = usePage().props      

    const dispatch = useDispatch()
    const fields   = useSelector( (state)=> state.fields )
    const { data, setData, post, processing, errors } = useForm({
        //...fields,     
    })  

    useEffect(()=> {  
        setData(fields)
    },[fields])     

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

    const options = propsData.options    
    const label_text = propsData.label
    const question_text = propsData.question
    const quick_info = propsData.quick_info  
    const description = propsData.description              

    const parentIndexCount = (typeof parentIndex !== "undefined" && parentIndex !== '') ? parentIndex : ''
    const addMoreIndexCount = (typeof addMoreIndex !== "undefined" && addMoreIndex !== '') ? addMoreIndex : ''
    var field_name = (addMoreIndexCount !=='') ? `${propsData.field_name}_${addMoreIndexCount}` : propsData.field_name
    if(parentIndexCount){
        field_name = (addMoreIndexCount !=='') ? `${propsData.field_name}_${parentIndexCount}_${addMoreIndexCount}` : propsData.field_name
    }

    return (
        <>
        <div className="col-lg-10 col-md-12 col-12">
            {
                label_text &&
                <>  
                <div className="label_text">{ label_text }</div>
                </>
            } 
            <div className={`question ${ label_text ? '' : 'q-margin' }`}>
            { question_text }       
            { 
                quick_info &&
                <>
                &nbsp; 
                <OverlayTrigger
                    key="top"
                    placement="top"
                    overlay={
                    <Tooltip>
                    {parseWithLinks(''+quick_info+'')}
                    </Tooltip>
                    }
                >           
                <i className="fa-solid fa-circle-question"></i>
                </OverlayTrigger>
                </>
            }                                                                     
            </div>
            <select className="form-select" 
            name={field_name}  
            value={ data[field_name] ?? '' }                         
            onChange={ (e) => {
                dispatch(fieldAction({
                    ...fields,
                    [field_name]:e.target.value
                }))
            }}>    
            <option value=""></option>    
            { 
                options.map((val,i)=>{ 
                    return(
                        <option key={i} value={val.value}>{val.title}</option>
                    )
                })
            }                          
            </select>  

            { 
                options.map((val,i)=>{                    
                    let value = data[field_name] ?? ''
                    return(
                        <div key={i} className={` ${value == val.value ? 'd-flex justify-content-between border-0' : 'd-none' }`} >
                        {
                            val.image &&
                            <div className="p-2">
                            <img src={`${file_storage_url}/uploads/document_option/`+val.image} className="dropdown-img" />
                            </div>
                        } 
                        {
                            val.quick_info &&
                            <div className="p-2" style={{lineHeight:"22px"}}>
                            {parseWithLinks(''+val.quick_info+'')}
                            </div>
                        }                             
                        </div>
                    )
                })
            } 

            { 
                description && 
                <>
                <div className="card">
                    <div className="card-body" style={{lineHeight:"22px"}}>
                    {parseWithLinks(''+description+'')}
                    </div>
                </div>
                </> 
            } 
        </div>
        </> 
    )
}
Dropdown.layout = page => <Layout children={page} />
export default Dropdown