import { Link } from '@inertiajs/react'

import Header from './../components/header/Header';
import Footer from './../components/footer/Footer';
import Toasts from './../components/messages/Toasts'
import SweetAlert from './../components/messages/SweetAlert'

const GuestLayout = ({ children }) =>{
  return (
    <> 
    <Header />   
    <main id="main" className="main">  
      {children}
     </main>     
    <Footer />   
    <SweetAlert />   
    </>
  )
}
export default GuestLayout