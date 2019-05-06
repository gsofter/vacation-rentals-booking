import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import './title.css';


class Title extends React.Component {
   
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Set Your Listing Location</h1>
                    <p>You’re not only sharing your space, you’re sharing your neighborhood. Travelers will use this information to find a place that’s in the right spot.</p>
                </div>
                <div className="content_right">
                    
                    <a href={`/rooms/manage-listing/${this.props.roomId}/description`} className="right_save" >Back</a>
                    <a href={`/rooms/manage-listing/${this.props.roomId}/amenities`} className="right_save_continue" >Next</a>
                    
                </div>
            </div>
        );
    }
}

export default Title;