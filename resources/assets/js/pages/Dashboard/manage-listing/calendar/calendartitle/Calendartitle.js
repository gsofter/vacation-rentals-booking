import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';


class Calendartitle extends React.Component {
   
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Listing Availability</h1>
                    <p>Use the calendar below to restrict your listing availability and create custom seasonal pricing for specific dates.</p>
                </div>
                <div className="content_right">
                    <a href={`${this.props.base_url}/terms`} className="right_save_continue" >Next</a>
                </div>
            </div>
        );
    }
}

export default Calendartitle;