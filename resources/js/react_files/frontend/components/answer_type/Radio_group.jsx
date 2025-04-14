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

//=== Tooltip ==
import OverlayTrigger from 'react-bootstrap/OverlayTrigger';
import Tooltip from 'react-bootstrap/Tooltip';

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

const Radio_group = ({propsData, index}) => { 

    const { file_storage_url, pageData } = usePage().props  

    const dispatch = useDispatch()
    const fields   = useSelector( (state)=> state.fields )      
    const { data, setData, post, processing, errors } = useForm({
        //...fields,     
    })  

    const display_type = propsData.display_type
    const options = propsData.options
    const label_text = propsData.label
    const question_text = propsData.question
    const quick_info = propsData.quick_info       
    const field_name = propsData.field_name

    const width1 = 40
    const width2 = (parseInt(100-width1)/options.length)
   
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
 
    return (
      <> 
       <div className="col-lg-12 col-md-12 col-12">
        {
          index == 0 &&
          <>
            <div className="d-flex justify-content-between align-items-center radio-group-row">
              <div className="text-start" style={{width:width1+"%"}}>
              &nbsp;            
              </div>
              {
                options.map((val,i)=>{
                  return(
                    <div key={i} className="text-center" style={{width:width2+"%"}}>
                    { val.title }
                    </div>
                  )
                })                  
              }               
          </div>
          </>
        }
        
        <div className="d-flex justify-content-between align-items-center radio-group-row">
          <div className="text-start" style={{width:width1+"%"}}>
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
          { 
              options.map((val,i)=>{                                  
                  return(                                    
                    <div 
                    style={{width:width2+"%"}}
                    key={i} 
                    title={val.placeholder} 
                    className={`form-check form-check-inline text-center
                    ${display_type=='0' ? 'vertical' : 'horizontal'}
                    ${i==0 ? 'ms-0' : ''}
                    `}>
                      <input type="radio" className="form-check-input"                                   
                      id={`o-${val.option_id}`} 
                      name={field_name} 
                      value={val.value}                     
                      checked={ (data[field_name] ?? '') === val.value ? true : false }
                      onChange={(e)=>{                         

                        dispatch(fieldAction({
                          ...fields,
                          [field_name]:e.target.value
                        }))

                        if( val.questions && val.questions.length > 0 ){ 
                          $('#oq-'+val.option_id).show()
                        }
                        else{
                          $('.oqall-'+val.question_id).hide()               
                        }
                      }}
                      /> 
                      {/* <label htmlFor={`o-${val.option_id}`} className="text-center">                                        
                      &nbsp;
                      </label> */}
                    </div>                                                             
                  )
              })                                                               
          }
        </div>
        </div>

        { 
            options.map((val,i)=>{

                let questions = val.questions  
                let style = {  
                  display : (data[field_name] ?? '') === val.value ? '' : 'none' 
                }                     

                return questions.map((val2,j)=>{  
                  const answer_type = val2.answer_type
                  return(                                         
                    
                      <div key={j} className={`my-3 oqall-${val.question_id}`} id={`oq-${val.option_id}`} style={style}>                        
                        {
                          answer_type == 'radio' ?  
                          <Radio  propsData={val2} />  
                          :   
                          answer_type == 'radio_group' ?  
                          <Radio_group  propsData={val2} index={j} />  
                          :  
                          answer_type == 'checkbox' ?  
                          <Checkbox  propsData={val2} />  
                          :   
                          answer_type == 'dropdown' ?  
                          <Dropdown  propsData={val2} />  
                          :                          
                          answer_type == 'text' ?  
                          <Text  propsData={val2} />                                             
                          :
                          answer_type == 'textarea' ?  
                          <Textarea  propsData={val2} /> 
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
      </> 
    )
}
Radio_group.layout = page => <Layout children={page} />
export default Radio_group