import React from 'react';
import Calendartitle from './calendartitle/Calendartitle';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom'

class Calendar extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Calendartitle/>
                        
                    </div>
                </div>
                <div className="col-md-4 import_calander">
                    <div className="common_ios">
                        <div className="calendar_settings">
                            <a href="#" className="slide-toggle">iCal Settings <i className="fa fa-calendar"/></a>
                        </div>
                        <div className="new_box" style={{display: 'none'}}>
                            <div className="box-inner">
                            <h5> iCal Settings<a href="#"><i className="close_imp fa fa-close"/></a></h5>
                            <div className="import_cal">
                                <a href="javascript:void(0);" id="import_button">Import Calendar</a>
                                <a href="javascript:void(0);" id="export_button">Export Calendar</a>
                                <a href="#" id="import_button">Import Calendar</a>
                                <a href="#" id="export_button">Export Calendar</a>
                            </div>
                            <div className="import_cal">
                                <ul className="imported_ical_ui">
                                </ul>
                            </div>
                            </div>
                        </div>
                        <div className="bow_wrapper">
                            <div className="instructionvideo">
                            <h4>Ical Instruction</h4>
                            <iframe width="100%" height={200} src="https://www.youtube.com/embed/OYfmmWQIxj0" frameBorder={0} allow="autoplay; encrypted-media" allowFullScreen />
                            </div>
                            <div className="instructionvideo" style={{marginTop: 15}}>
                            <h4>Seasonal Price Instruction</h4>
                            <iframe width="100%" height={200} src="https://www.youtube-nocookie.com/embed/27jDmVCmw6U" frameBorder={0} allow="autoplay; encrypted-media" allowFullScreen />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Calendar;