import {createStore}  from 'redux'

import reducer from './reducers/reducers'

// function rerenderSidebarStore(state = {re_render : true}){
//     return createStore(rerenderSidebarReducer, state )
// }


// export default rerenderSidebarStore
function store(){
   
}
export default  createStore(reducer)