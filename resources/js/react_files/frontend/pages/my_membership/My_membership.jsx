import Layout from './../../layouts/GuestLayout'
import React, { useState, useEffect } from 'react';
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';
import allFunction from '../../helper/allFunction';

import Membership_modal from './Membership_modal'; 
import { useSelector, useDispatch } from 'react-redux'
import { membershipAction } from '../../actions/modal'

import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

const My_membership = () => {

  const { file_storage_url, customer, common_data, pageData } = usePage().props

  const dispatch = useDispatch()  
  const membershipModelState = useSelector( (state)=> state.membership_modal ) 

  const [membership_data, set_membership_data] = useState({})   
  const [order_data, set_order_data] = useState({}) 
  
  const MySwal = withReactContent(Swal)

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

  const results = pageData.results ?? []
  const paginate = pageData.paginate ?? []
  const country = common_data.country
  var start_count = pageData.start_count ?? 1
  start_count= start_count-1

  const confirmCancel = async (id)=>{	
      MySwal.fire({
        title: 'Are you sure?',
        text: "You want to Cancel this Subscription",			
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!',
        cancelButtonText: 'No'
        }).then( async (result) => {
        if (result.isConfirmed) {                                          
          location.href = route('cancel.membership',id)    
          // MySwal.fire({
          //       //icon: 'success',
          //       width: '350px',
          //       animation: false,
          //       title: 'Canceled!',
          //       text: "Subscription has been Canceled successfully."
          // })		

        }
      })	
  }   


  return (
    <>
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head>    
    <Header_banner />
    <Breadcrumb />    
    <section className="section py-5">
          <div className="container">
              <div className="row">           
                <div className="col-lg-3 col-md-12 col-12">   
                <MyAccountNavBar />          
                </div>
                <div className="col-lg-9 col-md-12 col-12">   
                    { pageData.page.content ? <>{parseWithLinks(''+pageData.page.content+'')}</> : '' }  

                    <div className="text-end my-2">                   
                      <Link href={ route('membership.index') } className="badge bg-secondary text-white px-2 py-2">Purchage/Upgrade Subscription</Link>
                    </div>
                    <div className="table-responsive">                          
                        <table className="table table-hover table-striped">
                          <thead>
                            <tr className='table-secondary'>
                              <th scope="col">#</th>
                              <th scope="col">Subscription</th>
                              <th scope="col">Price</th>                              
                              <th scope="col">Renew Date</th>
                              <th scope="col">Status</th>
                              <th scope="col" className='text-center'>Option</th>
                            </tr>
                          </thead>
                          <tbody>
                            {
                              results ?                        
                              results.map((val,i)=>{
                                start_count++
                                const membership = val.membership
                                const order = val.order
                                return(
                                  <tr key={i}>
                                    <th scope="row">{start_count}</th> 
                                    <td>{membership.name}</td>
                                    <td>{ allFunction.currency(membership.price, membership.currency_code) }</td>                                    
                                    <td>{ allFunction.dateFormat(val.end_date) }</td>  
                                    <td>
                                      { 
                                        val.status === 0 ?
                                        <span className="badge rounded-pill bg-danger">In-Active</span>                                        
                                        :
                                        val.status === 1 ?
                                        <span className="badge rounded-pill bg-success">Active</span>
                                        :
                                        val.status === 2 ?
                                        <span className="badge rounded-pill bg-secondary">Up-Comming</span>
                                        :
                                        val.status === 3 ?
                                        <span className="badge rounded-pill bg-warning">To Be Cancelled</span>
                                        :
                                        val.status === 4 ?
                                        <span className="badge rounded-pill bg-danger">Cancelled</span>
                                        :
                                        ''
                                      }                                      
                                    </td>  
                                    <td className='text-center'>
                                      <button type="button" className="btn1"
                                      onClick={()=>{
                                        dispatch(membershipAction(true))
                                        set_membership_data(membership)
                                        set_order_data(order)
                                        
                                      }}
                                      >View</button>

                                      { 
                                        val.status !== 3 &&
                                        <button type="button" className="btn1"
                                        title="Cancel" onClick={() => confirmCancel(val.cus_membership_id)}
                                        >Cancel</button>
                                      }

                                      
                                    </td>
                                  </tr>
                                )
                              })
                              :
                              <tr>
                                  <td colspan="6">No record found</td>
                              </tr>
                            }
                          </tbody>
                        </table>
                    </div>
                    <div className="d-flex justify-content-end py-2">                         
                    { parseWithLinks(''+paginate+'') }
                    </div>
                </div>            
              </div>
          </div> 
        </section>   
        {membershipModelState.show &&
          <Membership_modal membership={membership_data} order={order_data} />
        }	      
    </>
  )
}
My_membership.layout = page => <Layout children={page} />
export default My_membership