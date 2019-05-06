import React from 'react'
import dateFns from "date-fns";
const metas = document.getElementsByTagName('meta');

class Chathistory extends React.PureComponent{
    constructor(props){
        super(props)
    }
    componentDidMount(){

    }
    render(){
        const isLogedIn = metas['isLogedin'].content;
        return <ul id='chat-messages-lists'>
            {
                isLogedIn ? this.props.chat_history.map((message, index) =>{
                  return    <div className={message.sender_id ==  metas['LogedUserId'].content ? "message right" : "message" }  key={index}>
                  <img src={message.sender_id == metas['LogedUserId'] ? message.user_profile_picture : message.sender_profile_picture} />
                  <div className="bubble">
                    {message.message}
                    <div className="corner" />
                    <span>{message.created_at ? dateFns.format(new Date(message.created_at), 'h:m, A') : 'Now'}, {message.created_at ? (dateFns.differenceInHours(new Date(), new Date(message.created_at)) > 24 ? dateFns.differenceInHours(new Date(), new Date(message.created_at))/24 + 'Day Ago' : 'Today' ) : null }</span>
                  </div>
                </div>
                  //   return  <li className="clearfix" key={index}>
                  //   <div className={message.sender_id == my_id ? "message-data align-right" : "message-data" }>
                  //     <span className="message-data-time">{dateFns.format(new Date(message.created_at), 'h:m, A')}, {dateFns.differenceInHours(new Date(), new Date(message.created_at)) > 24 ? dateFns.differenceInHours(new Date(), new Date(message.created_at))/24 + 'Day Ago' : 'Today' }</span> 
                  //     <span className="message-data-name">{message.sender_name}</span> 
                  //     {/* <i className="fa fa-circle me" /> */}
                  //   </div>
                  //   <div className={message.sender_id == my_id ? 'message other-message float-right' : 'message my-message'}>
                  //     {message.message}
                  //   </div>
                  // </li>
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