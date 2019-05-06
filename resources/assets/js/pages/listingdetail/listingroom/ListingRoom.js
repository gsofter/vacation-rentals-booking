import React from 'react';
import Photo from './photo/Photo';
import Booking from './booking/Booking';
import Summary from './summary/Summary';
import Axios from 'axios';


class ListingRoom extends React.PureComponent {
    constructor(props){
        super(props);
        this.state = {
            photos : []
        }
    }

    componentDidMount(){
        Axios.get(`/ajax/homes/photos/${this.props.room_id}`)
        .then(Response =>{
            this.setState({
                photos : Response.data.rooms_photos
            })
        })
    }
    render(){
        return(
            <div id="room">
                <div className="page-container-responsive p-0">
                    <div  id="rooms_left" className="col-lg-8 col-sm-12">
                    <Photo photos = {this.state.photos}/></div>

                    <Booking room_id={this.props.room_id} user_details={this.props.user_details}  room_detail = {this.props.room_detail}/>
                  <Summary room_id={this.props.room_id}  user_details={this.props.user_details}  room_detail = {this.props.room_detail}
                //   reviews={this.props.reviews} user_details={this.props.user_details} rooms_description={this.props.rooms_description} amenities_type={this.props.amenities_type} amenities={this.props.amenities} amenities_icon={this.props.amenities_icon} bathrooms={this.props.bathrooms} bedrooms={this.props.bedrooms} house_type = {this.props.house_type} room_name = {this.props.room_name} address={this.props.address} room_detail = {this.props.room_detail}
                  /> 
                
                </div>
            </div>
        );
    }
}

export default ListingRoom;