import React from 'react';
import GoogleMapContainer from '../../../pages/Rooms/manage-listing/location/address/GooglemapContainer'

const mapStyles = {
    width: '100%',
    height: '100%'
};
const hover_card_style = {
  
        position: 'absolute',
        top: '0px',
        left: '50%',
        transform: 'translate(-50%)',
    
}
class ListingMap extends React.PureComponent {
    constructor(props){
        super(props);
        this.state = {
            refs: {
                map: undefined
            },
            address : this.props.address ? this.props.address : {}
        }
        this.onMapMounted  = this.onMapMounted.bind(this)
        this.onCenterChanged  = this.onCenterChanged.bind(this)
    }
    onMapMounted(ref) {
        console.log(ref)
        let refs = this.state.refs
        refs.map = ref
        this.setState({
            refs: refs
        })
    }
    onCenterChanged() {

        let refs = this.state.refs
        let center = refs.map.getCenter()
        console.log('center', center.lat())
        let address = this.state.address
        address.latitude = center.lat()
        address.longitude = center.lng()
        this.setState({
            address: address
        })
    }
    render(){
        console.log('Address__________', this.props.address)
        return(
            <div id="neighborhood" className="room-section">
                <div className="" id="map-id" data-reactid=".2" style={{position:'relative'}}>
                    <div className="panel location-panel" style={{ height : 400 }}>
                    {this.props.address ? <GoogleMapContainer zoom={18} onCenterChanged={this.onCenterChanged} onMapMounted={this.onMapMounted} lng={this.props.address ? parseFloat(this.props.address.longitude) : 0} lat={this.props.address ? parseFloat(this.props.address.latitude) : 0} isMarkerShown onBoundsChanged={console.log('Hello')} />: <div> </div>}
                       
                            <div id="hover-card" className="panel" style={hover_card_style}>
                                <div className="panel-body">
                                    <div className="text-center">
                                        Listing Location
                                    </div>
                                    <div className="text-center">
                                        <span>
                                            <a href="javascript:void(0);" className="text-muted"><span>{ this.props.address ? this.props.address.state : 'Loading...'},</span></a>
                                        </span>
                                        <span>
                                            <a href="javascript:void(0);" className="text-muted"><span>{this.props.address ? this.props.address.country_name : 'Loading...'}</span></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        );
    }
}
export default ListingMap 