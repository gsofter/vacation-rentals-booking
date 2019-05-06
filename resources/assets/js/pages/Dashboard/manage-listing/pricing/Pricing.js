import React from 'react';
import Pricingtitle from './pricingtitle/Pricingtitle';
import property_help from '../img/property-help.png';
import Currency from './currency/Currency';
import Nightly from './nightly/Nightly';
import Monthly from './monthly/Monthly';
import Weekend from './weekend/Weekend';
import Minnights from './minnights/Minnights';
import Cleanfee from './cleanfee/Cleanfee';
import Additionalcharge from './additionalcharge/Additionalcharge';
import Tax from './tax/Tax';
import Refundable from './refundable/Refundable';
import Occupancy from './occupancy/Occupancy';
import Mindiscount from './mindiscount/Mindiscount';
import Editprice from './editprice/Editprice';
import Seasonalbutton from './seasonalbutton/Seasonalbutton';
import Pricingbutton from './pricingbutton/Pricingbutton';

class Pricing extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Pricingtitle/>
                        <Currency/>
                        <Nightly/>
                        <Monthly/>
                        <Weekend/>
                        <Minnights/>
                        <h2 className="h-two-raja">Additional Charges:</h2>
                        <Cleanfee/>
                        <Additionalcharge/>
                        <Tax/>
                        <Refundable/>
                        <Occupancy/>
                        <h2 className="h-two-raja">Last min discounts</h2>
                        <Mindiscount/>
                        <Editprice/>
                        <Seasonalbutton/>
                        <Pricingbutton/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                        <h4>Charges per night</h4>
                        <p>You may want attract your first few guests by offering a great deal. You can always increase your price after you’ve received some great reviews.</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Pricing;