import React from "react";
import ReactDOM from "react-dom";
import { compose, withProps, withHandlers } from "recompose";
import {
  withScriptjs,
  withGoogleMap,
  
  GoogleMap,
  Marker
} from "react-google-maps";

const GooglemapContainer = compose(
  withProps({
    /**
     * Note: create and replace your own key in the Google console.
     * https://console.developers.google.com/apis/dashboard
     * The key "AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs" can be ONLY used in this sandbox (no forked).
     */
    googleMapURL:
      "https://maps.googleapis.com/maps/api/js?key=AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs&v=3.exp&libraries=geometry,drawing,places",
    loadingElement: <div style={{ height: `100%` }} />,
    containerElement: <div style={{ height: `100%` }} />,
    mapElement: <div style={{ height: `100%` }} />
  }),
  withScriptjs,
//   withHandlers(
//     ()=>{
//       const refs = {
//         map : undefined
//       }
//       return {
//         onMapMounted : () => ref => {

//         //   console.log('---',ref)
//           refs.map = ref
//         },
//         onBoundsChanged: ({ onBoundsChange }) => () => {
//           // let result = refs
//          let center = refs.map.getCenter()
//          console.log(center.lat(), center.lng)
         
//           // onZoomChange(refs.map.getZoom())
//         }
//       }
//     }
//   ),
  withGoogleMap
)(props => (
  <GoogleMap defaultZoom={props.zoom ? props.zoom :  14} 
  onBoundsChanged={props.onBoundsChanged} onCenterChanged={props.onCenterChanged} defaultCenter={{ lat: props.lat, lng: props.lng }}  ref={props.onMapMounted} onZoomChanged={props.onCenterChanged}>
    {props.isMarkerShown && (
      <Marker position={{ lat: props.lat, lng: props.lng }} />
    )}
  </GoogleMap>
));

export default GooglemapContainer