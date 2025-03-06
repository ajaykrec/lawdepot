import { Link } from '@inertiajs/react'

import Header from './../components/header/Header';
import Footer from './../components/footer/Footer';
import Toasts from './../components/messages/Toasts'
import SweetAlert from './../components/messages/SweetAlert'

const GuestLayout = ({ children }) =>{

  let ccp             = window.location.pathname;
	let ccp2     		    = ccp.split('/')
	let current_path    = (ccp2[1]) ? ccp2[1] : ''  

  //const document_menu = ['document','document-download']; 
  const document_menu = []; 
  
  return (
    <> 
    {
       document_menu.includes(current_path) ? '' : <Header />   
    }
    
    <div id="main" className="main page-layout">  
      {children}
    </div> 

    {
      document_menu.includes(current_path) ? '' : <Footer />   
    }    
    
    <SweetAlert />   
    </>
  )
}
export default GuestLayout