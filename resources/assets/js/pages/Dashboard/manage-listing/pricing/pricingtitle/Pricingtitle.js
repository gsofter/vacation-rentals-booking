import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import './pricingtitle.css';


class Pricingtitle extends React.Component {
   
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Set a Nightly Price for Your Space</h1>
                    <p>You can set a price to reflect the space, amenities, and hospitality you’ll be providing..</p>
                </div>
                <div className="content_right">
                    <a href={`${this.props.base_url}/amenities`} className="right_save" >Back</a>
                    <a href={`${this.props.base_url}/video`} className="right_save_continue" >Next</a>
                </div>
            </div>
        );
    }
}

export default Pricingtitle;