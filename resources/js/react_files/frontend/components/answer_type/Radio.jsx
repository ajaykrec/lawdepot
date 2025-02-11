import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==
import Radio_group from './Radio_group';
import Checkbox from './Checkbox';
import Dropdown from './Dropdown';
import Text from './Text';
import Textarea from './Textarea';
import Date from './Date';
//=====

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

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

    const display_type = propsData.display_type
    const options = propsData.options
    const label_text = propsData.label
    const question_text = propsData.question    

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
        <div className={`question ${ label_text ? '' : 'q-margin' }`}>
        { question_text }                                        
        </div>
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
                    <img src={`${file_storage_url}/uploads/document_option/`+val.image} />
                  }                                  
                  <p>{ val.title }</p>
                  </label>
                </div>                                                             
                )
            })                                                               
        }

        { 
            options.map((val,i)=>{

                let questions = val.questions  
                let style = {  
                  display : (data[field_name] ?? '') === val.value ? '' : 'none' 
                }                     

                return questions.map((val2,j)=>{  
                  const answer_type = val2.answer_type
                  return(                                         
                    
                      <div key={j} className={`my-3 ${option_class_prefix}${val.question_id}`} id={`${option_id_prefix}${val.option_id}`} style={style}>                        
                        {
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