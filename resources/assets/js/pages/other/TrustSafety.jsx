import React from 'react'
export default class TrustSafety extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render (){
        return  <div className="page-container-responsive">
        <div className="row-space-top-6 row-space-16 text-wrap">
          <h2 className="row-space-1">We stand behind every listing with a heavily vetted process ensuring accuracy and ownership.</h2><span style={{fontWeight: 'bold'}}>Verified ID</span><br /><br />Hosts must verify their IDs by connecting to their social networks and scanning their official ID or confirming personal details. <br /><br /><span style={{fontWeight: 'bold'}}>Profile &amp; Reviews</span><br /><br />Get to know your host through detailed profiles and confirmed reviews. <br /><br /><span style={{fontWeight: 'bold'}}>Messaging</span><br /><br />Use our messaging system to learn more about a host or ask a guest about their trip. <br /><br />
        </div>
      </div>
    }
}