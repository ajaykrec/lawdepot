import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==
import Add_more from './Add_more';
import Radio from './Radio';
import Radio_group from './Radio_group';
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

const Checkbox = ({propsData, addMoreIndex}) => { 

    const { file_storage_url, pageData } = usePage().props     
    

    const dispatch = useDispatch()
    const fields   = useSelector( (state)=> state.fields )
    const { data, setData, post, processing, errors } = useForm({
        //...fields,     
    })      
    
    const options = propsData.options
    const display_type = propsData.display_type
    const label_text = propsData.label
    const question_text = propsData.question
    const quick_info = propsData.quick_info    
    const description = propsData.description   

    const addMoreIndexCount = (typeof addMoreIndex !== "undefined" && addMoreIndex !== '') ? addMoreIndex : ''
    const field_name = (addMoreIndexCount !=='') ? `${propsData.field_name}_${addMoreIndexCount}` : propsData.field_name

    let table_selected_value = []
    if( fields[field_name] ){
      table_selected_value = JSON.parse(fields[field_name])
      table_selected_value = Object.values(table_selected_value) 
    }    
       
    const [selected_rows, set_selected_rows] = useState(table_selected_value) 
    
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
        { 
            options.map((val,i)=>{                  
              
                return(                                    
                <div 
                key={i} 
                title={val.placeholder} 
                className={`form-check form-check-inline checkbox 
                ${display_type=='0' ? 'vertical' : 'horizontal'}
                ${i==0 ? 'ms-0' : ''}
                `}>
                  <input type="checkbox" className="form-check-input" 
                  name={`${field_name}`}                                  
                  id={`o-${val.option_id}`}                  
                  
                  onChange={(e)=>{                       

                      if(e.target.checked){
                        selected_rows.push(val.value)
                      }
                      else{  
                        selected_rows.splice(selected_rows.indexOf(val.value), 1)
                      }        
                      
                      set_selected_rows(selected_rows)
                      dispatch(fieldAction({
                          ...fields,
                          [field_name]:JSON.stringify(Object.assign({}, selected_rows))
                          
                      }))                      

                  }}
                  defaultChecked={ selected_rows.includes(val.value) ? true : false }
                  />                      
                  <label className="form-check-label" htmlFor={`o-${val.option_id}`}>
                  {
                    val.image &&
                    <>
                    <img src={`${file_storage_url}/uploads/document_option/`+val.image} /><br />
                    </>
                  }                                  
                  { val.title } 
                  { 
                      val.quick_info &&
                      <>
                      &nbsp; 
                      <OverlayTrigger
                          key="top"
                          placement="top"
                          overlay={
                          <Tooltip>
                          {parseWithLinks(''+val.quick_info+'')}
                          </Tooltip>
                          }
                      >           
                      <i className="fa-solid fa-circle-question"></i>
                      </OverlayTrigger>
                      </>
                  }                               
                  </label>
                </div>                                                             
                )
            })                                                               
        }
        
        { 
            options.map((val,i)=>{

                let questions = val.questions  
                let style = {  
                  'display' : selected_rows.includes(val.value)  ? '' : 'none' 
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
            <div className="card-body" style={{lineHeight:"22px"}}>
            {parseWithLinks(''+description+'')}
            </div>
          </div>
          </> 
        }                          
      </> 
    )
}
Checkbox.layout = page => <Layout children={page} />
export default Checkbox