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
                    <a href={`/rooms/manage-listing/${this.props.roomId}/calendar`} className="right_save" >Next</a>
                    <a href={`/rooms/manage-listing/${this.props.roomId}/plans`} className="right_save_continue" >Next</a>
                </div>
            </div>
        )
    }
}

export default Termstitle;