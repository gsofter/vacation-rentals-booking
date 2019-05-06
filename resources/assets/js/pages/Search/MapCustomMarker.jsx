import React from 'react'
import markerimage from  './marker.png'
class MapCustomMarker extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        return <img src={markerimage} style={{ width : '35px' }} />
    }
}
export default MapCustomMarker