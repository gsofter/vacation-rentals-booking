export default(state = false, action) =>{
    switch(action.type){
        case  're_render_sidebar':
        return {
            re_render : action.re_render
        }
        break;
        default:
        return state;
    }

}