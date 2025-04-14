import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type == 
import Label from './Label';
import Radio from './Radio';
import Checkbox from './Checkbox';
import Dropdown from './Dropdown';
import Text from './Text';
import Textarea from './Textarea';
import Date from './Date';
//=====

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'
import allFunction from '../../helper/allFunction';

//=== Tooltip ==
import OverlayTrigger from 'react-bootstrap/OverlayTrigger';
import Tooltip from 'react-bootstrap/Tooltip';

const Add_more = ({propsData}) => { 

    const { file_storage_url, pageData } = usePage().props  

    const answer_type = propsData.answer_type
    const options = propsData.options
    const label_text = propsData.label
    const question_text = propsData.question 
    const quick_info = propsData.quick_info  
    const field_name = propsData.field_name
    const add_another_max = ( parseInt(propsData.add_another_max) > 0 ) ? parseInt(propsData.add_another_max) : 1
    const add_another_text = (propsData.add_another_text !='') ? propsData.add_another_text : 'Another' 
    const add_another_button_text = (propsData.add_another_button_text !='') ? propsData.add_another_button_text : 'Add another' 
    const selected_field_count = field_name + '_count' 

    const dispatch = useDispatch()
    const fields   = useSelector( (state)=> state.fields )      
    const { data, setData, post, processing, errors } = useForm({
      //...fields
    }) 
    
    useEffect(()=> {  
      setData({
        ...fields,
        [selected_field_count]:fields[selected_field_count] ?? 1
      })
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
    
    const [count, setCount] = useState( fields[selected_field_count] ? parseInt(fields[selected_field_count]) : 1)   
    
    var listItems = [] 
    for (let i = 0; i < count; i++) {
      listItems.push(i)      
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
        listItems.map((item,i)=>{    

          let index = i + 1

          return(              
              <div key={i} className="my-3 p-3" style={{border:"2px solid #ccc"}}>

                <div className="d-flex justify-content-between mb-2">
                  <div><b>{allFunction.getOrdinal(i+1)} {add_another_text}</b></div>
                  <div>
                    {
                      count > 1 &&
                      <button
                      type="button"
                      className="btn btn-link"
                      style={{color:"#dc3545",borderBottom:"none"}}
                      onClick={() =>{ 
                        
                        setCount( (count-1) > 0 ? count-1 : 1 )  
                        dispatch(fieldAction({
                          ...fields,
                          [selected_field_count]: (count-1) > 0 ? count - 1 : 1
                        }))

                      }}
                      >Remove</button>
                    }                      
                  </div>
                </div>

              { 
                  answer_type == 'label' ?  
                  <Label propsData={propsData} addMoreIndex={index} />  
                  :  
                  answer_type == 'radio' ?  
                  <Radio propsData={propsData} addMoreIndex={index} />  
                  :  
                  answer_type == 'checkbox' ?  
                  <Checkbox propsData={propsData} addMoreIndex={index} />  
                  :  
                  answer_type == 'dropdown' ?  
                  <Dropdown propsData={propsData} addMoreIndex={index} />  
                  :        
                  answer_type == 'text' ?  
                  <Text propsData={propsData} addMoreIndex={index} />                                             
                  :
                  answer_type == 'textarea' ?  
                  <Textarea propsData={propsData} addMoreIndex={index} /> 
                  : 
                  answer_type == 'date' ?  
                  <Date propsData={propsData} addMoreIndex={index} />  
                  : 
                  ''                                     
              }
              </div>
          )
        })
      }   

      {
        add_another_max > count &&
        <>       
          <button
          type="button"
          className="btn btn-link"
          style={{borderBottom:"none"}}
          onClick={() => {

            setCount(count + 1)
            dispatch(fieldAction({
              ...fields,
              [selected_field_count]:count + 1
            }))


          }}
          >+ {add_another_button_text}</button>        
        </>
      }      
      </> 
    )
}
Add_more.layout = page => <Layout children={page} />
export default Add_more