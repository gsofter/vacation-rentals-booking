import React from 'react'
import dateFns from "date-fns";
import FileViewer from 'react-file-viewer';
import Linkify  from 'react-linkify'
import MicrolinkCard from '@microlink/react'
// import getUrls from 'get-urls'
import { EmojioneV4  } from 'react-emoji-render';
const metas = document.getElementsByTagName('meta');

class Chathistory extends React.Component{
    constructor(props){
        super(props)
    }
    componentDidMount(){

    }
    onError(e) {
      console.log(e, 'Error!!!')
    }
    render(){
        const isLogedIn = metas['isLogedin'].content;
        return <ul className='chat-messages-lists' id={'chat-messages-lists_' + this.props.chatUser}>
            {
                isLogedIn ? this.props.chat_history.map((message, index) =>{
                  return    <div className={message.sender_id ==  metas['LogedUserId'].content ? "message right" : "message" }  key={index}>
                  <img src={message.sender_id == metas['LogedUserId'] ? message.user_profile_picture : message.sender_profile_picture} />
                  <div className="bubble">

                  {
                    message.type == 'text'  ?  <Linkify   properties={{target: '_blank', style: { fontWeight: 'bold'}}}><EmojioneV4       size={128} text={message.message}></EmojioneV4 ></Linkify>
                    : 
                    <a download href={message.url}>
                    {
                      message.type == 'file' ? <i className='fa fa-file'>{message.message}</i> : <img className='chat_preview_image' src={message.url}/>
                    }
                    </a>

                  }
                    <div className="corner" />
                    
                  </div>
                  <p className='clearfix'><small>{message.created_at ? dateFns.format(new Date(message.created_at), 'h:m, A') : 'Sending...'}, {message.created_at ? (dateFns.differenceInHours(new Date(), new Date(message.created_at)) > 24 ? Math.round(dateFns.differenceInHours(new Date(), new Date(message.created_at))/24) + 'Day Ago' : 'Today' ) : null }</small></p>
                  {
                    message.type == 'text' ?
                    message.message.match(/\bhttps?::\/\/\S+/gi)
                    : null
                  }
                  {
                    message.final_read_chat ? <div className='clearfix'><i className='fa fa-user final_read_message'></i>
                    {
                      this.props.is_typing ?  <div className="typing-indicator">
                      <span></span>
                      <span></span>
                      <span></span>
                      </div>
                     : null
                    }
                     </div>  : null
                  }
                </div>
                  
                }) : 
                <label>Please Login to chat with Homeowner</label>
                
            }
        
        
      </ul>
    }
}
export default Chathistory