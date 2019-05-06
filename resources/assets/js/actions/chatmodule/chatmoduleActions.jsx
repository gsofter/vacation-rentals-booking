export function openChatBoxAction(contactId) {
    return {
        type : 'open_chat_box',
        contactId : contactId
    }
}

export function hideChatBoxes(){
    return {
        type : 'display_chat_box',
        is_show : false
    }
}
export function showChatBoxes(){
    return {
        type : 'display_chat_box',
        is_show : true
    }
}