import React from "react";

import { compose, withProps, withHandlers } from "recompose";
// import Marker from './components/Marker/Marker'
import {
  withScriptjs,
  withGoogleMap,
  GoogleMap,
  Marker
} from "react-google-maps";

const MapContanier = compose(
  withProps({
    googleMapURL:
      "https://maps.googleapis.com/maps/api/js?key=AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs&v=3.exp&libraries=geometry,drawing,places",
    loadingElement: <div style={{ height: `500px` }} />,
    containerElement: <div  style={{ height: `500px` }} />,
    mapElement: <div style={{ height: `500px` }}  />
  }),
  withScriptjs,
  withGoogleMap,
)(props => {
    return (<CustomMap mapdata={props}/>)
}
);
export default MapContanier
class CustomMap  extends React.Component{
  constructor(props){
    super(props)
    this.state = {
      mapdata :this.props.mapdata
    }
  }
  componentWillReceiveProps(nextProps){
    this.setState({
      mapdata : nextProps.mapdata
    })
  }
  render(){
    console.log('markets_____________', this.state.mapdata.listings, this.state.mapdata)
      return <GoogleMap  defaultZoom={8} defaultCenter={{ lat: -34.397, lng: 150.644 }} >
   </GoogleMap>
  }
}