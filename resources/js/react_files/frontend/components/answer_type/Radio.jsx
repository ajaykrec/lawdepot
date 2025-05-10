import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==
import Label from './Label';
import Add_more from './Add_more';
import Radio_group from './Radio_group';
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

const Radio = ({propsData, addMoreIndex}) => { 

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
    const label_text = propsData.label
    const question_text = propsData.question 
    const quick_info = propsData.quick_info  
    const description = propsData.description      

    const addMoreIndexCount = (typeof addMoreIndex !== "undefined" && addMoreIndex !== '') ? addMoreIndex : ''
    const field_name = (addMoreIndexCount !=='') ? `${propsData.field_name}_${addMoreIndexCount}` : propsData.field_name
    const radio_id_prefix = (addMoreIndexCount !=='') ? `o-${addMoreIndexCount}-` : 'o-'
    const option_id_prefix = (addMoreIndexCount !=='') ? `oq-${addMoreIndexCount}-` : 'oq-'
    const option_class_prefix = (addMoreIndexCount !=='') ? `oqall-${addMoreIndexCount}-` : 'oqall-'    
    
    return (
      <>     
        {
          label_text && addMoreIndexCount ==='' &&
          <>  
          <div className="label_text">{ label_text }</div> 
          </>
        } 

        {
          question_text  &&
          <>  
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
          </>
        } 
        
        { 
            options.map((val,i)=>{                                  
                return(                                    
                <div 
                key={i} 
                title={val.placeholder} 
                className={`form-check form-check-inline radio 
                ${display_type=='0' ? 'vertical' : 'horizontal'}
                ${i==0 ? 'ms-0' : ''}
                `}>
                  <input type="radio" className="btn-check"                                   
                  id={`${radio_id_prefix}${val.option_id}`} 
                  name={field_name} 
                  value={val.value}                   
                  checked={ (data[field_name] ?? '') === val.value ? true : false }
                  onChange={(e)=>{
                    
                    dispatch(fieldAction({
                      ...fields,
                      [field_name]:e.target.value
                    }))

                    if( val.questions && val.questions.length > 0 ){ 
                      $('#'+option_id_prefix+val.option_id).show()
                    }
                    else{
                      $('.'+option_class_prefix+val.question_id).hide()               
                    }
                  }}
                  />                      
                  <label htmlFor={`${radio_id_prefix}${val.option_id}`}>
                  {
                    val.image &&
                    <>
                    <img src={`${file_storage_url}/uploads/document_option/`+val.image} className="radio-img" /><br />
                    </>
                  }                                  
                  { val.title }                           
                  </label>
                </div>                                                             
                )
            })                                                               
        }

        { 
            options.map((val,i)=>{                    
                let value = data[field_name] ?? ''
                return(
                    <div key={i} className={` ${value == val.value ? '' : 'd-none' }`} >
                    {
                        val.quick_info &&
                        <>
                        <div className="card">
                          <div className="card-body d-flex justify-content-start p-0">
                            <div className="p-2" >
                                <img src={`/frontend-assets/images/hint-bulb.png`} style={{width:"50px",maxWidth:"50px"}} />
                            </div>
                            <div className="p-2" style={{lineHeight:"22px"}}>
                            {parseWithLinks(''+val.quick_info+'')}
                            </div>
                          </div>
                        </div>
                        </>
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

        { 
            options.map((val,i)=>{

                let questions = val.questions  
                let style = {  
                  display : (data[field_name] ?? '') === val.value ? '' : 'none' 
                }                     

                return questions.map((val2,j)=>{  
                  const answer_type = val2.answer_type
                  const is_add_another = val2.is_add_another
                  console.log(val2)
                  return(                                         
                    
                      <div key={j} className={`my-3 ${option_class_prefix}${val.question_id}`} id={`${option_id_prefix}${val.option_id}`} style={style}>                        
                        {
                          is_add_another == 1 ?  
                          <Add_more propsData={val2} />                                             
                          :
                          answer_type == 'radio' ?  
                          <Radio propsData={val2} />  
                          :    
                          answer_type == 'radio_group' ?  
                          <Radio_group propsData={val2} index={j} />  
                          :  
                          answer_type == 'checkbox' ?  
                          <Checkbox propsData={val2} />  
                          :  
                          answer_type == 'dropdown' ?  
                          <Dropdown propsData={val2} addMoreIndex={addMoreIndexCount} />  
                          :                  
                          answer_type == 'text' ?  
                          <Text propsData={val2} addMoreIndex={addMoreIndexCount} />                                             
                          :
                          answer_type == 'textarea' ?  
                          <Textarea propsData={val2} addMoreIndex={addMoreIndexCount} /> 
                          :  
                          answer_type == 'date' ?  
                          <Date propsData={val2} addMoreIndex={addMoreIndexCount} />  
                          : 
                          ''                        
                        }  
                      </div>
                    
                    )
                })                              
            })                                
        }                            
      </> 
    )
}
Radio.layout = page => <Layout children={page} />
export default Radio