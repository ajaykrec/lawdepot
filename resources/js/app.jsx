import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

import { Provider } from 'react-redux'
import { store } from './react_files/frontend/redux/store'

createInertiaApp({  
  resolve: name => {
    const pages = import.meta.glob('./react_files/**/*.jsx', { eager: true })
    return pages[`./react_files/${name}.jsx`]
  },
  setup({ el, App, props }) {
    createRoot(el).render(
      <Provider store={store}>
      <App {...props} />
      </Provider> 
    )
  },
})