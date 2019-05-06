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
class UserChatBox extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            is_open : true,
            message : '',
            chat_history : [],
            file : null,
            uploading_progress : 0,
            uploading : false,
            is_typing : false,
            kbactive : false
        }
        this.chatKeyPress = this.chatKeyPress.bind(this)
        this.chatKeyChange = this.chatKeyChange.bind(this)
        this.openBox = this.openBox.bind(this)
        this.fileChange = this.fileChange.bind(this)
        this.handlePaste = this.handlePaste.bind(this)
        this.uploadFileFromClipboard = this.uploadFileFromClipboard.bind(this)
        this.handleSendMessage = this.handleSendMessage.bind(this)
        this.handleTogglekbactive = this.handleTogglekbactive.bind(this)
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
                var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
                chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;
                
              })
        });
    }
    componentDidUpdate(prevProps, prevState){
        console.log('Track1',prevProps, prevState)
        if(prevState.chat_history.length == 0){
            this.chatBodyScrollTop()
        }
        // 
    }
    componentWillUnmount() {
        // const pusher = new Pusher('ccd81a8b36efcabe5a7b', {
        //     cluster: 'mt1',
        //     encrypted: true
        // });
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
    chatBodyScrollTop(){
        var chatDiv = document.getElementById('chat-messages_' + this.props.contactUser.id);
        chatDiv.scrollTop = document.getElementById('chat-messages-lists_' + this.props.contactUser.id).clientHeight;

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
      handleTogglekbactive(){
          this.setState({
              kbactive : !this.state.kbactive
          })
      }
    render(){
        return <div className="body-main-chat">
        <div className="body-expand-header">
          <div className="body-expand-back">
            <button onClick={this.props.closeChatBox}><i className="fas fa-chevron-left" /></button>
          </div>
          <div className="body-expand-team">
            <div className="body-expand-teamimg">
              <img src={this.props.contactUser.profile_picture.src} alt />
            </div>
            <div className="body-expand-teamname">
              <h4>{this.props.contactUser.full_name}</h4>
              <p> {this.props.contactUser.live}</p>
            </div>
          </div>
        </div>
        <div className="body-conversation-middle"  id={'chat-messages_' + this.props.contactUser.id}>
        <Chathistory is_typing = {this.state.is_typing} chat_history= {this.state.chat_history} chatUser = {this.props.contactUser.id}/>
         
         
        </div>
        <div className="body-conversation-footer">
        {
                        this.state.uploading ?
                        <Progress completed={this.state.uploading_progress * 100} />
                        :
                        null
                    }
          <div className={ this.state.kbactive ? "body-conversation-inner " : "body-conversation-inner kbactive"} onClick={this.handleTogglekbactive}>
          
            <textarea  onPaste={this.handlePaste} type="text" className='chatinput' placeholder="Send message..." value={this.state.message} onKeyPress={this.chatKeyPress} onChange={this.chatKeyChange} />
            <div className="body-conversation-button">
              <div className="body-button-upload">
                <label  htmlFor={"file"+this.props.contactUser.id}><i className="fas fa-link" /></label>
                <input   type="file" onChange={this.fileChange} id={"file"+this.props.contactUser.id} />
              </div>
              <div className="body-conversation-submit">
                <button type="button" onClick={this.handleSendMessage}><i className="fas fa-paper-plane" /></button>
              </div>
            </div>
          </div>
        </div>
      </div>
        return <div className={this.state.is_open ? "xwb-chat xwb-cb-chat  " : "xwb-chat xwb-cb-chat chatbox-tray"} data-user="4|3|2">
        <div className="title" >
           <h5 className="conversation-title" onClick={this.openBox}>
           <a href="javascript:;">{this.props.contactUser.full_name}</a></h5>
           <button className="chatbox-title-tray" onClick={this.openBox}><span />
           </button>
           <button className="chatbox-title-close" onClick={this.props.openChat}>
              <span>
                 <svg viewBox="0 0 12 12" width="12px" height="12px">
                    <line stroke="#FFFFFF" x1="11.75" y1="0.25" x2="0.25" y2="11.75" />

                    <line stroke="#FFFFFF" x1="11.75" y1="11.75" x2="0.25" y2="0.25" />

                 </svg>
              </span>
           </button>
        </div>
        <div className="cb-conversation-container" data-users="4|3|2" data-cnid={3}>

        <div className="conversation-container message-inner chat-messages " id={'chat-messages_' + this.props.contactUser.id}>
        <Chathistory is_typing = {this.state.is_typing} chat_history= {this.state.chat_history} chatUser = {this.props.contactUser.id}/>
         
        </div>
        <div className="chatbox">
                 <textarea onPaste={this.handlePaste} type="text" className='chatinput' placeholder="Send message..." value={this.state.message} onKeyPress={this.chatKeyPress} onChange={this.chatKeyChange} />
                 {
                        this.state.uploading ?
                        <Progress completed={this.state.uploading_progress * 100} />
                        :
                        null
                    }
                 <label htmlFor={"file"+this.props.contactUser.id} className='chat_file_upload_label'>
                    <i className='fa fa-file'></i>
                 </label>
                    <input onChange={this.fileChange} className='chat_file_upload' type='file' id={"file"+this.props.contactUser.id}/>
              </div>
           </div>
        </div>

    }
}
export default UserChatBox