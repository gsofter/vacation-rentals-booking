import React from 'react'

class ContactItem extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        return <li className="contact"  onClick={this.props.activeContact}>
        <div className="wrap">
          <span className="contact-status online" />
          <img src={this.props.contact.profile_picture.src}   />
          <div className="meta">
            <p className="name">{this.props.contact.full_name}</p>
            <p className="preview">{this.props.contact.email}</p>
          </div>
        </div>
      </li>
    
    }
}
export default ContactItem