const initialState = {
    show:false
}
export const membershipModalReducer = (state = initialState, action)=>{
    switch(action.type){
        case "open_membership" : return {...state, show:action.payload}        
        default: return state
    }
}


