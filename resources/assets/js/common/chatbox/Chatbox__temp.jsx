import React from 'react'
import ContactList from './ConatactList';
import Axios from 'axios'
import './styles/chatboxcontainer.scss'
import UserChatBox from './UserChatBox';
const metas = document.getElementsByTagName('meta');
class Chatbox extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            isLogedIn: metas['isLogedin'].content,
            contacts : [],
            chatboxes : []
        }
        this.openChat = this.openChat.bind(this)
    }
    openChat(user_id){
        let chatboxes = this.state.chatboxes
        if(chatboxes.includes(user_id)){
            var index = chatboxes.indexOf(user_id);
            if (index > -1) {
                chatboxes.splice(index, 1);
             }
        }
        else{
            chatboxes.push(user_id)
        }
        this.setState({
            chatboxes : chatboxes
        })
        // console.log(user_id)
    }
    componentDidMount(){
        if(this.state.isLogedIn == 'true'){
            Axios.get('/ajax/chat/getcontactlists?userId=' +  metas['LogedUserId'].content)
            .then(result=>{
                this.setState({
                    contacts : result.data
                })
                console.log(result)
            })
        }
        
    }
    render(){
        console.log(this.state.chatboxes)
        if(this.state.isLogedIn == 'true')
            return (<div className='chatbox_container'>
                <ContactList contacts = {this.state.contacts} openChat={this.openChat}/>
                {this.state.chatboxes.map((user_id, index) =>{

                    return <UserChatBox key={index} user_id = {user_id}/>
                })}
            </div>)
        else return null
    }
    
}
export default Chatbox
