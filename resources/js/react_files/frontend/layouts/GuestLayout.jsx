import { Link } from '@inertiajs/react'

import Header from './../components/header/Header';
import Footer from './../components/footer/Footer';
import Toasts from './../components/messages/Toasts'
import SweetAlert from './../components/messages/SweetAlert'

const GuestLayout = ({ children }) =>{
  return (
    <> 
    <Header />   
    <div id="main" className="main page-layout">  
      {children}
    </div>     
    <Footer />   
    <SweetAlert />   
    </>
  )
}
export default GuestLayout