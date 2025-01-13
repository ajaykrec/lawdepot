import Layout from './../../layouts/GuestLayout'

import {Head, useForm, usePage,  Link } from '@inertiajs/react'

import Header_carousel from './child/Header_carousel'

import FreeText from './child/FreeText'
import Services from './child/Services'

import Simple from './child/Simple'
import Affordable_services from './child/Affordable_services'

import Membership_plans from './child/Membership_plans'
import Are_you_ready from './child/Are_you_ready'

import Faq from './child/Faq'
import Testimonials from './child/Testimonials'
import Brands from './child/Brands'

const Home = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props
  //console.log(common_data.settings)

  return (
    <>
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head>    
        <Header_carousel />     
           
        {/* <FreeText /> */}
        {/* <Services /> */}

        {/* <Simple /> */}
        {/* <Affordable_services /> */}

        {/* <Membership_plans /> */}
        {/* <Are_you_ready /> */}
        {/* <Faq /> */}

        {/* <Testimonials /> */}

        {/* <Brands /> */}
    </>
  )
}
Home.layout = page => <Layout children={page} />
export default Home