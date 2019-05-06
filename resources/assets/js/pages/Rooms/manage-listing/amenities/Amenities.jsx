import React from 'react';
import Amenitiestitle from './amenitiestitle/Amenitiestitle';
import property_help from '../img/property-help.png';
import AmenitiestList from './AmenitiestList'
import Amenitiesbutton from './amenitiesbutton/Amenitiesbutton';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import axios from 'axios'
class Amenities extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            amenities_type: [],
            amenities: []
        }
        this.handleCheckEvent = this.handleCheckEvent.bind(this)
    }
    componentDidMount() {
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/get_amenities`)
            .then(res => {
                if (res.data) {
                    this.setState({
                        amenities_type: res.data.amenities_type,
                        amenities: res.data.amenities,
                        prev_amenities: res.data.prev_amenities
                    })
                    let active_lists = document.getElementsByClassName('nav-active')
                    for (let i = 0; i < active_lists.length; i++) {
                        active_lists[i].classList.remove("nav-active");
                    }
                    let room_step = 'amenities'
                    let current_lists = document.getElementsByClassName(`nav-${room_step}`)
                    for (let i = 0; i < current_lists.length; i++) {
                        current_lists[i].classList.add('nav-active')
                            // active_lists[i].classList.remove("nav-active");
                    }
                }
            })
    }
    handleCheckEvent(e) {
        // e.preventDefault()
        let value = e.target.value
        let prev_amenities = this.state.prev_amenities
        let checked = e.target.checked
        console.log(checked)
        if (checked) {
            prev_amenities.push(value.toString())
        } else {
            let amenity_index = prev_amenities.indexOf(value.toString())
            console.log('dddddddddddddd', amenity_index)
            if (amenity_index > -1) {
                prev_amenities.splice(amenity_index, 1)
            }
        }
        console.log(this.state.prev_amenities)
        this.setState({
            prev_amenities: prev_amenities
        })
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/update_amenities`, { data: this.state.prev_amenities.toString() })
            .then(res => {
                if (res.data.success) {
                    toast.success("Updated", {
                        position: toast.POSITION.TOP_RIGHT
                    });
                }
            })

    }
    render() {
        return ( <div className = "manage-listing-content-wrapper clearfix" >
            <ToastContainer />
            <div className = "listing_whole col-md-8"
            id = "js-manage-listing-content" >
            <div className = "common_listpage" >
            <Amenitiestitle roomId = { this.props.match.params.roomId }
            /> <AmenitiestList onChange = { this.handleCheckEvent }
            amenities_type = { this.state.amenities_type }
            amenities = { this.state.amenities }
            prev_amenities = { this.state.prev_amenities }
            /> <Amenitiesbutton roomId = { this.props.match.params.roomId }
            /> </div > </div> <div className = "col-md-4 col-sm-12 listing_desc" >
            <div className = "manage_listing_left" >
            <img src = { property_help }
            alt = "property-help"
            className = "col-center"
            width = "75"
            height = "75" />
            <div className = "amenities_about" >
            <h4 > Amenities </h4> <p > Choose amenities features inside your listing: </p> <p > < span > Common Amenities </span></p >
            <p > < span > Additional Amenities </span></p >
            <p > < span > Special Features </span>Features of your listing for guests with specific needs.</p >
            <p > < span > Home Safety </span>Smoke and carbon monoxide detectors are strongly encouraged for all listings.</p >
            <p > < span > Kitchen </span>List items that are supplied standard in your kitchen for the guests</p >
            <p > < span > Indoor / Outdoor activities nearby </span>Describe activities close by your rental property</p >
            <p > < span > Leisure </span>What makes your property ideal for leisure pastimes?</p >
            <p > < span > Swimming Pools </span>Select all the pools that are available to your guests</p >
            <p > < span > Ideal For </span>What is your property best suited for</p >
            <p > < span > Household </span>Select all of the household items that are available to your guests</p >
            <p > < span > IT & amp; Communication </span>Tell your guests how they can stay connected to your property</p >
            <p > < span > Activities Nearby </span>Every place has unique places nearby. Tell your guests what your property offers</p >
            <p > < span > Transportation </span>Let your guests know beforehand what types of transportation there is or they will need</p >
            </div> </div > </div> </div >
        )
    }
}

export default Amenities;