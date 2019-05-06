import React from 'react';
import {BrowserRouter as Router, Route, Link} from 'react-router-dom';

class Address extends React.Component {
    render(){
        return(
            <div id="js-location-container" className="js-section list_hover clearfix">
                <div className="location_left pull-left">
                    <h4>Address</h4>
                    <p>While guests can see approximately where your listing is located in search results, your exact address is private and will only be shown to guests after they book your listing.</p>
                    <div className="location_address">
                        <button id="js-add-address" className="btn custom_btn btn-large">
                        Add Address
                        </button>
                        <address id="address_view" className="hide">
                            <span className="address-line"> </span>
                            <span className="address-line"> Edinburgh Scotland</span>
                            <span className="address-line" />
                            <span className="address-line" />
                        </address>
                        <a href="/" className="js-edit-address-link edit-address-link hide">Edit Address</a>
                    </div>
                </div>
                <div className="media-photo space-top-sm-3 address-static-map pull-right">
                    <div className="location-map-container-v2 empty-map" />
                    <div className="location-map-pin-v2 map-pin moving">
                    </div>
                </div>
            </div>
        )
    }
}

export default Address;