import React from 'react'
import Popup from 'reactjs-popup'
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';


const Card = () => (
      <div className="w-100 mail-popup">
      
        <div className="panel-header no-border section-header-home"><strong><span>Messages</span></strong>
          <a href="/dashboard/inbox" className="link-reset view-trips pull-right"><span>View Inbox</span></a>
        </div>
        <div className="panel-header no-border section-header-home pull-left" style={{width: '100%'}}><strong><span>Notifications</span></strong>
          <a href="/dashboard" className="link-reset view-trips pull-right"><span>View Dashboard</span></a>
        </div>
        <div className="pull-left text-center w-100" style={{padding: '15px 20px'}}>
          <p style={{margin: '0px', paddingTop: '10px !important'}}> There are no notifications waiting for you in your 
          <a href="#" style={{color: '#333', textDecoration: 'underline'}}>Dashboard</a>
          .</p>
        </div>
      </div>
)

const TooltipMail = () => (
    <Popup
      trigger={<a   to="/dashboard/inbox">Mail
        {/* <img src="https://arimitin.sirv.com/Images/mail.png" width="26" height="26" alt="" /> */}
        <span className="sr-only">(current)</span></a>
        }
      position="bottom center"
      on="hover"
    >
      <Card/>
    </Popup>
)

export default TooltipMail;