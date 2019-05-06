import React from 'react'
import './markercluster.css'
class MarkerCluster extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        return <div className="mapmarkerCluster">{this.props.points}</div>
    }
}

export default MarkerCluster