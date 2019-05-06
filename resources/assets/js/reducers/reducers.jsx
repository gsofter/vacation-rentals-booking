import { combineReducers } from 'redux'
import rerenderSidebarReducer from './managelisting/rerenderSidebarReducer'
import chatmoduleReducer from './chatmodule/chatmoduleReducer'
export default combineReducers({
    rerenderSidebarReducer, chatmoduleReducer
})