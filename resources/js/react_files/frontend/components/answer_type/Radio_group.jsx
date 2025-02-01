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
    const field_name = propsData.field_name

    const width1 = 40
    const width2 = (parseInt(100-width1)/options.length)
   
    useEffect(()=> {  
      setData(fields)
    },[fields]) 
 
    return (
      <> 
      </> 
    )
}
Radio_group.layout = page => <Layout children={page} />
export default Radio_group