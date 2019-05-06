import {createStore}  from 'redux'
import rerenderSidebarReducer from './reducers/managelisting/rerenderSidebarReducer'
import openChatboxReducer from './reducers/openChatboxReducer'
function openChatboxStore(state = {chat_user_id : null, message : ''}){
    return createStore(openChatboxReducer, state)
}

export default openChatboxStore