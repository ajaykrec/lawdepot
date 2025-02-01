import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';

//=== answer_type ==
import Radio from './Radio';
import Radio_group from './Radio_group';
import Dropdown from './Dropdown';
import Text from './Text';
import Textarea from './Textarea';
import Date from './Date';
//=====

import { useSelector, useDispatch } from 'react-redux'
import { fieldAction } from '../../actions/fields'

const Checkbox = ({propsData}) => { 

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
    const field_name = propsData.field_name  

    let table_selected_value = []
    if( fields[field_name] ){
      table_selected_value = JSON.parse(fields[field_name])
      table_selected_value = Object.values(table_selected_value) 
    }    
       
    const [selected_rows, set_selected_rows] = useState(table_selected_value) 
    
    useEffect(()=> { 
      setData(fields) 
    },[fields])      
    
    return (
      <> 
      
      </> 
    )
}
Checkbox.layout = page => <Layout children={page} />
export default Checkbox