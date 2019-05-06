import React from 'react'
import Chathistory from './Chathistory'
import Axios from 'axios'
import Pusher from 'pusher-js';
const metas = document.getElementsByTagName('meta');
export default class Chatbox extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            chat_history : [],
            message : '',
            isLogedIn : metas['isLogedin'].content
        }
        this.chatKeyPress = this.chatKeyPress.bind(this)
        this.chatKeyChange = this.chatKeyChange.bind(this)
    }
    componentDidMount(){
        if(metas['isLogedin'].content == 'true'){
            Axios.get('/ajax/chat/getmessages?chat_id='+this.props.user_details.id+'&my_id='+metas['LogedUserId'].content)
            .then(result=>{
                this.setState({chat_history : result.data});
            }, ()=>{
                var chatDiv = document.getElementById('chat-messages');
                chatDiv.scrollTop = document.getElementById('chat-messages-lists').clientHeight;
            })
            const pusher = new Pusher('ccd81a8b36efcabe5a7b', {
                cluster: 'mt1',
                encrypted: true,
                disableStats: true ,
            });
            const channel_string = 'chat_' + metas['LogedUserId'].content;
            console.log(channel_string)
            const channel = pusher.subscribe('chat_' + metas['LogedUserId'].content);
            const message_read_channel = pusher.subscribe('message_read_' + metas['LogedUserId'].content);
            channel.bind('App\\Events\\MessageSent', data => {
                let chat_history = this.state.chat_history
                if(data.message.message.sender_id == this.props.user_details.id){
                    chat_history.push(
                        data.message.message
                    ) 
                }
                this.setState({
                    chat_history : chat_history
                  }, ()=>{
                    var chatDiv = document.getElementById('chat-messages');
                    chatDiv.scrollTop = document.getElementById('chat-messages-lists').clientHeight;
                  })
            });
        }
    }
    chatKeyPress(e){
        if(e.key == 'Enter'){
            
          e.preventDefault()
            let chat_history = this.state.chat_history
            chat_history.push(
                { user_id : this.props.user_details.id,
                    sender_id : metas['LogedUserId'].content,
                    message : this.state.message, sender_profile_picture : this.props.user_details.user_profile_pic}
            ) 
            this.setState({
            
                chat_history : chat_history
              }, ()=>{
                var chatDiv = document.getElementById('chat-messages');
                chatDiv.scrollTop = document.getElementById('chat-messages-lists').clientHeight;

              })
           if(this.state.isLogedIn == 'true' ) {
                Axios.post('/ajax/chat/sendmessage', {
                    user_id : this.props.user_details.id,
                    sender_id : metas['LogedUserId'].content,
                    message : this.state.message 
                
                }).then(result =>{
                  
                    
                })
                
           }
           else{
           
           }
           this.setState({
            message :'' 
          })
        }
      }
      chatKeyChange(e){
        
        this.setState({
          message : e.target.value
        })
      }
    render(){
        return <div id="chatbox">
        <div id="chatview" className="p1" style={{display: 'block'}}>    	
          <div id="profile" className="animate" style={{backgroundImage : `url(${this.props.room_detail.photo_name})`, backgroundSize : 'cover', backgroundPosition : 'center'}}>
            <div id="close" onClick={this.props.openChatModal}>
              <div className="cy s1 s2 s3" />
              <div className="cx s1 s2 s3" />
            </div>
            <p className="animate">{this.props.user_details.full_name}</p>
            <span>{this.props.user_details.email}</span>
          </div>
          <div id="chat-messages" className="animate">
            <label>Thursday 02</label>
            <Chathistory chat_history= {this.state.chat_history} chatUser = {this.props.user_details.id}/>
          </div>
          <div id="sendmessage">
            <textarea type="text" className='chatinput' placeholder="Send message..." value={this.state.message} onKeyPress={this.chatKeyPress} onChange={this.chatKeyChange} />
            <button id="send" />
          </div>
        </div>        
        <img src={this.props.user_details.user_profile_pic} className="floatingImg" style={{top: '20px', width: '68px', left: '108px'}} /></div>
    }
}