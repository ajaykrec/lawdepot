import React, { useState, useEffect, useRef } from 'react';
import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import anime from 'animejs/lib/anime.es.js';
import Parser, { domToReact } from 'html-react-parser';

import Category_banner from '../../components/banner/Category_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

const All_documents = () => {

  const { file_storage_url, common_data, pageData } = usePage().props
  const azRange = pageData.azRange
  const documents = pageData.documents
  const name_txt = pageData.name

  const { data, setData, post, delete: destroy,  processing, progress, errors } = useForm({
      name: '', 
      _method: 'POST'  
  })
  const [error, setError] = useState(errors)    

  useEffect(()=> {  
        
  },[]) 
    
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

  function submit(e) {
      e.preventDefault()
      post(route('all.documents'), {
        forceFormData: true,
        onSuccess: (res) => {  
          
        }
      })           
  }
 
  return (
    <>
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head> 
    <Category_banner />
    <Breadcrumb />   

    <section className="cover-background pt-5 xs-pt-8"> 
        <div className="container"> 
            <div className="row">                
              <div className="col-12">  

                <h3 className='text-dark-gray fw-700 ls-minus-2px text-center'>Legal Forms &amp; Legal Documents</h3>
                <h6 className='text-center'>Answer a few simple questions - download and print instantly</h6>

                <div className="card" style={{background:"#cce"}}>
                  <div className="card-body">                    
                    <form onSubmit={submit}>
                      <div className="input-group">
                        <input type="text" className="form-control" placeholder="Search All Documents..." 
                        name="name"
                        value={data.name} 
                        onChange={ (e) => {
                            setData('name', e.target.value)                            
                        }}
                        />
                        <div className="input-group-append">
                          <button className="btn btn-medium btn-dark-gray" type="submit">Search</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div className='text-center py-5'>
                {
                  azRange.map((val,i)=>{
                    return(
                      <a key={i} href={`#alphabet-${val}`} className="alphabet">{val}</a>
                    )
                  })
                }
                </div>

              </div>
            </div>

            <div className="row justify-content-center">   
              <div className="col-md-8">  
              <div className="row text-center">   
              {
                documents.length > 0 ?
                  documents.map((val,i)=>{                    
                    const docs = val.docs
                    return(
                      <div key={i} className="col-12 col-md-6 text-start">  
                      <h4 className="alphabet dark" id={`alphabet-${val.letter}`}>{val.letter}</h4>
                      {
                        docs.length > 0 ?
                          <ul className="alphabet-ul">
                          { 
                            docs.map((val2,k)=>{
                              return(
                                <li key={k}>
                                  <i className="feather icon-feather-arrow-right"></i> <Link href={ route('doc.index',val2.slug) }>{val2.name}</Link>
                                </li>
                              )
                            })
                          }
                          </ul>
                          :
                          ''
                      }
                      </div>
                    )
                  })
                :
                <div className='text-center'>
                No Record Found for "{name_txt}"
                </div>
               
              }
              </div>
              </div>
            </div>

        </div>
    </section>   
    
    </>
  )
}
All_documents.layout = page => <Layout children={page} />
export default All_documents