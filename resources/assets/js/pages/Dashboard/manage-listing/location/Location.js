import React from 'react';
import Title from './title/Title';
import './title/title.css';
import property_help from '../img/property-help.png';
import Address from './address/Address';
import Locationbutton from './locationbutton/Locationbutton';


class Location extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Title/>
                        <Address/>
                        <Locationbutton/>
                        
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                        <h4>Location</h4>
                        <p>Your exact address will only be shared with confirmed guests.</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Location;