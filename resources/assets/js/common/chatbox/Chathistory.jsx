import React from 'react'
import dateFns from "date-fns";
import Linkify  from 'react-linkify'
import { EmojioneV4  } from 'react-emoji-render';
const metas = document.getElementsByTagName('meta');

class Chathistory extends React.PureComponent{
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
        return <ul  id={'chat-messages-lists_' + this.props.chatUser}>
            {
                isLogedIn ? this.props.chat_history.map((message, index) =>{
                  return  <li>
                  <div className={message.sender_id ==  metas['LogedUserId'].content ? "user-comment-middle" :  "admin-comment-area  user-comment-middle"  }>
                    <div className="user-comment-middle-inner">
                      <p>
                      {
                    message.type == 'text'  ?  <Linkify   properties={{target: '_blank', style: { fontWeight: 'bold'}}}><EmojioneV4  svg     size={128} text={message.message}></EmojioneV4 ></Linkify>
                    : 
                    <a download href={message.url}>
                    {
                      message.type == 'file' ? <i className='fa fa-file'>{message.message}</i> : <img className='chat_preview_image' src={message.url}/>
                    }
                    </a>
                    

                  }
                      </p>
                    </div>
                    {
                    message.final_read_chat ? <div><i className='fa fa-user final_read_message'></i>
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
                </li>
                  return    <div className={message.sender_id ==  metas['LogedUserId'].content ? "message right" : "message" }  key={index}>
                  <img src={message.sender_id == metas['LogedUserId'] ? message.user_profile_picture : message.sender_profile_picture} />
                  <div className="bubble">

                  {
                    message.type == 'text'  ?  <Linkify   properties={{target: '_blank', style: { fontWeight: 'bold'}}}><EmojioneV4  svg     size={128} text={message.message}></EmojioneV4 ></Linkify>
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
                    message.final_read_chat ? <div><i className='fa fa-user final_read_message'></i>
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
        {/* 
        <div className="message">
                          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/3_copy.jpg" />
                          <div className="bubble">
                            Really cool stuff!
                            <div className="corner" />
                            <span>3 min</span>
                          </div>
                        </div>
                        <div className="message right">
                          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/2_copy.jpg" />
                          <div className="bubble">
                            Can you share a link for the tutorial?
                            <div className="corner" />
                            <span>1 min</span>
                          </div>
                        </div>
                        <div className="message">
                          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/3_copy.jpg" />
                          <div className="bubble">
                            Yeah, hold on
                            <div className="corner" />
                            <span>Now</span>
                          </div>
                        </div>
                        <div className="message right">
                          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/2_copy.jpg" />
                          <div className="bubble">
                            Can you share a link for the tutorial?
                            <div className="corner" />
                            <span>1 min</span>
                          </div>
                        </div>
                        <div className="message">
                          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/3_copy.jpg" />
                          <div className="bubble">
                            Yeah, hold on
                            <div className="corner" />
                            <span>Now</span>
                          </div>
                        </div>
                        <li>
          <div className="message-data">
            <span className="message-data-name"><i className="fa fa-circle online" /> Vincent</span>
            <span className="message-data-time">10:12 AM, Today</span>
          </div>
          <div className="">
            Are we meeting today? Project has been already finished and I have results to show you.
          </div>
        </li>
        <li className="clearfix">
          <div className="message-data align-right">
            <span className="message-data-time">10:14 AM, Today</span> &nbsp; &nbsp;
            <span className="message-data-name">Olia</span> <i className="fa fa-circle me" />
          </div>
          <div className="message other-message float-right">
            Well I am not sure. The rest of the team is not here yet. Maybe in an hour or so? Have you faced any problems at the last phase of the project?
          </div>
        </li>
        <li>
          <div className="message-data">
            <span className="message-data-name"><i className="fa fa-circle online" /> Vincent</span>
            <span className="message-data-time">10:20 AM, Today</span>
          </div>
          <div className="message my-message">
            Actually everything was fine. I'm very excited to show this to our team.
          </div>
        </li>
        <li>
          <div className="message-data">
            <span className="message-data-name"><i className="fa fa-circle online" /> Vincent</span>
            <span className="message-data-time">10:31 AM, Today</span>
          </div>
        
        </li> */}
        
      </ul>
    }
}
export default Chathistory