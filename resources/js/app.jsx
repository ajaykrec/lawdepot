import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

import { Provider } from 'react-redux'
import { store } from './react_files/frontend/redux/store'

//=== progress bar ====
import NProgress from 'nprogress'
import { router } from '@inertiajs/react'

let timeout = null

router.on('start', () => {
  timeout = setTimeout(() => NProgress.start(), 250)
})

router.on('progress', (event) => {
  if (NProgress.isStarted() && event.detail.progress.percentage) {
    NProgress.set((event.detail.progress.percentage / 100) * 0.9)
  }
})

router.on('finish', (event) => {
  clearTimeout(timeout)
  if (!NProgress.isStarted()) {
    return
  } else if (event.detail.visit.completed) {
    NProgress.done()
  } else if (event.detail.visit.interrupted) {
    NProgress.set(0)
  } else if (event.detail.visit.cancelled) {
    NProgress.done()
    NProgress.remove()
  }
})
//=====================


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
  progress: false,
  
})