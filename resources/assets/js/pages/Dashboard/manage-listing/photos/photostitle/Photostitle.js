import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import '../photos.css';


class Photostitle extends React.Component {
   
    render(){
        return(
            <div className="content_show">
                <div className="content_showhead">
                    <h1>Photos Can Bring Your Space to Life</h1>
                    <p>Add photos of areas guests have access to. You can always come back later and add more.</p>
                </div>
                <div className="content_right">
                    <a href={`${this.props.base_url}/amenities`} className="right_save" >Back</a>
                    <a href={`${this.props.base_url}/video`} className="right_save_continue" >Next</a>
                </div>
            </div>
        );
    }
}

export default Photostitle;