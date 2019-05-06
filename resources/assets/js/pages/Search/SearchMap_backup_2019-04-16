import React from 'react'
import GoogleMapReact from 'google-map-react';
import Marker from './components/Marker/Marker'
import axios from 'axios'
import RoomDetail from './components/RoomDetail'
class SearchMap extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            open_detail : false
        }
        this.onMarkerClick = this.onMarkerClick.bind(this);
        this.handleMapChange = this.handleMapChange.bind(this);
        this.handleMapClick = this.handleMapClick.bind(this);
    }
    handleMapChange({ center, zoom, bounds }){
        this.setState({
            open_detail : false
        }, ()=>{
            this.props.handleMapChange({ center, zoom, bounds })
        })
      
    }
    onMarkerClick(room_id){
        console.log(room_id)
        let self = this
        axios.get(`/ajax/homes/${room_id}`)
        .then((res) => {
            self.setState({
                room_detail : res.data.result,
                activeRoom_lat : res.data.latitude,
                activeRoom_lng : res.data.longitude,
                open_detail : true
            })
        })
    }
    handleMapClick({ x, y, lat, lng, event }){
        this.setState({
            open_detail : false
        })
    }

    render(){
        console.log(this.props.zoom)
        return <GoogleMapReact
          bootstrapURLKeys={{ key: 'AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs' }}
          onChange={this.handleMapChange}
          center={this.props.defaultCenter}
          onClick = {this.handleMapClick}
          zoom={this.props.zoom}
        >
         {
                    this.state.open_detail ? <RoomDetail 
                    lat={this.state.activeRoom_lat}
                    lng={this.state.activeRoom_lng}
                    room_data = {this.state.room_detail}></RoomDetail> : null
                }
        {
            this.props.data.map((listing,index) =>{
                return  <Marker
                    is_active = {this.props.hover_room == listing.id ? true : false}
                onClick={()=>this.onMarkerClick(listing.id)}
                    room_id = {listing.id}
                    key={listing.id}
                    lat={listing.latitude}
                    lng={listing.longitude}
                    />
            })
        }
        </GoogleMapReact>
      
    }
}
export default SearchMap