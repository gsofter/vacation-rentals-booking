import React from 'react'
import ContactItem from './ContactItem';
class ContactList extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            keyword : '',
            is_open : true
        }
        this.searchUserByKey = this.searchUserByKey.bind(this)
        this.openBox = this.openBox.bind(this)
    }
    searchUserByKey(e){
        this.setState({
            keyword : e.target.value
        })
    }
    openBox(){
        this.setState({
            is_open : !this.state.is_open
        })
    }
    render(){
    
        
        return   <ul className="body-main-con-mid">
                {this.props.contacts.map((contact, index) =>{
                     
                        if(contact.status == 'active' && (contact.full_name.toLowerCase().includes(this.state.keyword.toLowerCase()) ||contact.email.toLowerCase().includes(this.state.keyword.toLowerCase()) )){
                            return <ContactItem keyword={this.setState.keyword}  key={index} contact={contact} 
                            delete={()=>this.props.delete(contact.contact_id)} 
                            openChat = {()=>this.props.openChat(contact.id)} 
                            archive={()=>this.props.archive(contact.contact_id)} 
                            active={()=>this.props.active(contact.contact_id)} 
                            block={()=>this.props.block(contact.contact_id)}  
                            unblock={()=>this.props.unblock(contact.contact_id)}/>
                        }
                        
                    })}
                   </ul> 
               
    }
}
export default ContactList