import { configureStore } from "@reduxjs/toolkit";
import { fieldReducer } from "../reducers/fieldReducer";

export const store = configureStore({
  reducer: {   
    'fields':fieldReducer, 
  },
});
//console.log(store.getState())