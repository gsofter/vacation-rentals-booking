import React from 'react';
import Content from './content/Content';
import property_help from '../img/property-help.png';
import Language from './language/Language';
import Formcontent from './formcontent/Formcontent';
import Formtitle from './formtitle/Formtitle';
import Savebutton from './savebutton/Savebutton';

class Description extends React.Component {
    
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Content/>
                        <Language/>
                        <div className="description_form col-sm-12">
                            <Formtitle/>
                            <Formcontent/>
                        </div>
                        <Savebutton/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                        <h4>Description</h4>
                        <p>Your listing name will be the first thing travelers see when they find your space in search results.</p>
                        <p>Example: Cozy cottage just off Main Street</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Description;