import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

class Termstitle extends React.Component {
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Terms</h1>
                    <p>The requirements and conditions to book a reservation at your listing.</p>
                </div>
                <div className="content_right">
                    <a href={`${this.props.base_url}/calendar`} className="right_save" >Back</a>
                    <a href={`${this.props.base_url}/plan`} className="right_save_continue" >Next</a>
                </div>
            </div>
        )
    }
}

export default Termstitle;