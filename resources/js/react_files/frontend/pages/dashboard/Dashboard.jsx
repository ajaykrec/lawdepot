import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';

import Header_banner from '../../components/banner/Header_banner';
import Breadcrumb from '../../components/breadcrumb/Breadcrumb';

const Dashboard = ({ pageData }) => {

  const { file_storage_url, customer, common_data } = usePage().props
  
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
              {
                pageData.page.content &&
                <div className="col-12 pb-5">
                {parseWithLinks(''+pageData.page.content+'')} 
                </div>
              }              
              <div className="col-lg-12 col-md-12 col-12">
              Dashboard....
              </div>
           </div>
        </div>
      </section>
       
    </>
  )
}
Dashboard.layout = page => <Layout children={page} />
export default Dashboard