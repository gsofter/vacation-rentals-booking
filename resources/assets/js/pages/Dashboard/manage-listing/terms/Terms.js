import React from 'react';
import property_help from '../img/property-help.png';
import Termstitle from './termstitle/Termstitle';
import Canceleditor from './canceleditor/Canceleditor';
import Termsbutton from './termsbutton/Termsbutton';

class Terms extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Termstitle/>
                        <Canceleditor/>
                        <Termsbutton/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                            <h4>List Your Cancellation Policy</h4>
                            <p>Be descriptive with your cancellation policy and let your customers know the policies and penalties for early cancellations and no shows.</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Terms;