import React from 'react'
import dateFns from "date-fns";
import FileViewer from 'react-file-viewer';
import Linkify  from 'react-linkify'
import MicrolinkCard from '@microlink/react'
// import getUrls from 'get-urls'
import { EmojioneV4  } from 'react-emoji-render';
const metas = document.getElementsByTagName('meta');
class ChatHistory extends React.PureComponent{
    constructor(props){
        super(props)
    }
    componentDidMount(){
      
      var chatDiv = document.getElementById('chat-messages_' + this.props.chatUser);
      chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.chatUser).clientHeight;
    }
   
    render(){
        console.log(this.props)
        const isLogedIn = metas['isLogedin'].content;
        return <ul className="list-unstyled"  id={'chat-messages-lists_' + this.props.chatUser}> 
         {
                isLogedIn ? this.props.chat_history.map((message, index) =>{
                    return  <li className={message.sender_id ==  metas['LogedUserId'].content ? "chat-list list-r" : "chat-list list-l" }  key={index}>
                    <div className="chat-user-text">
                      <div className="user-txts">
                        <div className="user-av">
                          <img src={message.sender_id == metas['LogedUserId'] ? message.user_profile_picture : message.sender_profile_picture} alt />
                        </div>
                        <div className="user-txt">
                        <h5>
                        {message.sender_id == metas['LogedUserId'] ? (message.user && message.user.first_name ? message.user.first_name : metas['userFirstName'].content  ): (message.sender && message.sender.first_name ? message.sender.first_name :  metas['userFirstName'].content)}
                        </h5>
                            {
                                message.type == 'text'  ?  <Linkify   properties={{target: '_blank', style: { fontWeight: 'bold'}}}><EmojioneV4       size={128} text={message.message}></EmojioneV4 ></Linkify>
                                : <a download href={message.url}>
                                {
                                        message.type == 'file' ? <i className='fa fa-file'>{message.message}</i> : <img className='chat_preview_image' src={message.url}/>
                                        }
                                    </a>
                            }
                        </div>
                        <div className="next-txt">
                          <small>{message.created_at ? dateFns.format(new Date(message.created_at), 'h:m, A') : 'Sending...'}, {message.created_at ? (dateFns.differenceInHours(new Date(), new Date(message.created_at)) > 24 ? Math.round(dateFns.differenceInHours(new Date(), new Date(message.created_at))/24) + 'Day Ago' : 'Today' ) : null }</small>
                        </div>
                      </div>
                    </div>
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
                
                  </li>
                }) : 
                <label>Please Login to chat with Homeowner</label>
            }
              
      </ul>
    }
}
export default ChatHistory