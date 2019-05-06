import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

class Termsbutton extends React.Component {
    render(){
        return(
            <div className="calendar_savebuttons">
                 <a href={`/rooms/manage-listing/${this.props.roomId}/calendar`} className="right_save" >Next</a>
                    <a href={`/rooms/manage-listing/${this.props.roomId}/plans`} className="right_save_continue" >Next</a>
            </div>
        )
    }
}

export default Termsbutton;