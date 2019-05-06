import React from 'react';

class Rightsidebar extends React.Component {
    render(){
        return(
            <div className="col-md-4 col-sm-12 listing_desc location_desc">
                <div className="manage_listing_left">
                    <img src="https://www.vacation.rentals/images/property-help.png" className="col-center" width={75} height={75} alt />
                    <div className="amenities_about">
                    <h4>Bedroom/Bathroom</h4>
                    <p>Tell your guests how many bedrooms and bathrooms your property has. If you have multiple beds in the same bedroom, you can state that as well. For sleeper sofas in the living room, simply name the bedroom "Living Room" and select the number of sleeper sofas you have. </p>
                    </div>
                </div>
            </div>
        )
    }
}

export default Rightsidebar;