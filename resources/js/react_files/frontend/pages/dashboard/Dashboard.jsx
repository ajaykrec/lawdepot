import Layout from './../../layouts/GuestLayout'
import {Head, useForm, usePage,  Link } from '@inertiajs/react'

const Dashboard = ({ pageData }) => {

  const { file_storage_url, common_data } = usePage().props
 
  return (
    <>
    <Head>
        <title>{pageData.meta.title}</title>
        <meta name="description" content={pageData.meta.description} />
    </Head>    
        <div className='p-5'>
        Dashboard.....
        </div>
       
    </>
  )
}
Dashboard.layout = page => <Layout children={page} />
export default Dashboard