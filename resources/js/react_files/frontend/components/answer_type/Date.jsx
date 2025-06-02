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

const Date = ({propsData, parentIndex, addMoreIndex}) => { 

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
        <div className="col-lg-6 col-md-12 col-12">
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
            <input type="date" className="form-control" pattern="\d{4}-\d{2}-\d{2}" autoComplete='off'
            name={field_name}  
            value={data[field_name] ?? ''}                         
            onChange={ (e) => {
                dispatch(fieldAction({
                    ...fields,
                    [field_name]:e.target.value
                }))
            }}
            /> 

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
Date.layout = page => <Layout children={page} />
export default Date