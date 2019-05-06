import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import axios from 'axios'
import AddressModal from 'react-responsive-modal';
import Geocode from "react-geocode";
Geocode.setApiKey("AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs");
import Googlemap from './GooglemapContainer'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import GoogleMapMarkerImage from './home_marker.png'
// Enable or disable logs. Its optional.
import {connect} from 'react-redux'
import { renderSidebarAction, renderStopSidebarAction} from '../../../../../actions/managelisting/renderSidebarAction'
Geocode.enableDebug();
class Address extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            location: 0,
            address: {
                address_line_1 : '', 
                address_line_2 : '', 
                country : '', 
                state : '', 
                city : '', 
                postal_code : '', 
                latitude : '', 
                longitude : '', 
            },
            visible_modal: false,
            countries: [],
            location_step: 0,
            refs: {
                map: undefined
            }
        }
        this.openEditModal = this.openEditModal.bind(this)
        this.closeEditModal = this.closeEditModal.bind(this)
        this.nextStep = this.nextStep.bind(this)
        this.handeChangeAddress = this.handeChangeAddress.bind(this)
        this.onMapMounted = this.onMapMounted.bind(this)
        this.onCenterChanged = this.onCenterChanged.bind(this)
        this.prevStep = this.prevStep.bind(this)
        this.LocationVerified = this.LocationVerified.bind(this)
    }
    componentDidMount() {
        axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/get_location`)
            .then(res => {
                if (res.data) {
                    this.setState({
                        location: res.data.location,
                        address: res.data.address,
                        countries: res.data.countries
                    })
                }
            })
    }
    prevStep() {
        let { location_step, address } = this.state
        this.setState({
            location_step: location_step - 1
        }, ()=>{
            
        })
    }
    nextStep() {
        let { location_step, address } = this.state
        if (location_step == 0) {
            if (address.postal_code) {
                // 4sOkeanskiy Prospekt, , Vladivostok, Primorskiy kray, RU, 690091

                let temp_address = address.address_line_1 + ', ' + address.city + ', ' + address.state + ', ' + address.country + ', ' + address.postal_code
                Geocode.fromAddress(temp_address).then(
                    response => {
                        const { lat, lng } = response.results[0].geometry.location;
                        console.log(lat, lng);

                        address.latitude = lat,
                            address.longitude = lng
                        this.setState({
                            address: address,
                            location_step: location_step + 1
                        })
                    },
                    error => {
                        console.error(error);
                    }
                );
            }
            else {
                toast.warn('Please input Postal Code!', {
                    position: toast.POSITION.TOP_RIGHT
                })
            }

        }
        else {
            this.setState({
                location_step: location_step + 1
            }, ()=>{
                
            })
        }

    }
    LocationVerified(){
        let {address } =this.state
        let post_data = {
            "country": address.country
            ,"address_line_1": address.address_line_1
            ,"address_line_2": address.address_line_2
            ,"city": address.city
            ,"state": address.state
            ,"postal_code": address.postal_code
            ,"latitude": address.latitude
            ,"longitude": address.longitude
        }
        axios.post(`/ajax/rooms/finish_address/${this.props.roomId}/location`, { data : JSON.stringify(post_data)})
        .then( res => {
           this.setState({
               address : res.data,
               visible_modal : false,
               location_step : 0,
               location : 1
           }, ()=>{
            !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
           })
           toast.success('Location Verified!', {
            position: toast.POSITION.TOP_RIGHT
            })
        })
    }
    closeEditModal() {
        this.setState({
            visible_modal: false,
            location_step: 0
        }, ()=>{
            
        })
    }
    openEditModal() {
        this.setState({
            visible_modal: true
        }, ()=>{
            
        })
    }
    handeChangeAddress(e) {
        let name = e.target.name
        let value = e.target.value
        let address = this.state.address
        address[name] = value
        this.setState({
            address: address
        }, ()=>{
            
        })

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
        }, ()=>{
            
        })
    }
    render() {
        console.log(this.props.roomId)
        let country_lists = this.state.countries.map((country) => {
            return <option value={country.short_name} key={country.short_name} selected={this.state.address.country == country.short_name || country.short_name == 'US'}>{country.long_name}</option>
        }

        )
        let modal_body = ''
        if (this.state.location_step == 0) {
            modal_body = <form id="js-address-fields-form" name="enter_address" className="ng-pristine ng-valid">
                <div className="row-space-1">
                    <label htmlFor="country">Country</label>
                    <div id="country-select"><div className="select select-block">
                        <select id="country" name="country_code" onChange={this.handeChangeAddress}>
                            {country_lists}
                        </select>
                    </div>
                    </div>
                </div>
                <div id="localized-fields">
                    <div className="row-space-1">
                        <label htmlFor="address_line_1">Address Line 1</label>
                        <input type="text" placeholder="House name/number + street/road" className="focus" id="address_line_1" name="address_line_1" onChange={this.handeChangeAddress} value={this.state.address.address_line_1} autoComplete="off" />
                    </div>
                    <div className="row-space-1" style={{ display: 'none' }}>
                        <label htmlFor="address_line_2">Address Line 2</label>
                        <input type="text" placeholder="Apt., suite, building access code"   className="focus" id="address_line_2" onChange={this.handeChangeAddress} value={this.state.address.address_line_2} name="address_line_2" />
                    </div>
                    <div className="row-space-1">
                        <label htmlFor="city">City / Town / District</label>
                        <input type="text" className="focus"   id="city" name="city" onChange={this.handeChangeAddress} value={this.state.address.city} />
                    </div>
                    <div className="row-space-1">
                        <label htmlFor="state">State / Province / County / Region</label>
                        <input type="text" className="focus"  id="state" onChange={this.handeChangeAddress} value={this.state.address.state} name="state" />
                    </div>
                    <div className="row-space-1">
                        <label htmlFor="postal_code">ZIP / Postal Code</label>
                        <input type="text" className="focus"  id="postal_code" onChange={this.handeChangeAddress} value={this.state.address.postal_code} name="postal_code" />
                    </div>
                </div>
            </form>
        }
        else if (this.state.location_step == 1) {
            modal_body =<div style={{ height : '300px', width : '300px' }}> <Googlemap onCenterChanged={this.onCenterChanged} onMapMounted={this.onMapMounted} lng={this.state.address.longitude} lat={this.state.address.latitude} isMarkerShown onBoundsChanged={console.log('Hello')} /></div>
        }
        else {
            modal_body = <address id="address_view"  style={{  width : '300px' }}>
                <h5 className="address-line">{this.state.address.address_line_1}</h5>
                <h5 className="address-line">{this.state.address.city}</h5>
                <h5 className="address-line">{this.state.address.state}</h5>
                <h5 className="address-line">{this.state.address.postal_code}</h5>
                <h5 className="address-line">{this.state.address.latitude}, {this.state.address.longitude}</h5>
            </address>
        }

        return (
            <div id="js-location-container" className="js-section list_hover clearfix">
                <ToastContainer />
                <div className="location_left pull-left">
                    <h4>Address</h4>
                    <h6>While guests can see approximately where your listing is located in search results, your exact address is private and will only be shown to guests after they book your listing.</h6>
                    <div className="location_address">
                        {
                            this.state.location == 0 ?
                                <button id="js-add-address" className="btn custom_btn btn-large" onClick={this.openEditModal}>
                                    Add Address
                                </button>
                                :
                                <address id="address_view">
                                    <h5 className="address-line mt-1">{this.state.address.address_line_1}</h5>
                                    <h5 className="address-line mt-1">{this.state.address.city}</h5>
                                    <h5 className="address-line mt-1">{this.state.address.state}</h5>
                                    <h5 className="address-line mt-1">{this.state.address.postal_code}</h5>
                                </address>
                        }

                        <AddressModal
                         open={this.state.visible_modal} onClose={() => this.closeEditModal()} center styles={{ modal:{padding:'0px'} }}>
                          
                            <div className="panel ng-scope">
                                <div className="panel-header">
                                    <a data-behavior="modal-close" className="modal-close" href="javascript:;" />
                                    <div className="h4 js-address-nav-heading">
                                        Enter Address<br />
                                        <small>What is your listing's address?</small>
                                    </div>
                                </div>
                                <div className="flash-container" id="js-flash-error-clicked-frozen-field" />
                                <div className="panel-body" style={{ minHeight : '300px' }}>
                                    {
                                        modal_body
                                    }

                                </div>
                                <div className="panel-footer">
                                    <div className="force-oneline">
                                        {
                                            this.state.location_step == 0 ? 
                                            <button data-behavior="modal-close" className="btn js-secondary-btn" onClick={this.closeEditModal}>
                                            Cancel
                                            </button> 
                                            : 
                                            <button data-behavior="modal-close" className="btn js-secondary-btn" onClick={this.prevStep}>
                                            Prev
                                            </button>
                                        }
                                        {
                                            this.state.location_step == 2 ? 
                                            <button id="js-next-btn" className="btn btn-primary js-next-btn" onClick={this.LocationVerified}>
                                            Finish
                                            </button>
                                            :
                                            <button id="js-next-btn" className="btn btn-primary js-next-btn" onClick={this.nextStep}>
                                                Next
                                            </button>
                                        }
                                        
                                    </div>
                                </div>
                            </div>

                        </AddressModal>
                        <a href='#' onClick={this.openEditModal} className={this.state.location == 0 ? "js-edit-address-link edit-address-link hide" : "js-edit-address-link edit-address-link"}>Edit Address</a>
                    </div>
                </div>
                <div className="media-photo space-top-sm-3 address-static-map pull-right">
                    <div className="location-map-container-v2 empty-map">
                        {
                            this.state.location != 1 ? <div></div> : <img src={`https://maps.googleapis.com/maps/api/staticmap?size=570x275&center=${this.state.address.latitude},${this.state.address.longitude}&zoom=16&maptype=roadmap&sensor=false&key=AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs`} className='w-100 h-100'/>
                        }
                    </div>
                    <img src={GoogleMapMarkerImage}  style={{     width: '34px' ,  position: 'absolute',
                                                                            left: '50%',
                                                                            top: 'calc(50% - 17px)',
                                                                            transform: 'translate(-50%, -50%)' }}/>
                </div>
            </div>
        )
    }
}
 
const mapStateToProps = state =>({
    ...state
  })
  const mapDispatchToProps = dispatch =>({
    renderSidebarAction : () => dispatch(renderSidebarAction) ,
    renderStopSidebarAction : () => dispatch(renderStopSidebarAction) 
  })

  export default connect(mapStateToProps, mapDispatchToProps)(Address)