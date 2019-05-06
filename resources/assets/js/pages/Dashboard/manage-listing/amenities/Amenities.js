import React from 'react';
import Amenitiestitle from './amenitiestitle/Amenitiestitle';
import property_help from '../img/property-help.png';
import Commonlist from './commonlist/Commonlist';
import Additionlist from './additionlist/Additionlist';
import Speciallist from './speciallist/Speciallist';
import Safetylist from './safetylist/Safetylist';
import Kitlist from './kitlist/Kitlist';
import Indoorlist from './indoorlist/Indoorlist';
import Leisurelist from './leisurelist/Leisurelist';
import Swimlist from './swimlist/Swimlist';
import Ideallist from './ideallist/Ideallist';
import Householdlist from './householdlist/Householdlist';
import Itlist from './itlist/Itlist';
import Activitylist from './activitylist/Activitylist';
import Transportationlist from './transportationlist/Transportationlist';
import Amenitiesbutton from './amenitiesbutton/Amenitiesbutton';

class Amenities extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Amenitiestitle/>
                        <Commonlist/>
                        <Additionlist/>
                        <Speciallist/>
                        <Safetylist/>
                        <Kitlist/>
                        <Indoorlist/>
                        <Leisurelist/>
                        <Swimlist/>
                        <Ideallist/>
                        <Householdlist/>
                        <Itlist/>
                        <Activitylist/>
                        <Transportationlist/>
                        <Amenitiesbutton/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                            <h4>Amenities</h4>
                            <p>Choose amenities features inside your listing:</p>
                            <p><span>Common Amenities</span></p>
                            <p><span>Additional Amenities</span></p>
                            <p><span>Special Features</span>Features of your listing for guests with specific needs.</p>
                            <p><span>Home Safety</span>Smoke and carbon monoxide detectors are strongly encouraged for all listings.</p>
                            <p><span>Kitchen</span>List items that are supplied standard in your kitchen for the guests</p>
                            <p><span>Indoor/Outdoor activities nearby</span>Describe activities close by your rental property</p>
                            <p><span>Leisure</span>What makes your property ideal for leisure pastimes?</p>
                            <p><span>Swimming Pools</span>Select all the pools that are available to your guests</p>
                            <p><span>Ideal For</span>What is your property best suited for</p>
                            <p><span>Household</span>Select all of the household items that are available to your guests</p>
                            <p><span>IT &amp; Communication</span>Tell your guests how they can stay connected to your property</p>
                            <p><span>Activities Nearby</span>Every place has unique places nearby. Tell your guests what your property offers</p>
                            <p><span>Transportation</span>Let your guests know beforehand what types of transportation there is or they will need</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Amenities;