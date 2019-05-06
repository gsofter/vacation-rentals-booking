import React from 'react'
import Axios from 'axios'
import Chathistory from './Chathistory';
import Pusher from 'pusher-js';

import 'react-toastify/dist/ReactToastify.css';
import Progress from 'react-progressbar';

let canPublish = true;
const throttleTime = 200; //0.2 seconds
const pusher = new Pusher('ccd81a8b36efcabe5a7b', {
    cluster: 'mt1',
    encrypted: true,
    disableStats: true ,
    auth: {
        headers: {
          'X-CSRF-Token': 'some_csrf_token'
        }
      }
});
class MessagePanel extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            is_open : true,
            message : '',
            chat_history : [],
            file : null,
            uploading_progress : 0,
            uploading : false,
            is_typing : false
        }
        this.chatKeyPress = this.chatKeyPress.bind(this)
        this.chatKeyChange = this.chatKeyChange.bind(this)
        this.openBox = this.openBox.bind(this)
        this.fileChange = this.fileChange.bind(this)
        this.handlePaste = this.handlePaste.bind(this)
        this.uploadFileFromClipboard = this.uploadFileFromClipboard.bind(this)
        this.handleSendMessage = this.handleSendMessage.bind(this)
    }
    componentDidMount(){
      
        Axios.get('/ajax/chat/getmessages?chat_id='+this.props.user_id+'&my_id='+this.props.my_id)
        .then(result=>{
            this.setState({chat_history : result.data});
        }, ()=>{
            var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
                chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;
        })
        const channel = pusher.subscribe('chat_' + this.props.my_id);
        const clearInterval = 900; //0.9 seconds
        var clearTimerId;
        channel.bind('message_read', data =>{
            console.log('Read Message ?', data)
            let chat_history = this.state.chat_history
            chat_history.forEach((history, index) => {
                if(history.id == data.message_id){
                    chat_history[index].final_read_chat = 1
                }
                else{
                    chat_history[index].final_read_chat = 0
                }
            });
        })
        channel.bind('is_typing', data =>{
            if(data.typing_user == this.props.contactUser.id){
                this.setState({
                    is_typing : true
                })
                let self = this
                clearTimeout(clearTimerId);
                clearTimerId = setTimeout(function () {
                  //clear user is typing message
                    self.setState({
                        is_typing : false
                    })
                }, clearInterval);
                
            }
        })
        channel.bind('App\\Events\\MessageSent', data => {
            let chat_history = this.state.chat_history
            if(data.message.message.sender_id == this.props.contactUser.id){
                chat_history.push(
                    data.message.message
                ) 
                if(this.props.isActive && this.state.is_open){
                    Axios.post('/ajax/chat/readMessage', {
                        message_id : data.message.message.id
                    })
                }
            }
            this.setState({
                chat_history : chat_history
              }, ()=>{
                if(this.props.isActive && this.state.is_open){
                    var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
                    chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;
                }
                
              })
        });
    }
    componentWillUnmount() {
      
        pusher.unsubscribe('chat_' + this.props.my_id);
        this.setState({
            is_open : false
        })

        // document.removeEventListener("click", this.closeMenu);
    }
    handlePaste(e){
        for (var i = 0 ; i < e.clipboardData.items.length ; i++) {
            var item = e.clipboardData.items[i];
            if (item.type.indexOf("image") != -1) {
                this.uploadFileFromClipboard(item.getAsFile());
            } else {
            }
        }
    }
    uploadFileFromClipboard(file){
        var formData  = new FormData();
        formData.append('files', file )
        formData.append('user_id', this.props.contactUser.id )
        formData.append('sender_id', this.props.my_id )
        axios.post( '/ajax/chat/fileupload', formData,  {
            onUploadProgress: progressEvent => {
                this.setState({
                    uploading_progress : progressEvent.loaded / progressEvent.total,
                    uploading : true
                })
            }
        }).then(result =>{
            this.setState({
                uploading : false,
                uploading_progress : 0,
                chat_history : result.data
            }, ()=>{
                var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
                chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;
            })
        }).catch((e)=>{
           this.setState({
                uploading : false,
                uploading_progress : 0
            }) 
        })
    }
    fileChange(e){
        e.preventDefault();
        let file = e.target.files[0]
        var formData  = new FormData();
        formData.append('files', file )
        formData.append('user_id', this.props.contactUser.id )
        formData.append('sender_id', this.props.my_id )
        axios.post( '/ajax/chat/fileupload', formData,  {
            onUploadProgress: progressEvent => {
                this.setState({
                    uploading_progress : progressEvent.loaded / progressEvent.total,
                    uploading : true
                })
            }
        }).then(result =>{
            this.setState({
                uploading : false,
                uploading_progress : 0,
                chat_history : result.data
            }, ()=>{
                var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
                chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;
            })
        }).catch((e)=>{
           this.setState({
                uploading : false,
                uploading_progress : 0
            }) 
        })
    }
    openBox(){
        this.setState({
            is_open : !this.state.is_open
        })
    }
    handleSendMessage(e){
        e.preventDefault()
        let chat_history = this.state.chat_history
        chat_history.push(
            { user_id : this.props.contactUser.id,
                sender_id : this.props.my_id,
                type : 'text',
                message : this.state.message, sender_profile_picture : this.props.my_profile_pic}
        ) 
        this.setState({
        
            chat_history : chat_history
          }, ()=>{
            //   setTimeout(3000)
            var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
            chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;

          })
       if(this.props.my_id ) {
            Axios.post('/ajax/chat/sendmessage', {
                user_id : this.props.contactUser.id,
                sender_id : this.props.my_id,
                message : this.state.message 
            }).then(result =>{
                this.setState({
                    chat_history : result.data
                })
            })
       }
       else{
           
       }
       this.setState({
        message :'' 
      })
    }
    chatKeyPress(e){
        if(e.key == 'Enter'){
            
          e.preventDefault()
            let chat_history = this.state.chat_history
            chat_history.push(
                { user_id : this.props.contactUser.id,
                    sender_id : this.props.my_id,
                    type : 'text',
                    message : this.state.message, sender_profile_picture : this.props.my_profile_pic}
            ) 
            this.setState({
            
                chat_history : chat_history
              }, ()=>{
                //   setTimeout(3000)
                var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
                chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;

              })
           if(this.props.my_id ) {
                Axios.post('/ajax/chat/sendmessage', {
                    user_id : this.props.contactUser.id,
                    sender_id : this.props.my_id,
                    message : this.state.message 
                }).then(result =>{
                    this.setState({
                        chat_history : result.data
                    })
                })
           }
           else{
               
           }
           this.setState({
            message :'' 
          })
        }
        else{
            if(canPublish) {
                Axios.post('/ajax/chat/isTyping', {user_id : this.props.contactUser.id, sender_id : this.props.my_id})
                canPublish = false;
                setTimeout(function() {
                  canPublish = true;
                }, throttleTime);
            }
        }
        this.props.onTyping()
      }
      chatKeyChange(e){
        this.setState({
          message : e.target.value
        })
      }
    render(){
        return <div className="message_content">
        <div className="contact-profile">
          <i className='fa fa-arrow-left back' onClick={this.props.openContact}></i>
          <img src={this.props.contactUser.profile_picture.src}   />
          <p>{this.props.contactUser.full_name}</p>
         
        </div>
        <div className="chat-messages"  id={'chat-messages_' + this.props.contactUser.id}>
        <Chathistory is_typing = {this.state.is_typing} chat_history= {this.state.chat_history} chatUser = {this.props.contactUser.id}/>
           {/* <ul className="chat-messages-lists" id="chat-messages-lists_10030"><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">hello</span><div className="corner" /></div><p><small>12:34, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">hey.</span><div className="corner" /></div><p><small>12:36, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">are you okay?</span><div className="corner" /></div><p><small>12:37, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">again?</span><div className="corner" /></div><p><small>12:37, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">again?</span><div className="corner" /></div><p><small>12:37, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">testing 1.</span><div className="corner" /></div><p><small>12:51, PM, 1Day Ago</small></p></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">okay</span><div className="corner" /></div><p><small>12:52, PM, 1Day Ago</small></p></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">okay?</span><div className="corner" /></div><p><small>12:52, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">hello</span><div className="corner" /></div><p><small>12:55, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">good</span><div className="corner" /></div><p><small>12:55, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">hello.</span><div className="corner" /></div><p><small>1:59, PM, 1Day Ago</small></p></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">okay.</span><div className="corner" /></div><p><small>1:59, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">are you with me?</span><div className="corner" /></div><p><small>2:0, PM, 1Day Ago</small></p></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">thank you.</span><div className="corner" /></div><p><small>2:0, PM, 1Day Ago</small></p></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">what is this?</span><div className="corner" /></div><p><small>2:0, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">??</span><div className="corner" /></div><p><small>2:0, PM, 1Day Ago</small></p></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">okay.</span><div className="corner" /></div><p><small>2:1, PM, 1Day Ago</small></p></div><div className="message right"><img src="http://localhost:90/images/users/10053/profile_pic_1525224773_225x225.jpg" /><div className="bubble"><span className="Linkify">good.</span><div className="corner" /></div><p><small>2:1, PM, 1Day Ago</small></p><div><i className="fa fa-user final_read_message" /></div></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">have good time.</span><div className="corner" /></div><p><small>2:1, PM, 1Day Ago</small></p></div><div className="message"><img src="http://localhost:90/images/user_pic-225x225.png" /><div className="bubble"><span className="Linkify">thank you.</span><div className="corner" /></div><p><small>2:2, PM, 1Day Ago</small></p></div></ul> */}
        </div>
        <div className="message-input">
        {
                        this.state.uploading ?
                        <Progress completed={this.state.uploading_progress * 100} />
                        :
                        null
                    }
                     {/* <Progress completed={100} /> */}
          <div className="wrap">
        
          <textarea onPaste={this.handlePaste} type="text"  placeholder="Send message..." value={this.state.message} onKeyPress={this.chatKeyPress} onChange={this.chatKeyChange} />
                
            <label htmlFor={"file"+this.props.contactUser.id} className='chat_file_upload_label'>
                    <i className='fa fa-file'></i>
                 </label>
                    <input onChange={this.fileChange} className='chat_file_upload' type='file' id={"file"+this.props.contactUser.id}/>
            <button className="button" onClick={this.handleSendMessage}><i className="fa fa-paper-plane" aria-hidden="true" /></button>
          </div>
        </div>
      </div>
        
    }
}
export default MessagePanel