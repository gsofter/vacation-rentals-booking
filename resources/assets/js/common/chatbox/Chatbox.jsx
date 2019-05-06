import React from 'react'


import ContactList from './ConatactList';
import Axios from 'axios'
import {connect} from 'react-redux'
import UserChatBox from './UserChatBox';
import {openChatBoxAction} from '../../actions/chatmodule/chatmoduleActions'
const metas = document.getElementsByTagName('meta');
import { toast, ToastContainer } from 'react-toastify';
import Pusher from 'pusher-js';

const pusher = new Pusher('ccd81a8b36efcabe5a7b', {
  cluster: 'mt1',
  encrypted: true,
  auth: {
      headers: {
          'X-CSRF-Token': 'some_csrf_token'
      }
  },
  disableStats: true 
});
class Chatbox extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            isLogedIn: metas['isLogedin'].content,
            contacts : [],
            chatbox : null,
            active_chatbox : null,
            show_chatbox : true,
            open_chat_box : false
        }
        this.openChat = this.openChat.bind(this)
        this.closeChatBox = this.closeChatBox.bind(this)
        this.handleBoxOpen = this.handleBoxOpen.bind(this)
        this.archiveContact = this.archiveContact.bind(this)
        this.activeContact = this.activeContact.bind(this)
        this.blockContact = this.blockContact.bind(this)
        this.blockContact = this.blockContact.bind(this)
        this.unblockContact = this.unblockContact.bind(this)
        this.deleteContact = this.deleteContact.bind(this)
        this.activeChatBox = this.activeChatBox.bind(this)
        this.notifySoundUrl = 'https://res.cloudinary.com/vacation-rentals/video/upload/v1554130121/audio/alarm.mp3'
        this.notifySound = new Audio(this.notifySoundUrl);
    }
    activeChatBox(user_id){
        this.setState({
            active_chatbox : user_id
        })
    }
    openChat(user_id, openOnly = null){
        let contactUser = null 
      this.state.contacts.map(contact =>{

        if(contact.id == user_id){
          contactUser  = contact
        }
      })
        this.setState({
          chatbox : user_id,
          contactUser : contactUser,
          open_chat_box : true,
          show_chatbox : true
        })
        // console.log(user_id)
    }
    closeChatBox(){
      this.setState({
        chatbox : null
      })
    }
    componentWillReceiveProps(nextprops){

         
        if(nextprops.chatmoduleReducer ){
            console.log('hello')
            if(nextprops.chatmoduleReducer.is_show !== 'undefined' && nextprops.chatmoduleReducer.is_show == true){
                document.getElementById('footer').style.display = 'block'
                this.setState({
                    show_chatbox : true
                }, ()=>{
                })
            }
            else{
              document.getElementById('footer').style.display = 'none'
              this.setState({
                  show_chatbox : false,
                  open_chat_box : false
              }, ()=>{
              })
          }
          if(nextprops.chatmoduleReducer.contactId){
            console.log('open chat tracking', nextprops.chatmoduleReducer.contactId)
            Axios.get('/ajax/chat/getcontactlists?userId=' +  metas['LogedUserId'].content)
            .then(result=>{
                this.setState({
                    contacts : result.data
                }, ()=>{
                    let contactId = nextprops.chatmoduleReducer.contactId
                    let contacts = this.state.contacts
                    contacts.map((contact)=>{
                        if(contact.contact_id == contactId){
                            this.setState({
                              open_chat_box : true,
                              show_chatbox : true
                            }, ()=>{
                              this.openChat(contact.id, 1)
                            })
                            
                        }
                    })
                })
            })
          }
        }
    }
    archiveContact(contact_id){
        Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'archived', userId : metas['LogedUserId'].content})
        .then(result=>{
            this.setState({
                contacts : result.data
            })
        })
    }
    activeContact(contact_id){
        console.log(contact_id)
        Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'active', userId : metas['LogedUserId'].content})
        .then(result=>{
            this.setState({
                contacts : result.data
            })
        })
    }
    blockContact(contact_id){
        Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'blocked', userId : metas['LogedUserId'].content})
        .then(result=>{
            this.setState({
                contacts : result.data
            })
        })
    }
    unblockContact(contact_id){
        Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'active', userId : metas['LogedUserId'].content})
        .then(result=>{
            this.setState({
                contacts : result.data
            })
        })
    }
    deleteContact(contact_id){
        Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'removed', userId : metas['LogedUserId'].content})
        .then(result=>{
            this.setState({
                contacts : result.data
            })
        })
    }
    componentDidMount(){
        if(this.state.isLogedIn == 'true'){
            Axios.get('/ajax/chat/getcontactlists?userId=' +  metas['LogedUserId'].content)
            .then(result=>{
                this.setState({
                    contacts : result.data
                })
            })
            const channel = pusher.subscribe('chat_' + metas['LogedUserId'].content);
            channel.bind('App\\Events\\MessageSent', data => {
                if (data.message.message.sender_id != this.state.active_contact) {
                    toast.success('You received new message from ' + data.message.message.sender.full_name)
                    let self = this
                    const playPromise = this.notifySound.play();
                    if (playPromise !== null) {
                        playPromise.catch(() => { self.notifySound.play(); })
                    }
                }
            });
        }
    }
    componentWillUnmount(){
      pusher.unsubscribe('chat_' + metas['LogedUserId'].content);
    }
    handleBoxOpen(){
        this.setState({
            open_chat_box : !this.state.open_chat_box
        })
    }
    render(){
        if(this.state.isLogedIn == 'true' && this.state.show_chatbox == true)
            return <div className="chat-box_">
            <ToastContainer/>
            <div className={(this.state.open_chat_box ? "chat-window chat-window-open" : "chat-window") + (this.state.chatbox ? ' inner-open' : '') }>
              <div className="chat-conversation">
                <div className="chat-head">
                  <div>
                    <div className="chat-head-view-enter">
                      <div className="chat-head-view-head">
                        <h3>Hi there 👋</h3>
                        <p>Helping Vacation.Rentals Owners Property Managers for Over 5 Years. Got a
                          Question? Or Just Saying Hi? Send us a Message.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="chat-body">
                  <div className="body-fixed">
                    <div className="body-main">
                      <div className="body-main-wrap">
                        <div className="body-main-card">
                          <div className="body-main-conve">
                            <div>
                              <div className="body-main-content">
                                <div className="body-main-con">
                                <ContactList contacts = {this.state.contacts} 
                                    openChat={this.openChat}
                                    active={this.activeContact} 
                                    archive = {this.archiveContact} 
                                    block={this.blockContact} 
                                    unblock = {this.unblockContact}
                                    delete = {this.deleteContact}
                                />
                                </div>
                              </div>
                            </div>
                            <div className="body-main-footer">
                              
                                <a className="btn btn-outline-primary" href="/inbox"><i className="far fa-paper-plane" /> Go to Inbox </a>
                            </div>
                          </div>
                          {
                            (this.state.chatbox && (
                                <UserChatBox closeChatBox={this.closeChatBox}   isActive = {1} onTyping={()=>this.activeChatBox(this.state.contactUser.id)} contactUser={this.state.contactUser} my_id = {metas['LogedUserId'].content} my_profile_pic = {metas['userProfilePic'].content} user_id = {this.state.chatbox} openChat={()=>this.openChat(this.state.chatbox)}/>
                            ))
                          }
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className={this.state.open_chat_box ? "chat-footer open" : "chat-footer"} onClick={this.handleBoxOpen}>
              <i className="fas fa-comment-alt" />
              <i className="fas fa-times" />
            </div>
          </div>
          
        else return null
    }
    
}

const mapStateToProps = state =>({
    ...state
  })
  const mapDispatchToProps = dispatch =>({
    openChatBoxAction : () => dispatch(openChatBoxAction) 
  })
  export default connect(mapStateToProps, mapDispatchToProps)(Chatbox)
