import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

createInertiaApp({  
  resolve: name => {
    const pages = import.meta.glob('./react_files/**/*.jsx', { eager: true })
    return pages[`./react_files/${name}.jsx`]
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
})