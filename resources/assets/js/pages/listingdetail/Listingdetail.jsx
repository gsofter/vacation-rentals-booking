import React from 'react';


import ListingMenu from './listingmenu/ListingMenu';
import SubNav from './subnav/SubNav';
import ListingRoom from './listingroom/ListingRoom';


import ListingMap from './listingmap/ListingMap';
import SimilarListing from './similarlisting/SimilarListing';
import axios from 'axios'
class Listingdetail extends React.PureComponent {
    constructor(props){
        super(props);
        this.state = {
            room_detail : {},
            user_details : {},
            similar : []
        }
    }
    componentDidMount(){
        let address_url = this.props.match.params.address_url
        let room_id = this.props.match.params.roomId
        axios.get(`/ajax/homes/${address_url}/${room_id}`)
        .then(res => {
            this.setState({
                room_detail : res.data.result,
                user_details : res.data.user_details,
              
            })
        })
        axios.get(`/ajax/homes/similar/${room_id}`)
        .then(res => {
            this.setState({
                similar : res.data.similar
            })
        })
    }
    render(){
        let room_id = this.props.match.params.roomId
        
        return(
          
            <main>
            <div className="container-fluid">
                <ListingMenu room_name={this.state.room_detail != null ? this.state.room_detail.name : ''} address = {this.state.room_detail != null ? this.state.room_detail.rooms_address : {}}/>
                <SubNav/>
                <ListingRoom room_id={room_id} room_detail = {this.state.room_detail} user_details = {this.state.user_details} /> 
            </div>
            <ListingMap address={this.state.room_detail ? this.state.room_detail.rooms_address : {}}/>
            <SimilarListing listings={this.state.similar} /> 
            {/* 
            */}
            </main>
           
        );
    }
}

export default Listingdetail;