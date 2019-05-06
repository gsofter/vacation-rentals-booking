import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

class Termsbutton extends React.Component {
    render(){
        return(
            <div className="calendar_savebuttons">
                <a href="#" className="right_save">Back</a>
                <a href ="#" className="right_save_continue">Next</a>
            </div>
        )
    }
}

export default Termsbutton;