import React from 'react';
import './markercluster.css'
import markerImage from './home_marker.png'
import activeMarkerImage from './home_marker_active.png'
class Marker extends React.PureComponent {
  // eslint-disable-line react/prefer-stateless-function
  constructor(props){
    super(props)
  }
  render() {
    if(this.props.is_active){
      return (
        <div className="mapMarker" onClick = { this.props.onClick }>
       
        <img src={activeMarkerImage} width="30px" className="home_marker_image marker_active"  width='30px' height='30px'/>
        </div>
      );
    }
    else{
      return (
        <div className="mapMarker " onClick = { this.props.onClick }>
        <img src={markerImage} width="30px" className="home_marker_image " width='30px' height='30px'/>
        </div>
      );
    }
    
  }
}
 

export default Marker;