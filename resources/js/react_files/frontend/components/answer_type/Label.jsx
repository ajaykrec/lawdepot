import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type == 
import Radio from './Radio';
import Checkbox from './Checkbox';
import Dropdown from './Dropdown';
import Text from './Text';
import Textarea from './Textarea';
import Date from './Date';
//=====

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

//=== Tooltip ==
import OverlayTrigger from 'react-bootstrap/OverlayTrigger';
import Tooltip from 'react-bootstrap/Tooltip';

const Label = ({propsData, parentIndex, addMoreIndex}) => { 

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

    const display_type = propsData.display_type
    const options = propsData.options
    const questions = options[0].questions ?? []    
    const label_text = propsData.label
    const question_text = propsData.question 
    const quick_info = propsData.quick_info  
    const description = propsData.description      

    const parentIndexCount = (typeof parentIndex !== "undefined" && parentIndex !== '') ? parentIndex : ''    
    const addMoreIndexCount = (typeof addMoreIndex !== "undefined" && addMoreIndex !== '') ? addMoreIndex : ''
    const field_name = (addMoreIndexCount !=='') ? `${propsData.field_name}_${addMoreIndexCount}` : propsData.field_name
    const radio_id_prefix = (addMoreIndexCount !=='') ? `o-${addMoreIndexCount}-` : 'o-'
    const option_id_prefix = (addMoreIndexCount !=='') ? `oq-${addMoreIndexCount}-` : 'oq-'
    const option_class_prefix = (addMoreIndexCount !=='') ? `oqall-${addMoreIndexCount}-` : 'oqall-'   
        
    return (
      <>          

        { 
            questions.map((val,i)=>{

              const answer_type = val.answer_type
              return(                                         
                
                  <div key={i} className={`my-3`}>                        
                    {
                      answer_type == 'radio' ?  
                      <Radio propsData={val} addMoreIndex={addMoreIndexCount}  />  
                      : 
                      answer_type == 'checkbox' ?  
                      <Checkbox propsData={val} addMoreIndex={addMoreIndexCount}  />  
                      :    
                      answer_type == 'dropdown' ?  
                      <Dropdown propsData={val} parentIndex={parentIndexCount} addMoreIndex={addMoreIndexCount} />  
                      :                  
                      answer_type == 'text' ?  
                      <Text propsData={val} parentIndex={parentIndexCount} addMoreIndex={addMoreIndexCount} />                                             
                      :
                      answer_type == 'textarea' ?  
                      <Textarea propsData={val} parentIndex={parentIndexCount} addMoreIndex={addMoreIndexCount} /> 
                      :  
                      answer_type == 'date' ?  
                      <Date propsData={val} parentIndex={parentIndexCount} addMoreIndex={addMoreIndexCount} />  
                      : 
                      ''                        
                    }  
                  </div>
                
                )
                                   
            })                                
        }                            
      </> 
    )
}
Label.layout = page => <Layout children={page} />
export default Label