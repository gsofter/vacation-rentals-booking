export default(state = {is_show : true}, action  ) =>{
    switch(action.type){
        case  'open_chat_box':
        return {
            contactId : action.contactId
        }
        break;
        case 'display_chat_box':
        return {
            is_show : action.is_show
        }
        default:
        return state;
    }

}