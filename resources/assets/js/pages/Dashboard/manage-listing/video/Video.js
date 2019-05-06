import React from 'react';
import Videotitle from './videotitle/Videotitle';
import property_help from '../img/property-help.png';
import Videoform from './videoform/Videoform';
import Videobutton from './videobutton/Videobutton';




class Video extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Videotitle/>
                        <Videoform/>
                        <Videobutton/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                            <h4>Guests Love Video</h4>
                            <p>Cell phone videos are just fine.</p>
                            <strong>Add a video:</strong><p>Add a video on your listing page. You can enter youtube embed code.</p>
                            <strong>NOTE*:<strong> only embed video code. ex: (https://youtu.be/IZXU_9pRabI)</strong></strong>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Video;