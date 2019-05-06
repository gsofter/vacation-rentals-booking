import React from 'react';
import Title from './title/Title';
import './title/title.css';
import property_help from '../img/property-help.png';
import Address from './address/Address';
import Locationbutton from './locationbutton/Locationbutton';


class Location extends React.Component {
    constructor(props){
        super(props)
         
    }
    componentDidMount(){
        let active_lists = document.getElementsByClassName('nav-active')
                for(let i = 0 ; i < active_lists.length ; i++){
                    active_lists[i].classList.remove("nav-active");
                }
                let room_step = 'location'
                let current_lists = document.getElementsByClassName(`nav-${room_step}`)
                for(let i = 0 ; i < current_lists.length ; i++){
                    current_lists[i].classList.add('nav-active')
                    // active_lists[i].classList.remove("nav-active");
                }
    }
    render(){
        return(
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Title  roomId={this.props.match.params.roomId} />
                        <Address roomId={this.props.match.params.roomId} />
                        <Locationbutton roomId={this.props.match.params.roomId} />
                        
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                        <h4>Location</h4>
                        <p>Your exact address will only be shared with confirmed guests.</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Location;