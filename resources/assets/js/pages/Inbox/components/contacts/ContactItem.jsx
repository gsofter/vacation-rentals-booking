import React from 'react'

class ContactItem extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        return <li className={this.props.is_open == this.props.contact.id ? 'active' : ''} onClick={this.props.activeContact}>
        <div className="s-user-left">
          <div className="s-user-avator">
            <small className="status online">&nbsp;</small>
            <img src={this.props.contact.profile_picture.src}   />
          </div>
          <div className="s-user-name">
            <p className="s-u-name">{this.props.contact.full_name}</p>
            <span className="s-up-mdg">{this.props.contact.email}</span>
          </div>
        </div>
        <div className="s-right-noti">
          {/* <span className="s-time">3.22am</span> */}
          {/* <span className="s-noti">3</span> */}
        </div>
      </li>
    }
}
export default ContactItem