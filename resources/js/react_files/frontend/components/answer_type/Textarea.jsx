import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==

//=====

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

const Textarea = ({propsData, addMoreIndex}) => { 

    const { file_storage_url, pageData } = usePage().props     

    const dispatch = useDispatch()
    const fields   = useSelector( (state)=> state.fields )
    const { data, setData, post, processing, errors } = useForm({
        //...fields,     
    })      
    
    useEffect(()=> {  
        setData(fields)
    },[fields])     

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
            <textarea className="form-control" placeholder={ propsData.placeholder } style={{height:"150px"}}
            name={field_name}  
            value={data[field_name] ?? ''}                         
            onChange={ (e) => {
                
                dispatch(fieldAction({
                    ...fields,
                    [field_name]:e.target.value
                }))
            }}
            /> 
        </div>
    </> 
    )
}
Textarea.layout = page => <Layout children={page} />
export default Textarea