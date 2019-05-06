import React from 'react'

class ContactItem extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
      return <li className="main-con-list"  onClick={this.props.openChat}>
      <div className="con-list-left">
        <div className="list-img">
          <img src={this.props.contact.profile_picture.src}   />
        </div>
      </div>
      <div className="con-list-right">
        <div className="con-list-meta">
          <div className="con-list-body-author"> <strong> {this.props.contact.full_name}</strong></div>
          <div className="con-list-body-timestamp">
          {this.props.contact.live}</div>
        </div>
        <div className="con-list-content">
          <div className="con-list-in">
            <span className="con-list-in-l">Email:</span>
            <div className="con-listi-in-r"> {this.props.contact.email}
            </div>
          </div>
          <div className="con-list-in">
            <span className="con-list-in-l">Phone:</span>
            <div className="con-listi-in-r"> {this.props.contact.primary_phone_number}
            </div>
          </div>
        </div>
      </div>
    </li>
        return <li className='list-group-item cs-list-users offline'>
        <a  className='float-left' onClick={this.props.openChat}>
            <span className='image'>
            <img src={this.props.contact.profile_picture.src} width='32px' />
            </span>
            <span className='xwb-display-name'>
            {this.props.contact.full_name}
            </span>
            
            {/* <p className='text-truncate'> {this.props.contact.email}</p>  */}
        </a>
        <div className="dropdown float-right">
        <a   className="dropdown-toggle" data-toggle="dropdown">
         <i className='fa fa-ellipsis-h'></i>
        </a>
        <div className="dropdown-menu">
          <a className="dropdown-item" onClick={this.props.contact.status == 'active' ? this.props.archive : this.props.active}>{this.props.contact.status == 'active' ? 'Archive' : 'Active'}</a>
          {this.props.contact.status != 'blocked' ? <a className="dropdown-item" onClick={this.props.block}>Block</a> : null}
          {this.props.contact.status == 'blocked' ? <a className="dropdown-item" onClick={this.props.unblock}>UnBlock</a> : null}
          <a className="dropdown-item" onClick={this.props.delete}>Delete</a>
          {/* <a className="dropdown-item" onClick={this.props}>Link 3</a> */}
        </div>
      </div>
        </li>
    //     return <div className="profil">
    //     <div className="pfoto">
    //     <img src={this.props.contact.profile_picture.src} />
    //     </div>
    //     <div className="mesaj" onClick={this.props.openChat}>
    //      <span className='username'>{this.props.contact.full_name}</span>
    //       {/* <span className="right">19:06</span> */}
    //         <br />
    //         <p className='text-truncate'> {this.props.contact.email}</p> 
    //     </div>
    //     <div className="temizle" />
    // </div>
    }
}
export default ContactItem