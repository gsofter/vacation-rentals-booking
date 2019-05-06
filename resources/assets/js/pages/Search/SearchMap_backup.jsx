import React from 'react'
import axios from 'axios'
import MapContanier from './MapContainer'
const fullFormat = 'YYYY-MM-DD';
class SearchMap extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            address : {
                longitude : null,
                latitude : null
            },
            refs: {
                map: undefined
            },
            listings : []
            
        }
        this.handeChangeAddress = this.handeChangeAddress.bind(this)
        this.onMapMounted = this.onMapMounted.bind(this)
        this.onCenterChanged = this.onCenterChanged.bind(this)
        this.onBoundsChanged = this.onBoundsChanged.bind(this)
        this.onMapChanged = this.onMapChanged.bind(this)
        // this.onDragEnd = this.onDragEnd.bind(this)
    }
    componentDidMount(){
        let default_center = this.props.defaultCenter
        console.log(default_center, 'Map Center')
        // axios.post('/ajax/searchMapRooms', {center : default_center})
        // .then(result => {
        //         console.log(result)
        // })
    }
    onMapMounted(ref) {
        console.log(ref)
        let refs = this.state.refs
        refs.map = ref
        let center = refs.map.getCenter()
        console.log('Zoom Changed', refs.map.getBounds().getNorthEast().lat(), refs.map.getBounds().getNorthEast().lng(),refs.map.getBounds().getSouthWest().lat(), refs.map.getBounds().getSouthWest().lng())
       
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
                northEast : {lat : refs.map.getBounds().getNorthEast().lat(), lng : refs.map.getBounds().getNorthEast().lng()},
                southWest : {lat : refs.map.getBounds().getSouthWest().lat(), lng : refs.map.getBounds().getSouthWest().lng()},
                center : {lat : center.lat(), lng :center.lng() }
            },
            map_details: "",
            max_price: page_data.max_price_check,
            min_price: page_data.min_price_check ? page_data.min_price_check : 0,
            property_id: "",
            property_type: page_data.property_type_selected,
            room_type: [],
          }).then(res => {
            
            this.setState({listings : res.data,refs: refs})
          })
      

    }
    onCenterChanged() {
        // let refs = this.state.refs
        // let center = refs.map.getCenter()
        // console.log('center', center.lat())
        // let address = this.state.address
        // address.latitude = center.lat()
        // address.longitude = center.lng()
        // this.setState({
        //     address: address
        // })
    }
    onBoundsChanged(){
     
    }
    onMapChanged(){
        let refs = this.state.refs
        let center = refs.map.getCenter()
        console.log('Zoom Changed', refs.map.getBounds().getNorthEast().lat(), refs.map.getBounds().getNorthEast().lng(),refs.map.getBounds().getSouthWest().lat(), refs.map.getBounds().getSouthWest().lng())
       
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
                northEast : {lat : refs.map.getBounds().getNorthEast().lat(), lng : refs.map.getBounds().getNorthEast().lng()},
                southWest : {lat : refs.map.getBounds().getSouthWest().lat(), lng : refs.map.getBounds().getSouthWest().lng()},
                center : {lat : center.lat(), lng :center.lng() }
            },
            map_details: "",
            max_price: page_data.max_price_check,
            min_price: page_data.min_price_check ? page_data.min_price_check : 0,
            property_id: "",
            property_type: page_data.property_type_selected,
            room_type: [],
          }).then(res => {
            
            this.setState({listings : res.data})
          })
    }
    handeChangeAddress(e) {
        let name = e.target.name
        let value = e.target.value
        let address = this.state.address
        address[name] = value
        this.setState({
            address: address
        })
    }
    render(){
        
        return <div><MapContanier listings = {this.state.listings} onCenterChanged={this.onCenterChanged} onDragEnd={this.onMapChanged} onZoomChanged={this.onMapChanged} onBoundsChanged={this.onBoundsChanged} onMapMounted={this.onMapMounted} lng={this.props.data.page_data.cLong} lat={this.props.data.page_data.cLat} isMarkerShown  /></div>
    }
}
export default SearchMap