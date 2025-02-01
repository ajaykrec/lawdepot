import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==
import Radio from './Radio';
import Radio_group from './Radio_group';
import Checkbox from './Checkbox';
import Dropdown from './Dropdown';
import Text from './Text';
import Textarea from './Textarea';
import Date from './Date';
//=====

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

const Add_more = ({propsData}) => { 

    const { file_storage_url, pageData } = usePage().props  

    const answer_type = propsData.answer_type
    const label_text = propsData.label
    const field_name = propsData.field_name
    const add_another_max = ( parseInt(propsData.add_another_max) > 0 ) ? parseInt(propsData.add_another_max) : 1
    const add_another_text = (propsData.add_another_text !='') ? propsData.add_another_text : 'Add another' 
    const selected_field_count = field_name + '_count' 

    const dispatch = useDispatch()
    const fields   = useSelector( (state)=> state.fields )      
    const { data, setData, post, processing, errors } = useForm({
      //...fields
    }) 
    
    useEffect(()=> {  
      setData({
        ...fields,
        [selected_field_count]:fields[selected_field_count] ?? [field_name+'_1']
      })
    },[fields])   
    
    const [listItems, setlistItems] = useState( fields[selected_field_count] ? fields[selected_field_count] : [field_name+'_1'])     
    
    var listItems_ = [] 
    listItems.map((item,i)=>{    
      listItems_.push(item)      
    })   
    
    let firstWord = label_text.split(' ')[0]   
    var count = 1
    return (

      <>      
      {
          label_text &&
          <>  
          <div className="label_text">{ label_text }</div> 
          </>
      } 
      
      {
        listItems.map((item,i)=>{    

          let index = i + 1

          return(              
              <div key={i} className="my-3 p-3" style={{border:"2px solid #ccc"}}>

                <div className="d-flex justify-content-between mb-2">
                  <div>{firstWord} {i+1}</div>
                  <div>
                    {
                      listItems.length > 1 &&
                      <button
                      type="button"
                      className="btn btn-link"
                      style={{color:"#dc3545",borderBottom:"none"}}
                      onClick={() =>{ 
                        
                        let ff = field_name +'_'+ (count + 1)                         
                        listItems_.splice(listItems_.indexOf(ff), 1)
                        
                        setlistItems(listItems_)
                        dispatch(fieldAction({
                          ...fields,
                          [selected_field_count]:listItems_
                        }))


                      }}
                      >Remove</button>
                    }                      
                  </div>
                </div>

              { 
                  answer_type == 'radio' ?  
                  <Radio  propsData={propsData} addMoreIndex={index} />  
                  :  
                  answer_type == 'dropdown' ?  
                  <Dropdown  propsData={propsData} addMoreIndex={index} />  
                  :        
                  answer_type == 'text' ?  
                  <Text  propsData={propsData} addMoreIndex={index} />                                             
                  :
                  answer_type == 'textarea' ?  
                  <Textarea  propsData={propsData} addMoreIndex={index} /> 
                  : 
                  answer_type == 'date' ?  
                  <Date  propsData={propsData} addMoreIndex={index} />  
                  : 
                  ''                                     
              }
              </div>
          )
        })
      }   

      {
        add_another_max > listItems.length &&
        <>
        <p>
          <button
          type="button"
          className="btn btn-link"
          style={{borderBottom:"none"}}
          onClick={() => {

            let ff = field_name +'_'+ (count + 1) 
            if( !listItems_.includes(ff) ){
              listItems_.push(ff)
            }
           
            setlistItems(listItems_)
            dispatch(fieldAction({
              ...fields,
              [selected_field_count]:listItems_
            }))


          }}
          >+ {add_another_text}</button>
        </p>
        </>
      }      
      </> 
    )
}
Add_more.layout = page => <Layout children={page} />
export default Add_more