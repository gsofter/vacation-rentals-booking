import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import './amenitiestitle.css';


class Amenitiestitle extends React.Component {
   
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Tell Travelers About Your Space</h1>
                    <p>Every space on Vacation.Rentals----- is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.</p>
                </div>
                <div className="content_right">
                    <a href={`${this.props.base_url}/location`} className="right_save" >Back</a>
                    <a href={`${this.props.base_url}/photos`} className="right_save_continue" >Next</a>
                </div>
            </div>
        );
    }
}

export default Amenitiestitle;