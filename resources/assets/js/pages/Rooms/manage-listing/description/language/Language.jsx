import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

class Language extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        let lang_data = this.props.lang_data
        let lang_tab_list = lang_data.map((lang) =>{
          if(lang.language) {return  <li key={lang.lang_code}> <a  className="tab-item" onClick={()=>this.props.handleChangeLanguage(lang.lang_code)}  aria-selected={this.props.current_lang == lang.lang_code}> {lang.language.name}</a></li>}
        })
        return(
            <div className="clearfix space-4 language-tabs-container">
                <div className="col-md-9 col-sm-12">
                    <ul className="tabs multiple-description-tabs pull-left tab_adj" >
                       
                       
                    <li > <a  className="tab-item" onClick={()=>this.props.handleChangeLanguage('en')} aria-selected={this.props.current_lang == 'en'}> English</a></li>
                        {lang_tab_list}
                    </ul>
                </div>
                <div className="col-md-3 col-sm-12 pl-3 add-language-container">
                   
                { this.props.current_lang!='en' ?  
                    <a onClick={this.props.removeLanguage}   className="remove-locale"> <i className="icon icon-trash icon-rausch" />Remove Language </a>
                 :  <a onClick={this.props.openAddLanguageModal} className="add-first-language" title="Write a title and description for this listing in another language"><i className="icon icon-add" /> Add Language </a>}
                </div>
            </div>
        )
    }
}

export default Language;