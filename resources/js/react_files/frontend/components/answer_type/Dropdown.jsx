import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==
import Add_more from './Add_more';
import Radio from './Radio';
import Radio_group from './Radio_group';
import Text from './Text';
import Textarea from './Textarea';
import Date from './Date';
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
                options.map((val,i)=>{     
                    let questions = val.questions                
                    let value = data[field_name] ?? ''
                    let style = {  
                        'display' : value == val.value   ? '' : 'none' 
                    }  
                    
                    
                    
                    return questions.map((val2,j)=>{  
                        const answer_type = val2.answer_type
                        const is_add_another = val2.is_add_another
                        return(                                         
                        
                            <div key={j} className={`my-3 oqall-${val.question_id}`} id={`oq-${val.option_id}`} style={style}>                        
                            {
                                is_add_another == 1 ?  
                                <Add_more propsData={val2} addMoreIndex={addMoreIndexCount} />                                             
                                :
                                answer_type == 'radio' ?  
                                <Radio  propsData={val2} addMoreIndex={addMoreIndexCount} />  
                                :   
                                answer_type == 'radio_group' ?  
                                <Radio_group  propsData={val2} index={j} />  
                                :  
                                answer_type == 'checkbox' ?  
                                <Checkbox  propsData={val2} />  
                                :   
                                answer_type == 'dropdown' ?  
                                <Dropdown  propsData={val2} addMoreIndex={addMoreIndexCount} />  
                                :                          
                                answer_type == 'text' ?  
                                <Text propsData={val2} addMoreIndex={addMoreIndexCount} />                                             
                                :
                                answer_type == 'textarea' ?  
                                <Textarea  propsData={val2} addMoreIndex={addMoreIndexCount} /> 
                                :  
                                answer_type == 'date' ?  
                                <Date  propsData={val2} />  
                                : 
                                ''                        
                            }  
                            </div>                    
                        )
                    }) 
                    
                })
            } 

            { 
                description && 
                <>
                <div className="card">
                    <div className="card-body" style={{lineHeight:"22px",background:"#eec"}}>
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