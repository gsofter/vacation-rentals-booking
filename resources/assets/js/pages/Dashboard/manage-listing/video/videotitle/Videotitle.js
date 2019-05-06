import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import '../video.css';


class Videotitle extends React.Component {
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Video Can Bring Your Space to Life</h1>
                    <p>Add video of areas guests have access to.</p>
                </div>
                <div className="content_right">
                    <a href={`${this.props.base_url}/photos`} className="right_save" >Back</a>
                    <a href={`${this.props.base_url}/pricing`} className="right_save_continue" >Next</a>
                </div>
            </div>
        )
    }
}

export default Videotitle;