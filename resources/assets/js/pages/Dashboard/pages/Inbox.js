import React from 'react'
import dateFns from "date-fns";
import { Link, Element , Events, animateScroll as scroll, scrollSpy, scroller } from 'react-scroll'
import Pusher from 'pusher-js';
import Axios from 'axios'
import {connect} from 'react-redux'
const metas = document.getElementsByTagName('meta');

import { hideChatBoxes, showChatBoxes} from '../../../actions/chatmodule/chatmoduleActions'
import Contacts from './components/inbox/Contacts';
import MessagePanel from './components/inbox/Contacts/MessagePanel';

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
class Inbox extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      isLogedIn: metas['isLogedin'].content,
      contacts : [],
      chatboxes : [],
      active_chatbox : null,
      show_chatbox : true,
      open_contact_list : false,
      notify_sound : false
    }
    this.activeContact = this.activeContact.bind(this)
    this.openChat = this.openChat.bind(this)
        this.archiveContact = this.archiveContact.bind(this)
        this.activeContact = this.activeContact.bind(this)
        this.blockContact = this.blockContact.bind(this)
        this.blockContact = this.blockContact.bind(this)
        this.unblockContact = this.unblockContact.bind(this)
        this.deleteContact = this.deleteContact.bind(this)
        this.activeChatBox = this.activeChatBox.bind(this)
        this.openContactList = this.openContactList.bind(this)


        this.notifySoundUrl = 'https://res.cloudinary.com/vacation-rentals/video/upload/v1554130121/audio/alarm.mp3'
        this.notifySound = new Audio(this.notifySoundUrl);
        
    }
    notify(){
     
      this.setState({ notify_sound: true  }, ()=>{
        this.notifySound.play();
        this.setState({ notify_sound: false  })
      })
      
    }
    activeChatBox(user_id){
        this.setState({
            active_chatbox : user_id
        })
    }
    archiveContact(contact_id){
      
      Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'archived', userId : metas['LogedUserId'].content})
      .then(result=>{
          this.setState({
              contacts : result.data
          })
          console.log(result)
      })
  }
  activeContact(contact_id){
      console.log(contact_id)
      Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'active', userId : metas['LogedUserId'].content})
      .then(result=>{
          this.setState({
              contacts : result.data
          })
          console.log(result)
      })
  }
  blockContact(contact_id){
      Axios.post('/ajax/chatcontact/updatestatus', {contactId : contact_id, status : 'blocked', userId : metas['LogedUserId'].content})
      .then(result=>{
          this.setState({
              contacts : result.data
          })
          console.log(result)
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
    openChat(user_id, openOnly = null){
        let chatboxes = this.state.chatboxes
        if(openOnly == 1){
            if(!chatboxes.includes(user_id)){
                chatboxes.push(user_id)
            }
        }
        else{
            if(chatboxes.includes(user_id)){
                var index = chatboxes.indexOf(user_id);
                if (index > -1) {
                    chatboxes.splice(index, 1);
                 }
            }
            else{
                chatboxes.push(user_id)
                this.setState({
                    active_chatbox : user_id
                })
            }
        }
        this.setState({
            chatboxes : chatboxes
        })
        // console.log(user_id)
    }
  componentWillUnmount(){
    this.props.showChatBoxes()
    pusher.unsubscribe('chat_' + metas['LogedUserId'].content);
  }
  componentDidMount(){
    if(this.state.isLogedIn == 'true'){
      Axios.get('/ajax/chat/getcontactlists?userId=' +  metas['LogedUserId'].content)
      .then(result=>{
          this.setState({
              contacts : result.data,

          })
          this.props.hideChatBoxes()
      })
    }
    const channel = pusher.subscribe('chat_' + metas['LogedUserId'].content);
    channel.bind('App\\Events\\MessageSent', data => {
      if(data.message.message.sender_id != this.state.active_contact){
        let self = this
        const playPromise = this.notifySound.play();
        if (playPromise !== null){
            playPromise.catch(() => {  self.notifySound.play(); })
        }
      }
    });

  }
 
  activeContact(contact_id){
    if(this.state.open_contact_list){
      this.setState({
        open_contact_list : !this.state.open_contact_list,
        active_contact : contact_id
      })
    }
    else{
      this.setState({
        // open_contact_list : !this.state.open_contact_list,
        active_contact : contact_id
      })
    }
  }
  openContactList(){
    this.setState({
      open_contact_list : !this.state.open_contact_list,
    })
  }
  render() {
    let contactUser = {}
    return (
      <div className='inbox_chat'>
        <Contacts  is_open={this.state.open_contact_list} activeContact = { (contactId) =>this.activeContact(contactId)}
        contacts = {this.state.contacts} 
      
        active={this.activeContact} 
        archive = {this.archiveContact} 
        block={this.blockContact} 
        unblock = {this.unblockContact}
        delete = {this.deleteContact}
        />
       
         {
           this.state.active_contact ? 
           this.state.contacts.map((contact) =>{
          
            if(contact.id == this.state.active_contact){
             
               return <MessagePanel openContact={() => this.openContactList()}  isActive = {this.state.active_contact == contact.id} onTyping={()=>this.activeChatBox(contact.id)} contactUser={contact} my_id = {metas['LogedUserId'].content} my_profile_pic = {metas['userProfilePic'].content} user_id = {contact.id} openChat={()=>this.openChat(contact.id)}/>
            }
          })
           
           :
           (
             this.state.contacts.length ?
             <MessagePanel openContact={() => this.openContactList()}  isActive = {this.state.active_contact == this.state.contacts[0].id} onTyping={()=>this.activeChatBox(this.state.contacts[0].id)} contactUser={this.state.contacts[0]} my_id = {metas['LogedUserId'].content} my_profile_pic = {metas['userProfilePic'].content} user_id = {this.state.contacts[0].id} openChat={()=>this.openChat(this.state.contacts[0].id)}/>
             : null
           )
         }
        
        
      </div>
    )
  }
}
const mapStateToProps = state =>({
  ...state
})
const mapDispatchToProps = dispatch =>({
  hideChatBoxes : () => dispatch(hideChatBoxes()) ,
  showChatBoxes : () => dispatch(showChatBoxes()) ,
  // renderStopSidebarAction : () => dispatch(renderStopSidebarAction) 
})
export default connect(mapStateToProps, mapDispatchToProps)(Inbox)
// export default Inbox