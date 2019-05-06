import React from 'react';
import property_help from '../img/property-help.png';
import Publishtitle from './publishtitle/Publishtitle';
import Publishbutton from './publishbutton/Publishbutton';
import Pricingpage from '../../../Pricing/Pricingpage';

class Publish extends React.Component {
    constructor(props){
        super(props)
    }
    componentDidMount(){
        let active_lists = document.getElementsByClassName('nav-active')
        for (let i = 0; i < active_lists.length; i++) {
            active_lists[i].classList.remove("nav-active");
        }
        let room_step = 'plans'
        let current_lists = document.getElementsByClassName(`nav-${room_step}`)
        for (let i = 0; i < current_lists.length; i++) {
            current_lists[i].classList.add('nav-active')
                // active_lists[i].classList.remove("nav-active");
        }
    }
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Publishtitle/>
                        <Pricingpage/>
                        
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                            <h4>Benefits Of Membership</h4>
                            <Publishbutton  roomId={this.props.match.params.roomId}/>
                            <p>Membership in our site gives you immediate exposure to 1,000s of travelers who are searching our site each day. 
                            Each membership allows you to upload 35 images, get a free custom YouTube video, 
                            500 custom business cards with holder and utilize all of the features of this site to include iCal, SMS notifications, Google maps and much more.</p>
                            <p>Sign up today and take back control of your vacation rental listing. </p>
                            <p>Please make sure to join our homeowners <a href="https://www.facebook.com/groups/vacation.rentals4U/" target="_blank">Facebook Group</a> to stay abreast of all updates and improvements.</p>
                            <em>*Please contact us at sales@vacation.rentals for any assistance with your listing(s).</em>
                        </div>
                    </div>
                  
                </div>
            </div>
        )
    }
}

export default Publish;