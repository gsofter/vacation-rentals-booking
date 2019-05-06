import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

class Basic extends React.Component {
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <div className="content_show">
                        <div className="content_showhead">
                            <h1>Help Travelers Find the Right Fit</h1>
                            <p>People searching on Vacation.Rentals----- can filter by listing basics to find a space that matches their needs.</p>
                        </div>
                        <div className="content_right">
                            <div className="content_buttons">
                            
                            <a href="/description" className="right_save_continue">Next</a>
                            </div>
                        </div>
                        </div>
                        <hr className="row-space-top-6 row-space-5 post-listed" />
                        <div className="js-section list_hover col-sm-12 bathbedrj">
                        
                        <div className="base_decs">
                            <h4>Bedrooms <span className="requiredRJ">*</span></h4>
                        </div>
                        <div className="base_text">
                            <div className="rj_list_property" id="alloverbedroomsList">
                                <a href="/add_bedroom" className="rj_add_bedroom_btn" id="js-add-bedrooms">Add a bedroom</a>
                            </div>
                        </div>
                        </div>
                        <div className="js-section list_hover col-sm-12 bathbedrj" ng-init="bedrooms='';beds='';bathrooms='';bed_type='';">
                        
                        <div className="base_decs">
                            <h4>Bathroom (Optional)</h4>
                        </div>
                        <div className="base_text">
                            <div className="rj_list_property" id="alloverbedroomsList">
                                <a href="add_bathroom" className="popup-trigger rj_add_bedroom_btn" id="js-add-bathrooms">Add a bathroom</a>
                            </div>
                        </div>
                        </div>
                        <div id="address-flow-view" />
                        <div className="calendar_savebuttons">
                        
                        <a href="/description" className="right_save_continue">Next</a>
                        </div>
                        <hr />
                    </div>
                    </div>
                    <div className="col-md-4 col-sm-12 listing_desc location_desc">
                        <div className="manage_listing_left">
                            <img src="https://www.vacation.rentals/images/property-help.png" className="col-center" width={75} height={75} />
                            <div className="amenities_about">
                            <h4>Bedroom/Bathroom</h4>
                            <p>Tell your guests how many bedrooms and bathrooms your property has. If you have multiple beds in the same bedroom, you can state that as well. For sleeper sofas in the living room, simply name the bedroom "Living Room" and select the number of sleeper sofas you have. </p>
                            </div>
                        </div>
                    </div>
                </div>
        );
    }
}

export default Basic;