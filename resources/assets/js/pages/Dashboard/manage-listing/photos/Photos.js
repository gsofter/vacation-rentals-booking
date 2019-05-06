import React from 'react';
import Photostitle from './photostitle/Photostitle';
import property_help from '../img/property-help.png';
import Upload from './upload/Upload';
import Photosbutton from './photosbutton/Photosbutton';



class Photos extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Photostitle/>
                        <Upload/>
                        <Photosbutton/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                        <h4>Guests Love Photos</h4>
                        <p>We recommend using good quality landscape oriented photos (3:2 or 4:3 aspect ratio recommended).</p>
                        <p>Include a few well-lit photos.</p>
                        <p>Cell phone photos are just fine.</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Photos;