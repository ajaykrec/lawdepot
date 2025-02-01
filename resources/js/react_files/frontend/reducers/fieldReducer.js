import React, { useState, useEffect, useRef } from 'react';
import {Head, useForm, usePage, Link, router } from '@inertiajs/react'

let data_fields = document.getElementById('app')
data_fields = data_fields.getAttribute('data-page')
data_fields = JSON.parse(data_fields)
let initialState = data_fields.props.pageData.fields ? data_fields.props.pageData.fields : {}

export const fieldReducer = (state = initialState, action={})=>{ 
    switch(action.type){
        case "update_field" : return action.payload        
        default: return state
    }
}