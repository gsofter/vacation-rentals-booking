import React from 'react'
import ContactItem from './Contacts/ContactItem'
class Contacts extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            keyword : '',
            is_open : true,
            contactStatus : 'active'
        }
        this.searchUserByKey = this.searchUserByKey.bind(this)
        this.changeStatus = this.changeStatus.bind(this)    
    }

    searchUserByKey(e){
        this.setState({
            keyword : e.target.value
        })
    }
    
    changeStatus(status){
      this.setState({
        contactStatus : status
      })
    }
   
    handleContactClick(){
        
        this.props.activeContact()
    }
    render(){
        return <div id="sidepanel" className={this.props.is_open ? 'open' : ''}>
 
        <div id="search">
          <label htmlFor><i className="fa fa-search" aria-hidden="true" /></label>
          <input type="text" placeholder="Search contacts..."  value={this.state.keyword} onChange={this.searchUserByKey}  />
        </div>
        <div id="contacts">
          <ul>
          {this.props.contacts.map((contact, index) =>{
                     
                     if(contact.status == this.state.contactStatus && (contact.full_name.toLowerCase().includes(this.state.keyword.toLowerCase()) ||contact.email.toLowerCase().includes(this.state.keyword.toLowerCase()) )){
                         return <ContactItem keyword={this.setState.keyword}  key={index} contact={contact} 
                         is_open = {this.props.is_open}
                         delete={()=>this.props.delete(contact.contact_id)} 
                         activeContact = {()=>this.props.activeContact(contact.id)} 
                         archive={()=>this.props.archive(contact.contact_id)} 
                         active={()=>this.props.active(contact.contact_id)} 
                         block={()=>this.props.block(contact.contact_id)}  
                         unblock={()=>this.props.unblock(contact.contact_id)}/>
                     }
                     
                 })}
             
          </ul>
        </div>
        <div id="bottom-bar">
          <button onClick={()=>this.changeStatus('active')}  >  <span>Active</span></button>
          <button onClick={()=>this.changeStatus('archived')}  >  <span>Archived</span></button>
          <button onClick={()=>this.changeStatus('blocked')} >  <span>Blocked</span></button>
        </div>
      </div>
    }
}
export default Contacts