import React from 'react';
import property_help from '../img/property-help.png';
import Publishtitle from './publishtitle/Publishtitle';
import Publishbutton from './publishbutton/Publishbutton';
import Pricing from '../../../Pricing/Pricing';

class Publish extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Publishtitle/>
                        <Publishbutton/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                            <h4>Benefits Of Membership</h4>
                            <p>Membership in our site gives you immediate exposure to 1,000s of travelers who are searching our site each day. 
                            Each membership allows you to upload 35 images, get a free custom YouTube video, 
                            500 custom business cards with holder and utilize all of the features of this site to include iCal, SMS notifications, Google maps and much more.</p>
                            <p>Sign up today and take back control of your vacation rental listing. </p>
                            <p>Please make sure to join our homeowners <a href="https://www.facebook.com/groups/vacation.rentals4U/" target="_blank">Facebook Group</a> to stay abreast of all updates and improvements.</p>
                            <em>*Please contact us at sales@vacation.rentals for any assistance with your listing(s).</em>
                        </div>
                    <Pricing/>
                    </div>
                </div>
            </div>
        )
    }
}

export default Publish;