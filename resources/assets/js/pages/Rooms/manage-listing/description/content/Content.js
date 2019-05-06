import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import './content.css';


class Content extends React.Component {
   
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Tell Travelers About Your Space</h1>
                    <p>Every space on Vacation.Rentals----- is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.</p>
                </div>
                <div className="content_right">
                    <a href={`/rooms/manage-listing/${this.props.roomId}/basics`} className="right_save" >Back</a>
                    <a href={`/rooms/manage-listing/${this.props.roomId}/location`} className="right_save_continue" >Next</a>
                </div>
            </div>
        );
    }
}

export default Content;