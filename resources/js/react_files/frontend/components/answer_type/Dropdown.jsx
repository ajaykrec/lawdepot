import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==

//=====

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

const Dropdown = ({propsData, addMoreIndex}) => { 

    const { file_storage_url, pageData } = usePage().props      

    const dispatch = useDispatch()
    const fields   = useSelector( (state)=> state.fields )
    const { data, setData, post, processing, errors } = useForm({
        //...fields,     
    })  

    useEffect(()=> {  
        setData(fields)
    },[fields])     

    const options = propsData.options    
    const label_text = propsData.label
    const question_text = propsData.question

    const addMoreIndexCount = (typeof addMoreIndex !== "undefined" && addMoreIndex !== '') ? addMoreIndex : ''
    const field_name = (addMoreIndexCount !=='') ? `${propsData.field_name}_${addMoreIndexCount}` : propsData.field_name

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
        </div>
        </> 
    )
}
Dropdown.layout = page => <Layout children={page} />
export default Dropdown