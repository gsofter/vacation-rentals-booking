import React, { Component } from 'react';
import GoogleMapReact from 'google-map-react';
import supercluster from 'points-cluster';
 import Marker from './components/Marker/Marker'
 import RoomDetail from './components/RoomDetail'
 import MarkerCluster from './components/Marker/MarkerCluster'
 import axios from 'axios'
const fullFormat = 'YYYY-MM-DD';
const AnyReactComponent = ({ text }) => <div>{text}</div>;

class SearchMap extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            mapOptions: {
                center: {
                    lat: this.props.defaultCenter.lat,
                    lng: this.props.defaultCenter.lng
                },
                zoom: 11
            },
            clusters: [],
            listings : [],
            room_detail : {},
            activeRoom_lat : null,
            activeRoom_lng : null,
            open_detail : false
        }
        this.handleMapChange = this.handleMapChange.bind(this)
        this.createClusters = this.createClusters.bind(this)
        this.getClusters = this.getClusters.bind(this)
        this.onMarkerClick = this.onMarkerClick.bind(this)
    }
    onMarkerClick(room_id){
        console.log(room_id)
        axios.get(`/ajax/homes/${room_id}`)
        .then(res => {
            this.setState({
                room_detail : res.data.result,
                activeRoom_lat : res.data.latitude,
                activeRoom_lng : res.data.longitude,
                open_detail : true
            })
            console.log(res)
        })
    }
    getClusters (listings){
        const clusters = supercluster(this.state.listings, {
            minZoom: 0,
            maxZoom: 16,
            radius: 60,
          });
          return clusters(this.state.mapOptions)
    }
    createClusters(listings){
        this.setState({
            clusters : this.state.mapOptions.bounds ? 
            this.getClusters(listings).map(({wx, wy, numPoints, points})=>({
                lat: wy,
                lng: wx,
                numPoints,
                id: `${points[0].id}`,
                points,
            }))
            : []

        }, ()=>{
            console.log(this.state.clusters, '++++++++++Clusters')
        })
    }
    handleMapChange({ center, zoom, bounds }){
        this.setState(
            {
                open_detail : false,
              mapOptions: {
                center,
                zoom,
                bounds,
              },
            },
            () => {
                
                let page_data = this.props.data.page_data
                axios.post('/ajax/searchResultOnMap', {
                    amenities: page_data.amenities_selected,
                    bathrooms: 0,
                    bedrooms: 0,
                    beds: 0,
                    checkin: page_data.checkin.format(fullFormat),
                    checkout: page_data.checkout.format(fullFormat),
                    guest: page_data.guest,
                    instant_book: "0",
                    location: {
                        northEast : {lat : bounds.ne.lat, lng : bounds.ne.lng},
                        southWest : {lat : bounds.sw.lat, lng : bounds.sw.lng},
                        center : { lat : center.lat, lng : center.lng}
                    },
                    map_details: "",
                    max_price: page_data.max_price_check,
                    min_price: page_data.min_price_check ? page_data.min_price_check : 0,
                    property_id: "",
                    property_type: page_data.property_type_selected,
                    room_type: [],
                  }).then(res => {
                    this.setState({listings : res.data}, ()=>{
                        this.createClusters(this.state.listings);
                    })
                   
                    // 
                  })
            //   this.createClusters(this.props);
            }
          );
    }

    render() {
        return (
            // Important! Always set the container height explicitly
            <div style={{ height: '100vh', width: '100%' }}>
                <GoogleMapReact
                    bootstrapURLKeys={{ key: 'AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs' }}
                    defaultZoom={11}
                    defaultCenter={this.state.mapOptions.center}
                    options={this.state.mapOptions}
                    onChange={this.props.handleMapChange}
                    yesIWantToUseGoogleMapApiInternals
                >
                {
                    this.state.open_detail ? <RoomDetail 
                    lat={this.state.activeRoom_lat}
                    lng={this.state.activeRoom_lng}
                    room_data = {this.state.room_detail}></RoomDetail> : null
                }
                   {this.state.clusters.map(item => {
                        if (item.numPoints === 1) {
                        return  <Marker
                        onClick={()=>this.onMarkerClick(item.id)}
                            key={item.id}
                            lat={item.points[0].lat}
                            lng={item.points[0].lng}
                            />
                        
                        }

                        return    <MarkerCluster
                            key={item.id}
                            lat={item.lat}
                            lng={item.lng}
                            points={item.numPoints}
                        />
                       
                    })}
                </GoogleMapReact>
            </div>
        );
    }
}

export default SearchMap;