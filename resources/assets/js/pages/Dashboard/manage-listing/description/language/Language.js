import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

class Language extends React.Component {
    render(){
        return(
            <div className="clearfix space-4 language-tabs-container">
                <div className="col-md-9 col-sm-9">
                    <ul className="tabs multiple-description-tabs pull-left tab_adj" >
                       
                        <li> <a href="/"className="tab-item" > English</a></li>
                        <a href="/" className="ng-scope"></a>
                    </ul>
                </div>
                <div className="col-md-3 col-sm-3 add-language-container">
                    <a href="/" className="add-first-language" title="Write a title and description for this listing in another language"><i className="icon icon-add" /> Add Language </a>
                <div>
                    <a href="/"  className="remove-locale"><h3><i className="icon icon-trash icon-rausch" /></h3></a>
                </div>
                </div>
            </div>
        )
    }
}

export default Language;