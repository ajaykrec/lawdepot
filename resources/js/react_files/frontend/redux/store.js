import { configureStore } from "@reduxjs/toolkit";
import { fieldReducer } from "../reducers/fieldReducer";
import {
  membershipModalReducer,   
} from "../reducers/modalReducer";

export const store = configureStore({
  reducer: {   
    'fields':fieldReducer,
    'membership_modal':membershipModalReducer, 
  },
});
//console.log(store.getState())