import React from 'react';
import RoomFeedback from './roomfeedback/RoomFeedback';
import Roomdetail from './roomdetail/Roomdetail';
import RoomVideo from './roomvideo/RoomVideo';
import RoomReview from './roomreview/RoomReview'
class Summary extends React.PureComponent {
    constructor(props){
        super(props);
    }

    render(){
        return(
            <div id="summary" className="panel col-lg-8 col-sm-12 room-section">
                <RoomFeedback room_id = {this.props.room_id} user_details={this.props.user_details} reviews={this.props.reviews} room_name = {this.props.room_detail ? this.props.room_detail.name : ''} address= {this.props.room_detail ? (this.props.room_detail.rooms_address ? this.props.room_detail.rooms_address : {}) : {}}/>
                <Roomdetail room_id = {this.props.room_id} room_detail = {this.props.room_detail}/>
                <RoomVideo video_url = {this.props.room_detail ? this.props.room_detail.video : ''}/>
                {/* 
                <RoomReview reviews={this.props.reviews} user_details={this.props.user_details} room_detail = {this.props.room_detail}/> */}
            </div>
        );
    }
}

export default Summary;