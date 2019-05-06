import React from 'react';
import Videotitle from './videotitle/Videotitle';
import property_help from '../img/property-help.png';
import Videoform from './videoform/Videoform';
import Videobutton from './videobutton/Videobutton';




class Video extends React.Component {
    constructor(props){
        super(props)
    }
    componentDidMount(){
        let active_lists = document.getElementsByClassName('nav-active')
                    for (let i = 0; i < active_lists.length; i++) {
                        active_lists[i].classList.remove("nav-active");
                    }
                    let room_step = 'video'
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
                        <Videotitle roomId={this.props.match.params.roomId}/>
                        <Videoform roomId={this.props.match.params.roomId}/>
                        <Videobutton roomId={this.props.match.params.roomId}/>
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