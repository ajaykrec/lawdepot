import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';
import MyAccountNavBar from '../../components/navbar/MyAccountNavBar';

const My_account = () => {

  const { file_storage_url, customer, pageData, common_data } = usePage().props

  const active_membership = pageData.active_membership
  
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
            
            <ul className="list-group list-group-flush">
              <li className="list-group-item px-0">
                <b>Name : </b> { customer.name }
              </li>
              <li className="list-group-item px-0">
                <b>Email : </b> { customer.email }
              </li>
              <li className="list-group-item px-0">
                <b>Phone : </b> { customer.phone }
              </li>
              <li className="list-group-item px-0">
                <b>Account Status : </b> 
                {
                  customer.status === 1 ?
                  <>
                  <span className="badge bg-success">Active</span>                  
                  </>
                  :
                  <>
                  <span className="badge bg-danger">In-Active</span>                  
                  </>
                }
              </li>
            </ul>
            {
              active_membership === false &&
              <p>You do not have any subscriptions <Link href={ route('membership.index') } style={{color:"rgb(19 111 254)"}}><b>purchage</b></Link> a subscription</p>
            }
            </div>            
          </div>
      </div> 
    </section>       
    </>
  )
}
My_account.layout = page => <Layout children={page} />
export default My_account