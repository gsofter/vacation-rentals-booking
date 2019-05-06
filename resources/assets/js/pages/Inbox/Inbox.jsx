import React from 'react'
import dateFns from "date-fns";
import { Link, Element, Events, animateScroll as scroll, scrollSpy, scroller } from 'react-scroll'
import Pusher from 'pusher-js';
import Axios from 'axios'
import { connect } from 'react-redux'
const metas = document.getElementsByTagName('meta');

import { hideChatBoxes, showChatBoxes } from '../../actions/chatmodule/chatmoduleActions'
import Contacts from './components/Contacts';
import ChatContainer from './components/ChatContainer'
import ContactProfile  from './components/ContactProfile'
import { toast, ToastContainer } from 'react-toastify';
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



// import './styles/inbox.scss'
class Inbox extends React.PureComponent {
    constructor(props) {
        super(props)
        this.state = {
            isLogedIn: metas['isLogedin'].content,
            contacts: [],
            chatboxes: [],
            active_chatbox: null,
            show_chatbox: true,
            open_contact_list: false,
            notify_sound: false,
            is_left_sidebar_open : true,
            is_right_sidebar_open : true,
            contactFirstUser : {}
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
        this.handleLeftSidebar = this.handleLeftSidebar.bind(this)
        this.handleRightSidebar = this.handleRightSidebar.bind(this)
        this.handleOverlayClick = this.handleOverlayClick.bind(this)


        this.notifySoundUrl = 'https://res.cloudinary.com/vacation-rentals/video/upload/v1554130121/audio/alarm.mp3'
        this.notifySound = new Audio(this.notifySoundUrl);

    }
    notify() {

        this.setState({ notify_sound: true }, () => {
            this.notifySound.play();
            this.setState({ notify_sound: false })
        })

    }
    activeChatBox(user_id) {
        this.setState({
            active_chatbox: user_id,
         
        })
    }
    archiveContact(contact_id) {

        Axios.post('/ajax/chatcontact/updatestatus', { contactId: contact_id, status: 'archived', userId: metas['LogedUserId'].content })
            .then(result => {
                this.setState({
                    contacts: result.data,
                    
                })
                console.log(result)
            })
    }
    activeContact(contact_id) {
        console.log(contact_id)
        Axios.post('/ajax/chatcontact/updatestatus', { contactId: contact_id, status: 'active', userId: metas['LogedUserId'].content })
            .then(result => {
                this.setState({
                    contacts: result.data,
                  
                })
                console.log(result)
            })
    }
    blockContact(contact_id) {
        Axios.post('/ajax/chatcontact/updatestatus', { contactId: contact_id, status: 'blocked', userId: metas['LogedUserId'].content })
            .then(result => {
                this.setState({
                    contacts: result.data
                })
                console.log(result)
            })
    }
    unblockContact(contact_id) {
        Axios.post('/ajax/chatcontact/updatestatus', { contactId: contact_id, status: 'active', userId: metas['LogedUserId'].content })
            .then(result => {
                this.setState({
                    contacts: result.data
                })

            })
    }
    deleteContact(contact_id) {
        Axios.post('/ajax/chatcontact/updatestatus', { contactId: contact_id, status: 'removed', userId: metas['LogedUserId'].content })
            .then(result => {
                this.setState({
                    contacts: result.data
                })

            })
    }
    openChat(user_id, openOnly = null) {
        let chatboxes = this.state.chatboxes
        if (openOnly == 1) {
            if (!chatboxes.includes(user_id)) {
                chatboxes.push(user_id)
            }
        }
        else {
            if (chatboxes.includes(user_id)) {
                var index = chatboxes.indexOf(user_id);
                if (index > -1) {
                    chatboxes.splice(index, 1);
                }
            }
            else {
                chatboxes.push(user_id)
                this.setState({
                    active_chatbox: user_id
                })
            }
        }
        this.setState({
            chatboxes: chatboxes
        })
        // console.log(user_id)
    }
    componentWillUnmount() {
        // alert('Hello')
        this.props.showChatBoxes()
        pusher.unsubscribe('chat_' + metas['LogedUserId'].content);
    }
    componentDidMount() {
        // alert('Hello')
        if (this.state.isLogedIn == 'true') {
            this.props.hideChatBoxes()
            Axios.get('/ajax/chat/getcontactlists?userId=' + metas['LogedUserId'].content)
                .then(result => {
                    let contactFirstUser = null
                    let flag = false
                    result.data.map((contact, index) =>
                    {
                        if(contact.status == 'active' && !flag) {
                            contactFirstUser = contact;
                            flag = true
                         }
                    })
                    this.setState({
                        contacts: result.data,
                        contactFirstUser : contactFirstUser
                    })
                    
                   
                })
        }
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

    activeContact(contact_id) {
        console.log(contact_id)
        if (this.state.open_contact_list) {
            this.setState({
                open_contact_list: !this.state.open_contact_list,
                active_contact: contact_id,
                is_right_sidebar_open : true,
                is_left_sidebar_open : true
            })
        }
        else {
            this.setState({
                // open_contact_list : !this.state.open_contact_list,
                active_contact: contact_id,
                is_right_sidebar_open : true,
                is_left_sidebar_open : true
            })
        }
    }
    openContactList() {
        this.setState({
            open_contact_list: !this.state.open_contact_list,
            is_right_sidebar_open : true,
            is_left_sidebar_open : true
        })
    }
    handleLeftSidebar(){
        this.setState({
            is_left_sidebar_open : !this.state.is_left_sidebar_open
        })
    }
    handleRightSidebar(){
        this.setState({
            is_right_sidebar_open : !this.state.is_right_sidebar_open
        })
    }
    handleOverlayClick(){
        this.setState({
            is_right_sidebar_open : true,
            is_left_sidebar_open : true

        })
    }
   
    render() {
        
        

        return <div className={"inbox_" + (this.state.is_left_sidebar_open ? '' : ' open-left') + (this.state.is_right_sidebar_open ? '' : ' open-right')}>
        <ToastContainer/>
            <div className="inbox-wrapper">
                <div className="overlay" onClick={this.handleOverlayClick} />
                <Contacts is_open={this.state.open_contact_list} activeContact={(contactId) => this.activeContact(contactId)}
                    contacts={this.state.contacts}

                    active={this.activeContact}
                    archive={this.archiveContact}
                    block={this.blockContact}
                    unblock={this.unblockContact}
                    delete={this.deleteContact} />

                {
                    this.state.active_contact ?
                        this.state.contacts.map((contact) => {

                            if (contact.id == this.state.active_contact) {

                                return <ChatContainer handleRightSidebar={this.handleRightSidebar} handleLeftSidebar={this.handleLeftSidebar} openContact={() => this.openContactList()} isActive={this.state.active_contact == contact.id} onTyping={() => this.activeChatBox(contact.id)} contactUser={contact} my_id={metas['LogedUserId'].content} my_profile_pic={metas['userProfilePic'].content} user_id={contact.id} openChat={() => this.openChat(contact.id)} />
                            }
                        })

                        :
                        (
                            this.state.contacts.length ?
                                <ChatContainer handleRightSidebar={this.handleRightSidebar} handleLeftSidebar={this.handleLeftSidebar} openContact={() => this.openContactList()} isActive={this.state.active_contact == this.state.contactFirstUser.id} onTyping={() => this.activeChatBox(this.state.contactFirstUser.id)} contactUser={this.state.contactFirstUser} my_id={metas['LogedUserId'].content} my_profile_pic={metas['userProfilePic'].content} user_id={this.state.contactFirstUser.id} openChat={() => this.openChat(this.state.contactFirstUser.id)} />
                                : null
                        )
                }
                {
                    this.state.active_contact ?
                        this.state.contacts.map((contact) => {

                            if (contact.id == this.state.active_contact) {

                                return <ContactProfile openContact={() => this.openContactList()} isActive={this.state.active_contact == contact.id} onTyping={() => this.activeChatBox(contact.id)} contactUser={contact} my_id={metas['LogedUserId'].content} my_profile_pic={metas['userProfilePic'].content} user_id={contact.id} openChat={() => this.openChat(contact.id)} />
                            }
                        })

                        :
                        (
                            this.state.contacts.length ?
                                <ContactProfile openContact={() => this.openContactList()} isActive={this.state.active_contact == this.state.contactFirstUser.id} onTyping={() => this.activeChatBox(this.state.contactFirstUser.id)} contactUser={this.state.contactFirstUser} my_id={metas['LogedUserId'].content} my_profile_pic={metas['userProfilePic'].content} user_id={this.state.contactFirstUser.id} openChat={() => this.openChat(this.state.contactFirstUser.id)} />
                                : null
                        )
                }
               
            </div>
        </div>
    }
}

const mapStateToProps = state => ({
    ...state
})
const mapDispatchToProps = dispatch => ({
    hideChatBoxes: () => dispatch(hideChatBoxes()),
    showChatBoxes: () => dispatch(showChatBoxes()),
    // renderStopSidebarAction : () => dispatch(renderStopSidebarAction) 
})
export default connect(mapStateToProps, mapDispatchToProps)(Inbox)