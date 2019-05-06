import React from 'react'
import Header from '../../common/header/Header'
// import './search.css'
// import './search_new.css'
import ImageZoom from 'react-medium-image-zoom'

import axios from 'axios'
import PlacesAutocomplete from 'react-places-autocomplete';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import moment from 'moment';
import 'moment/locale/zh-cn';
import 'moment/locale/en-gb';
import zhCN from 'rc-calendar/lib/locale/zh_CN';
import enUS from 'rc-calendar/lib/locale/en_US';
import RangeCalendar from 'rc-calendar/lib/RangeCalendar';
import DatePicker from 'rc-calendar/lib/Picker';
const format = 'MM-DD-YYYY';
const fullFormat = 'MM-DD-YYYY';
const cn = location.search.indexOf('cn') !== -1;
import InputRange from 'react-input-range';
import 'react-input-range/lib/css/index.css'
import { ReactSpinner } from 'react-spinning-wheel';
import 'react-spinning-wheel/dist/style.css';
import ReactCountryFlag from "react-country-flag";
import Photo from '../listingdetail/listingroom/photo/Photo';
import ReactPaginate from 'react-paginate';
import SearchMap from './SearchMap'
import { StickyContainer, Sticky } from 'react-sticky';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import "react-tabs/style/react-tabs.css";
const now = moment();
now.locale('en-gb').utcOffset(0);
class Picker extends React.PureComponent {
  constructor(props) {
    super(props)
    this.state = {
      hoverValue: [],
      latLng: { lat: 0, lng: 0 },

    };

    this.onHoverChange = this.onHoverChange.bind(this)

  }


  onHoverChange(hoverValue) {

    this.setState({ hoverValue });
  }

  render() {
    const props = this.props;
    const { showValue } = props;
    const calendar = (
      <RangeCalendar
        hoverValue={this.state.hoverValue}
        onHoverChange={this.onHoverChange}
        type={this.props.type}
        defaultValue={now}
        format={format}
        onChange={props.onChange}
        disabledDate={props.disabledDate}
      />);
    return (
      <DatePicker
        open={this.props.open}
        onOpenChange={this.props.onOpenChange}
        calendar={calendar}
        minDate={moment()}
        value={props.value}
      >
        {
          () => {
            return (
              <input
                className={props.className}
                placeholder={props.placeholder}
                readOnly
                type="text"
                name={props.name}
                value={showValue && showValue.format(fullFormat) || ''}
              />
            );
          }
        }
      </DatePicker>);
  }
}
class Search extends React.PureComponent {
  constructor(props) {
    super(props)
    this.state = {
      startValue: null,
      endValue: null,
      startOpen: false,
      endOpen: false,
      page_data: {},
      is_search_now: false,
      search_result: [],
      page_count: 0,
      current_page: 1,
      last_page: 1,
      total: 1,
      per_page: 1,
      map_view_mode: 0,
      searchOption: 'address',
      hover_room: null,
      selected_room: null,
      is_map_move: false
    }
    this.onStartOpenChange = this.onStartOpenChange.bind(this)
    this.onEndOpenChange = this.onEndOpenChange.bind(this)
    this.onStartChange = this.onStartChange.bind(this)
    this.onEndChange = this.onEndChange.bind(this)
    this.disabledStartDate = this.disabledStartDate.bind(this)
    this.handleLocationChange = this.handleLocationChange.bind(this)
    this.handleLocationSelect = this.handleLocationSelect.bind(this)
    this.handleChangeAmenity = this.handleChangeAmenity.bind(this)
    this.handleChangePropertyType = this.handleChangePropertyType.bind(this)
    this.handleChangeGuest = this.handleChangeGuest.bind(this)
    this.handleSearch = this.handleSearch.bind(this)
    this.handleChangeViewMode = this.handleChangeViewMode.bind(this)
    this.handlePageClick = this.handlePageClick.bind(this)
    this.handleMapChange = this.handleMapChange.bind(this)
    this.handleResultHover = this.handleResultHover.bind(this)
    this.handleResultLeave = this.handleResultLeave.bind(this)
    this.updateDimensions = this.updateDimensions.bind(this)
  }
  handleResultHover(room_id) {
    this.setState({
      hover_room: room_id
    })
  }
  handleResultLeave(room_id) {
    this.setState({
      hover_room: null
    })
  }
  handleMapChange({ center, zoom, bounds }) {
    if (this.state.is_map_move == true) {
      let location = {
        northEast: { lat: bounds.ne.lat, lng: bounds.ne.lng },
        southWest: { lat: bounds.sw.lat, lng: bounds.sw.lng },
        center: { lat: center.lat, lng: center.lng }
      }
      this.setState({
        location: location,
        searchOption: 'mapsearch',
        map_zoom: zoom,
        map_center: center
      }, () => {
        this.handleSearch()
      });
    }
    else {
      this.setState({
        is_map_move: true
      })
    }

  }
  handleChangeViewMode(mode) {
    this.setState({
      map_view_mode: mode
    })
  }
  handlePageClick(data) {
    let new_page = (data.selected + 1)


    let page_data = this.state.page_data
    this.setState({
      is_search_now: true
    })
    axios.post('/ajax/searchResult?page=' + new_page, {
      searchOption: this.state.searchOption,
      amenities: page_data.amenities_selected,
      bathrooms: 0,
      bedrooms: 0,
      beds: 0,
      checkin: page_data.checkin.format(fullFormat),
      checkout: page_data.checkout.format(fullFormat),
      guest: page_data.guest,
      instant_book: "0",
      location: this.state.searchOption == 'address' ? page_data.meta_title : this.state.location,
      map_details: "",
      max_price: page_data.max_price_check,
      min_price: page_data.min_price_check ? page_data.min_price_check : 0,
      property_id: "",
      property_type: page_data.property_type_selected,
      room_type: [],
    }).then(res => {

      this.setState({
        search_result: res.data.data,
        current_page: res.data.current_page,
        last_page: res.data.last_page,
        total: res.data.total,
        is_search_now: false,
        is_map_move: this.state.searchOption == 'address' ? false : true

      })
    })
  }
  handleSearch() {

    let page_data = this.state.page_data
    this.setState({
      is_search_now: true
    })
    axios.post('/ajax/searchResult', {
      searchOption: this.state.searchOption,
      amenities: page_data.amenities_selected,
      bathrooms: 0,
      bedrooms: 0,
      beds: 0,
      checkin: page_data.checkin.format(fullFormat),
      checkout: page_data.checkout.format(fullFormat),
      guest: page_data.guest,
      instant_book: "0",
      location: this.state.searchOption == 'address' ? page_data.meta_title : this.state.location,
      map_details: "",
      max_price: page_data.max_price_check,
      min_price: page_data.min_price_check ? page_data.min_price_check : 0,
      property_id: "",
      property_type: page_data.property_type_selected,
      room_type: [],
    }).then(res => {
      this.setState({
        search_result: res.data.data,
        current_page: res.data.current_page,
        last_page: res.data.last_page,
        total: res.data.total,
        is_search_now: false,
        is_map_move: this.state.searchOption == 'address' ? false : true
      })
    })
  }
  handleChangeGuest(e) {
    let page_data = this.state.page_data
    page_data.guest = e.target.value
    this.setState({
      page_data: page_data
    })
    this.handleSearch()
  }
  handleChangePropertyType(e) {
    let page_data = this.state.page_data
    let property_type_selected = page_data.property_type_selected
    let amenity_index = property_type_selected.indexOf(e.target.value)
    if (amenity_index == -1) {
      property_type_selected.push(e.target.value)
    }
    else {
      property_type_selected.splice(amenity_index, 1)
    }
    page_data.property_type_selected = property_type_selected
    this.setState({
      page_data: page_data
    })
    this.handleSearch()
  }
  handleChangeAmenity(e) {
    let page_data = this.state.page_data
    let amenities_selected = page_data.amenities_selected
    let amenity_index = amenities_selected.indexOf(e.target.value)
    if (amenity_index == -1) {
      amenities_selected.push(e.target.value)
    }
    else {
      amenities_selected.splice(amenity_index, 1)
    }
    page_data.amenities_selected = amenities_selected
    this.setState({
      page_data: page_data
    })
    this.handleSearch()
  }
  onStartOpenChange(startOpen) {
    this.setState({
      startOpen,
    });
  }

  onEndOpenChange(endOpen) {
    this.setState({
      endOpen,
    });
  }

  onStartChange(value) {
    let page_data = this.state.page_data
    page_data.checkin = value[0]
    this.setState({
      page_data: page_data,
      startOpen: false,
      endOpen: true,
    });
    this.handleSearch()
  }

  onEndChange(value) {
    let page_data = this.state.page_data
    page_data.checkout = value[1]
    this.setState({
      page_data: page_data,
    });
    this.handleSearch()
  }

  disabledStartDate(endValue) {
    if (!endValue) {
      return false;
    }
    const startValue = this.state.startValue;
    if (!startValue) {
      return false;
    }
    return endValue.diff(startValue, 'days') < 0;
  }
  disableDate(date) {
    let selected_date = date;

    let now = moment();

    let diff_day = now.diff(selected_date, 'days')

    if (diff_day > 0) {
      return true
    }
    else {
      return false

    }
  }
  handleLocationChange(address) {
    let page_data = this.state.page_data;
    page_data.meta_title = address
    this.setState({ page_data: page_data });
    // this.handleSearch()
  };

  handleLocationSelect(address) {
    let page_data = this.state.page_data;
    page_data.meta_title = address
    this.setState({ page_data: page_data });
    this.handleSearch()
  };
  componentDidMount() {
    window.addEventListener("resize", this.updateDimensions);
    let query = this.props.location.search.substr(1);
    let params = query.split('&');
    let search_params = {}
    let param_list = params.map((param) => {
      let temp_param = param.split('=')
      search_params[temp_param[0]] = temp_param[1]
      return temp_param
    })
    axios.post('/ajax/searchIndex', {
      amenities: [],
      bathrooms: 0,
      bedrooms: 0,
      beds: 0,
      checkin: search_params['checkin'],
      checkout: search_params['checkout'],
      guest: search_params['guest'],
      instant_book: "0",
      location: search_params['locations'],
      map_details: "",
      property_id: "",
      property_type: [],
      room_type: [],
    })
      .then(res => {
        res.data.checkin = moment(res.data.checkin)
        res.data.checkout = moment(res.data.checkout)
        this.setState({
          page_data: res.data
        })
        this.handleSearch()
      })
  }
  getDistance(lat1, lat2, lon1, lon2, unit = 'K') {
    if ((lat1 == lat2) && (lon1 == lon2)) {
      return 0;
    }
    else {
      var radlat1 = Math.PI * lat1 / 180;
      var radlat2 = Math.PI * lat2 / 180;
      var theta = lon1 - lon2;
      var radtheta = Math.PI * theta / 180;
      var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
      if (dist > 1) {
        dist = 1;
      }
      dist = Math.acos(dist);
      dist = dist * 180 / Math.PI;
      dist = dist * 60 * 1.1515;
      if (unit == "K") { dist = dist * 1.609344 }
      if (unit == "N") { dist = dist * 0.8684 }
      return dist.toFixed(2)
      return dist;
    }


    return distance
  }
  getBoundsZoomLevel(ne, sw) {
    let mapDim = {
      height: document.getElementById('search_google_map').getBoundingClientRect().height,
      width: document.getElementById('search_google_map').getBoundingClientRect().width
    }

    var WORLD_DIM = { height: 256, width: 256 };
    var ZOOM_MAX = 21;
    var latFraction = (this.latRad(ne.lat) - this.latRad(sw.lat) / Math.PI);
    var lngDiff = ne.lng - sw.lng;
    var lngFraction = ((lngDiff < 0) ? (lngDiff + 360) : lngDiff) / 360;
    var latZoom = this.zoom(mapDim.height, WORLD_DIM.height, latFraction);
    var lngZoom = this.zoom(mapDim.width, WORLD_DIM.width, lngFraction);
    
    return Math.min(lngZoom, ZOOM_MAX);
  }
  latRad(lat) {
    var sin = Math.sin(lat * Math.PI / 180);
    var radX2 = Math.log((1 + sin) / (1 - sin)) / 2;
    return Math.max(Math.min(radX2, Math.PI), -Math.PI) / 2;
  }

  zoom(mapPx, worldPx, fraction) {
    return Math.floor(Math.log(mapPx / worldPx / fraction) / Math.LN2);
  }
  updateDimensions(){
    this.setState({width: $(window).width(), height: $(window).height()});
  }
  render() {
    
    const state = this.state;
    let search_guest_options = [];
    for (let i = 1; i <= 30; i++) {
      search_guest_options.push(
        i < 30 ? <option value={i} key={i}> {i} Guest </option> : <option value={i} key={i}> {i}+ Guest </option>
      )
    }
    
    let lat_array = []
    this.state.search_result.map((room, index) => {
      if (room && room.latitude)
        lat_array.push(parseFloat(room.latitude))
    })
    let lng_array = []
    this.state.search_result.map((room, index) => {
      if (room && room.longitude)
        lng_array.push(parseFloat(room.longitude))
    })

    let max_maplatitude = lat_array.length ? Math.max(...lat_array) : 0
    let min_maplatitude = lat_array.length ? Math.min(...lat_array) : 0
    let max_maplongitude = lng_array.length ? Math.max(...lng_array) : 0
    let min_maplongitude = lng_array.length ? Math.min(...lng_array) : 0
    return   <section className="listingsearch_">
    <div className="container-fluid">
      {/* listing-searchbar start */}
      <div className="listing-searchbar">
        <div className="row">
          <div className="col-md-6 col-sm-8">
            <div className="row">
              <div className="col-md-3  col-sm-6">
                <div className="field-wrapper">
                  <img src="img/where.svg" alt /> 
                  <label className="form-label" htmlFor="where">Where</label>
                  <input id="where" type="text" className="form-in" placeholder="Where" required />
                </div>
              </div>
              <div className="col-md-3  col-sm-6">
                <div className="field-wrapper">
                  <img src="img/calendar.svg" alt />
                  <label className="form-label" htmlFor="checkin">Check In</label>
                  <input id="checkin" type="text" className="form-in" placeholder="Check In" required />
                </div>
              </div>
              <div className="col-md-3  col-sm-6">
                <div className="field-wrapper">
                  <img src="img/calendar.svg" alt />
                  <label className="form-label" htmlFor="checkout">Check Out</label>
                  <input id="checkout" type="text" className="form-in" placeholder="Checkout" required />
                </div>
              </div>
              <div className="col-md-3  col-sm-6">
                <div className="field-wrapper">
                  <img src="img/avatar.svg" alt />
                  <label className="form-label" htmlFor="guests">Guests</label>
                  <select name="State" className="form-in">
                    <option selected>Select Guests</option>
                    <option value={1}>1</option>
                    <option value={2}>2</option>
                    <option value={3}>3</option>
                    <option value={4}>4</option>
                  </select>
                </div>    
              </div>
            </div>
          </div>
          <div className="col-md-6 col-sm-4">
            <div className="listing-more-filter">
              <button><img src="img/filter.svg" alt /> More Filters</button>
            </div>
          </div>
        </div>
      </div>
      {/* listing-searchbar end */}
      {/* More filter section */}
      <div className="listing-morefilter">
        <div className="row">
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Property Type</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt />Common Amenities</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Additional Amenities</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Special Features</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
        </div>
        <div className="row">
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Home Safety</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt />Kitchen</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Indoor/Outdoor activities nearby </h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Leisure</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
        </div>
        <div className="row">
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Swimming Pools</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Ideal For</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Household</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> IT &amp; Communication</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
        </div>
        <div className="row">
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Activities Nearby</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
          <div className="col-md-3 col-sm-6">
            <h3><img src="img/house.svg" alt /> Transportation</h3>
            <div className="listing-morefilter-list">
              <ul>
                <li>
                  <label><input type="checkbox" /> Apartment <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> House <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Townhouse <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Condominium <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Cabin <span /></label>   
                </li>
                <li>
                  <label><input type="checkbox" /> Villa <span /></label>   
                </li>
              </ul>
            </div>  
          </div>
        </div>
      </div>
      {/* More filter section */}
      {/* listing-searchbar start */}
      <div className="listing-map-list">
        <div className="row">
          <div className="col-md-7 col-sm-12">
            <div className="listing-list-mainparent">
              <div className="listing-list-main">
                <div className="listing-left-img">
                  <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                </div> 
                <div className="listing-right-content">
                  <a href>
                    <div className="listing-list-topbar">
                      <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                      <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                      <p>Caboose in Taney County</p>
                      <button>Listing Details</button>
                    </div>
                    <div className="listing-list-btmbar">
                      <div className="listing-price">
                        <h3><span>$</span>179</h3>
                      </div>
                      <div className="listing-dates">
                        <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                      </div>
                    </div>
                  </a>
                </div>  
              </div> 
              <div className="listing-list-main">
                <div className="listing-left-img">
                  <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                </div> 
                <div className="listing-right-content">
                  <a href>
                    <div className="listing-list-topbar">
                      <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                      <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                      <p>Caboose in Taney County</p>
                      <button>Listing Details</button>
                    </div>
                    <div className="listing-list-btmbar">
                      <div className="listing-price">
                        <h3><span>$</span>179</h3>
                      </div>
                      <div className="listing-dates">
                        <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                      </div>
                    </div>
                  </a>
                </div>  
              </div>
              <div className="listing-list-main">
                <div className="listing-left-img">
                  <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                </div> 
                <div className="listing-right-content">
                  <a href>
                    <div className="listing-list-topbar">
                      <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                      <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                      <p>Caboose in Taney County</p>
                      <button>Listing Details</button>
                    </div>
                    <div className="listing-list-btmbar">
                      <div className="listing-price">
                        <h3><span>$</span>179</h3>
                      </div>
                      <div className="listing-dates">
                        <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                      </div>
                    </div>
                  </a>
                </div>  
              </div>
              <div className="listing-list-main">
                <div className="listing-left-img">
                  <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                </div> 
                <div className="listing-right-content">
                  <a href>
                    <div className="listing-list-topbar">
                      <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                      <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                      <p>Caboose in Taney County</p>
                      <button>Listing Details</button>
                    </div>
                    <div className="listing-list-btmbar">
                      <div className="listing-price">
                        <h3><span>$</span>179</h3>
                      </div>
                      <div className="listing-dates">
                        <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                      </div>
                    </div>
                  </a>
                </div>  
              </div>    
            </div>  
            {/* <div class="listing-pagination">
                            <ul>
                                <li><a href=""><img src="img/left-arrow.svg" alt=""/></a></li>
                                <li><a href="">1</a></li>
                                <li><a href="">2</a></li>
                                <li><a href="">3</a></li>
                                <li><a href="">4</a></li>
                                <li><a href=""><img src="img/right-arrow.svg" alt=""/></a></li>
                            </ul>  
                        </div>    */}
          </div>
          <div className="col-md-5 col-sm-12">
            <div className="list-maparea">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    return <div>

      <div className="theme-hero-area">
        <div className="theme-hero-area-bg-wrap">
          <div className="theme-hero-area-bg-pattern theme-hero-area-bg-pattern-ultra-light" style={{ backgroundImage: 'url(http://remtsoy.com/tf_templates/tf-bookify-demo/img/patterns/travel/4.png)' }} />
          <div className="theme-hero-area-grad-mask" />
        </div>
        <div className="theme-hero-area-body">
          <div className="container">
            <div className="row  pt-2 pb-2">
              <div className="col-md-9 ">
                <div className="">
                  <div className="theme-hero-text theme-hero-text-white">
                    <div className="theme-hero-text-header">
                      <h2 className="theme-hero-text-title _mb-20 theme-hero-text-title-sm">{this.state.search_result.length ? this.state.total : ''} Vacation Homes in {this.state.page_data.meta_title ? this.state.page_data.meta_title : 'Location'}</h2>
                    </div>
                  </div>
                  <ul className="theme-breadcrumbs _mt-20">
                    <li>
                      <p className="theme-breadcrumbs-item-title">
                        <a href="javascript:;">Home</a>
                      </p>
                    </li>
                    <li>
                      <p className="theme-breadcrumbs-item-title">
                        <a href="javascript:;">Search Vacation Homes</a>
                      </p>
                    </li>
                    <li>
                      <p className="theme-breadcrumbs-item-title">
                        <a href="javascript:;">{this.state.page_data.meta_title ? this.state.page_data.meta_title : 'Location'}</a>
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="theme-page-section theme-page-section-gray pt-1">
        <div className="container">
          <div className="row row-col-static" id="sticky-parent" data-gutter={20}>
            <div className="w-100 ">
              <div className="sticky-col col-md-12 " style={{}}>

                <div className="theme-search-area pt-1 pl-4 pr-4 pb-4 _bg-p _br-4 _mb-10 _bsh theme-search-area-vert theme-search-area-white">
                  <div className="theme-search-area-form row" id="hero-search-form">
                    <div className="col-md-3 theme-search-area-section first theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border">
                      <label className="theme-search-area-section-label">Where</label>
                      <div className="theme-search-area-section-inner">
                        <i className="theme-search-area-section-icon fa fa-map-marker" />
                        <PlacesAutocomplete
                          value={this.state.page_data.meta_title ? this.state.page_data.meta_title : ''}
                          onChange={this.handleLocationChange}

                          onSelect={this.handleLocationSelect}
                        >
                          {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                            <div className="">
                              <input
                                {...getInputProps({
                                  placeholder: 'Where do you want to go?',
                                  className: "theme-search-area-section-input typeahead",
                                  name: "locations",
                                  type: "text",
                                  name: "locations",
                                  id: "location",
                                  autoComplete: "off",
                                })}
                              />
                              <div className="autocomplete-dropdown-container" style={{ position: 'absolute', width: '300px', zIndex: '10000', color: 'black' }}>
                                {loading && <div>Loading...</div>}
                                {suggestions.map(suggestion => {
                                  const className = suggestion.active
                                    ? 'suggestion-item--active'
                                    : 'suggestion-item';
                                  // inline style for demonstration purpose
                                  const style = suggestion.active
                                    ? { backgroundColor: '#fafafa', cursor: 'pointer', textAlign: 'left', paddingTop: '10px', padding: '10px', borderBottom: 'solid 1px gray' }
                                    : { backgroundColor: '#ffffff', cursor: 'pointer', textAlign: 'left', paddingTop: '10px', padding: '10px', borderBottom: 'solid 1px gray' };

                                  return (
                                    <div
                                      {...getSuggestionItemProps(suggestion, {
                                        className,
                                        style,
                                      })}
                                    >
                                      <span><i className='fa fa-map-marker'></i>&nbsp;&nbsp;{suggestion.formattedSuggestion.mainText}, <small>{suggestion.formattedSuggestion.secondaryText}</small></span>
                                    </div>
                                  );
                                })}

                                {suggestions.length ? <div className='text-right'><img src='https://vignette.wikia.nocookie.net/ichc-channel/images/7/70/Powered_by_google.png/revision/latest/scale-to-width-down/640?cb=20160331203712' width='50%' /></div> : ''}
                              </div>
                            </div>
                          )}
                          {/* custom render function */}
                        </PlacesAutocomplete>
                      </div>
                    </div>

                    <div className="col-md-3 ">
                      <div className="theme-search-area-section theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border">
                        <label className="theme-search-area-section-label">Check In</label>
                        <div className="theme-search-area-section-inner">
                          <i className="theme-search-area-section-icon lin lin-calendar" />
                          <Picker
                            onOpenChange={this.onStartOpenChange}
                            type="start"
                            showValue={this.state.page_data.checkin ? (this.state.page_data.checkin) : null}
                            open={this.state.startOpen}
                            value={[this.state.page_data.checkin ? (this.state.page_data.checkin) : null, this.state.page_data.checkout ? (this.state.page_data.checkout) : null]}
                            onChange={this.onStartChange}
                            disabledDate={(date) => this.disableDate(date)}
                            name='checkin'
                            id="checkin" className="theme-search-area-section-input datePickerStart " placeholder="Check In"
                          />
                        </div>
                      </div>
                    </div>
                    <div className="col-md-3 ">
                      <div className="theme-search-area-section theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border">
                        <label className="theme-search-area-section-label">Check Out</label>
                        <div className="theme-search-area-section-inner">
                          <i className="theme-search-area-section-icon lin lin-calendar" />
                          <Picker
                            onOpenChange={this.onEndOpenChange}
                            open={this.state.endOpen}
                            type="end"
                            showValue={this.state.page_data.checkout ? (this.state.page_data.checkout) : null}
                            disabledDate={this.disabledStartDate}
                            value={[this.state.page_data.checkin ? (this.state.page_data.checkin) : null, this.state.page_data.checkout ? (this.state.page_data.checkout) : null]}
                            onChange={this.onEndChange}
                            name='checkout'
                            id="checkout" readOnly="readonly" className="theme-search-area-section-input datePickerEnd " placeholder="Check Out"
                          />
                        </div>
                      </div>
                    </div>



                    <div className="col-md-3 ">
                      <div className="theme-search-area-section theme-search-area-section-curved theme-search-area-section-sm theme-search-area-section-fade-white theme-search-area-section-no-border quantity-selector" data-increment="Guests">
                        <label className="theme-search-area-section-label">Guests</label>
                        <div className="theme-search-area-section-inner">
                          <i className="theme-search-area-section-icon lin lin-people" />

                          <select className="theme-search-area-section-input" defaultValue={this.state.page_data.guest ? this.state.page_data.guest : 0} onChange={this.handleChangeGuest} type="text" >
                            {search_guest_options}
                          </select>
                        </div>
                      </div>
                    </div>
                    <div className="col-md-12 mt-4">
                      <InputRange
                        maxValue={this.state.page_data.max_price ? this.state.page_data.max_price : 5500}
                        minValue={this.state.page_data.min_price ? this.state.page_data.min_price : 0}
                        value={{ min: this.state.page_data.min_price_check ? this.state.page_data.min_price_check : 10, max: this.state.page_data.max_price_check ? this.state.page_data.max_price_check : 5000 }}
                        onChangeComplete={value => {
                          let page_data = this.state.page_data
                          page_data.min_price_check = value.min
                          page_data.max_price_check = value.max
                          this.setState({ page_data }, () => { this.handleSearch() })
                        }}
                        onChange={value => {
                          let page_data = this.state.page_data
                          page_data.min_price_check = value.min
                          page_data.max_price_check = value.max
                          this.setState({ page_data })
                        }

                        }
                        InputRangeClassNames = {{valueLabel : 'input-control'}} />
                    </div>

                  </div>
                </div>


              </div>
              <div className=" col-md-12">
                <div className="row">
                  <button className="btn btn-primary mx-auto" type="button" data-toggle="collapse" data-target="#moreFilter" aria-expanded="false" aria-controls="moreFilter">
                    More Filters
                   </button>

                   <div className='col-md-12 _desk-h search_tabs'>
                   <nav>
        <div className="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
          <a className="nav-item nav-link active" id="nav-search-tab" data-toggle="tab" href="#nav-search" role="tab" aria-controls="nav-search" aria-selected="true" onClick={()=>this.handleChangeViewMode(false)}>List</a>
          <a className="nav-item nav-link" id="nav-map-tab" data-toggle="tab" href="#nav-map" role="tab" aria-controls="nav-map" aria-selected="false" onClick={()=>this.handleChangeViewMode(true)}>Map</a>
        </div>
      </nav>
      </div>
                </div>


                <div className="collapse" id="moreFilter">
                  <div className="sticky-col row   " style={{}}> <div className="theme-search-results-sidebar col-md-12">
                    <div className="theme-search-results-sidebar-sections _mb-20 _br-2 theme-search-results-sidebar-sections-white-wrap   col-md-12">
                      {/* <div className="theme-search-results-sidebar-section">
                      <h5 className="theme-search-results-sidebar-section-title">Search Hotels</h5>
                      <div className="theme-search-results-sidebar-section-search">
                        <input className="theme-search-results-sidebar-section-search-input" type="text" placeholder="Hotel name, address" />
                        <a className="fa fa-search theme-search-results-sidebar-section-search-btn" href="#" />
                      </div>
                    </div> */}


                      <div className="theme-search-results-sidebar-section col-md-3">
                        <h5 className="theme-search-results-sidebar-section-title text-truncate">Property Type</h5>
                        <div className="theme-search-results-sidebar-section-checkbox-list">
                          <div className="collapse" id="SearchResultsCheckboxNeighborhoods">
                            <div className="theme-search-results-sidebar-section-checkbox-list-items theme-search-results-sidebar-section-checkbox-list-items-expand">
                              {
                                this.state.page_data.property_type_dropdown ?
                                  this.state.page_data.property_type_dropdown.map((property_type, index) => {
                                    return <div className="checkbox theme-search-results-sidebar-section-checkbox-list-item" key={index}>
                                      <label className="label-large label-inline amenity-label pos-rel">
                                        <input type="checkbox" className="comint" onChange={this.handleChangePropertyType} value={property_type.id} />
                                        <span className="comspn ml-2">{property_type.name}</span>
                                      </label>
                                    </div>
                                  })
                                  :
                                  <div></div>
                              }
                            </div>
                          </div>
                          <a className="theme-search-results-sidebar-section-checkbox-list-expand-link" role="button" data-toggle="collapse" href="#SearchResultsCheckboxNeighborhoods" aria-expanded="false">Show more
                          <i className="fa fa-angle-down" />
                          </a>
                        </div>
                      </div>
                      {
                        this.state.page_data.amenities_type ?
                          this.state.page_data.amenities_type.map((type, index) => {
                            return <div className="theme-search-results-sidebar-section col-md-3" key={index}>
                              <h5 className="theme-search-results-sidebar-section-title text-truncate">{type.name}</h5>
                              <div className="theme-search-results-sidebar-section-checkbox-list">
                                <div className="collapse" id={"SearchResultsCheckboxNeighborhoods" + type.id}>
                                  <div className="theme-search-results-sidebar-section-checkbox-list-items theme-search-results-sidebar-section-checkbox-list-items-expand">
                                    {

                                      this.state.page_data.amenities.map((amenity, index) => {
                                        if (amenity.type_id == type.id) {
                                          return <div className="checkbox theme-search-results-sidebar-section-checkbox-list-item" key={index}>
                                            <label className="label-large label-inline amenity-label pos-rel">
                                              <input type="checkbox" className="comint" onChange={this.handleChangeAmenity} value={amenity.id} />
                                              <span className="comspn ml-2">{amenity.name}</span>
                                            </label>
                                          </div>
                                        }
                                      })
                                    }
                                  </div>
                                </div>
                                <a className="theme-search-results-sidebar-section-checkbox-list-expand-link" role="button" data-toggle="collapse" href={"#SearchResultsCheckboxNeighborhoods" + type.id} aria-expanded="false">Show more
                              <i className="fa fa-angle-down" />
                                </a>
                              </div>
                            </div>

                          })
                          :
                          <div></div>
                      }
                    </div>

                  </div></div>
                </div>
              </div>

            </div>
            <div className="col-md-6 _mob-h">

              {this.state.is_search_now == false ?
                (
                  <div style={{ height: '90vh', width: '100%', overflowY: 'scroll', overflowX: 'hidden' }} className='_mob-h'>
                    {
                      this.state.search_result.map((room, index) => {
                        if (room)
                          return <div className="theme-search-results " key={index} onMouseEnter={() => this.handleResultHover(room.id)}
                            onMouseLeave={() => this.handleResultLeave(room.id)}>
                            <div className="_mob-h"><div className="theme-search-results-item theme-search-results-item-">
                              <div className="theme-search-results-item-preview">
                                <a className="theme-search-results-item-mask-link" role="button" /*  href={"#searchResultsItem-" + index} data-toggle="collapse" aria-expanded="false" aria-controls={"searchResultsItem-" + index}*/ />
                             
                                <div className="row" data-gutter={20}>
                                  <div className="col-md-5 ">
                                  {/* <h6 className="ribbon"> <span className='fa fa-star'></span>
                                        <b>{room.membership_name}</b></h6> */}
                                     
                                    <div className="theme-search-results-item-img-wrap">
                                      <ImageZoom
                                        image={{
                                          src: room.featured_image,
                                          alt: room.name,
                                          className: 'theme-search-results-item-img',
                                        }}
                                        zoomImage={{
                                          src: room.featured_image,
                                          alt: room.name
                                        }}
                                      />
                                    </div>
                                   {
                                     room.plan_type == 1 ? <div class="ribbon ribbon-top-left"><span>Featured</span>
                                     </div>   : null
                                   }
                                    
                                  
                                  </div>
                                  <div className="col-md-7 ">
                                    <div dangerouslySetInnerHTML={{ __html: room.overall_star_rating }}></div>
                                    <h5 className="theme-search-results-item-title theme-search-results-item-title-lg">{room.name}</h5>
                                    {
                                      room.review_count ?

                                        <div className="theme-search-results-item-hotel-rating">
                                          <p className="theme-search-results-item-hotel-rating-title">
                                            <b>{room.avg_rating}</b>&nbsp;({room.review_count} views)
                                </p>
                                        </div>
                                        : null}
                                    <p className="theme-search-results-item-location">
                                      <i className="fa fa-map-marker" />{room.city} / {room.state}  <ReactCountryFlag svg code={room.country} />
                                    </p>
                                    {/* <p className="theme-search-results-item-location">
                                  <i className="fa fa-map-marker" />Distance from {this.state.page_data.meta_title} : {this.getDistance(parseFloat(room.latitude),parseFloat(room.key_latitude), parseFloat(room.longitude), parseFloat(room.key_longitude))} Km
                                  </p> */}
                                    <p className="theme-search-results-item-location">
                                      <i className='fa fa-calendar' /> {room.subscription_start_date} ~ {room.subscription_end_date}
                                    </p>
                                    <p className="theme-search-results-item-hotel-book-count">{room.sub_name}
                                    </p>
                                   
                                    <div className="col-md-12 ">
                                    <div className="theme-search-results-item-book">
                                      <div className="theme-search-results-item-price">
                                        <p className="theme-search-results-item-price-tag"><span>{room.rooms_price.currency_code == 'USD' ? '$' : room.rooms_price.currency_code}</span><strong>{room.rooms_price.original_night}</strong></p>
                                        <p className="theme-search-results-item-price-sign">avg/night</p>
                                      </div>
                                      <a target="_blank" to={`/homes/${room.address_url}/${room.id}`} className="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" >Listing Detail</a>
                                    </div>
                                  </div>
                                  </div>

                                </div>
                              </div>
                              <div className="collapse theme-search-results-item-collapse" id={"searchResultsItem-" + index}>
                                <div className="theme-search-results-item-extend container">
                                  <a className="theme-search-results-item-extend-close" href={"#searchResultsItem-" + index} role="button" data-toggle="collapse" aria-expanded="false" aria-controls={"searchResultsItem-" + index}>✕</a>
                                  <div className="row">
                                    <div className="col-xs-12 col-lg-12 ">
                                      <nav>
                                        <div className="nav nav-tabs nav-fill" id={"nav-tab-" + index} role="tablist">
                                          <a className="nav-item nav-link active" id={"nav-detail-tab" + index} data-toggle="tab" href={"#nav-detail" + index} role="tab" aria-controls="nav-detail" aria-selected="true">Location</a>
                                          <a className="nav-item nav-link" id={"nav-profile-tab" + index} data-toggle="tab" href={"#nav-profile" + index} role="tab" aria-controls="nav-profile" aria-selected="false">Ratings</a>
                                          <a className="nav-item nav-link" id={"nav-contact-tab" + index} data-toggle="tab" href={"#nav-contact" + index} role="tab" aria-controls="nav-contact" aria-selected="false">Reviews</a>
                                          <a className="nav-item nav-link" id={"nav-about-tab" + index} data-toggle="tab" href={"#nav-about" + index} role="tab" aria-controls="nav-about" aria-selected="false">About</a>
                                        </div>
                                      </nav>
                                      <div className="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                        <div className="tab-pane  show active" id={"nav-detail" + index} role="tabpanel" aria-labelledby={"nav-detail-tab" + index}>
                                          <div className="row">
                                            <div className="col-md-6">
                                              <ImageZoom
                                                image={{
                                                  src: `https://maps.googleapis.com/maps/api/staticmap?size=570x275&center=${room.latitude},${room.longitude}&zoom=15&maptype=roadmap&sensor=false&key=AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs`,
                                                  alt: 'Location',
                                                  className: 'img img-responsive',
                                                }}
                                                zoomImage={{
                                                  src: `https://maps.googleapis.com/maps/api/staticmap?size=570x275&center=${room.latitude},${room.longitude}&zoom=15&maptype=roadmap&sensor=false&key=AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs`,
                                                  alt: 'Location'
                                                }}
                                              />

                                            </div>
                                            <div className="col-md-6">
                                              <p>
                                                Location :
                                                <strong><small>Address 1: </small>{room.address_line_1 ? room.address_line_1 : ''}</strong><br />
                                                <strong><small>Address 2: </small>{room.address_line_2 ? room.address_line_2 : ''} </strong><br />
                                                <strong><small>State : </small>{room.state ? room.state : ''}</strong><br />
                                                <strong><small>City : </small>{room.city ? room.city : ''} </strong><br />
                                                <strong><small>Country Name: </small>{room.country_name}</strong><br />
                                                <strong><small>Postal Code: </small>{room.postal_code}</strong><br />
                                                <strong><small>GeoCode: </small>{room.latitude}, {room.longitude}</strong><br />
                                              </p>
                                            </div>
                                          </div>
                                        </div>
                                        <div className="tab-pane " id={"nav-profile" + index} role="tabpanel" aria-labelledby={"nav-profile-tab" + index}>
                                          <div>Overall Rating : <div dangerouslySetInnerHTML={{ __html: room.overall_star_rating }}></div></div>
                                          <div>Accuracy Rating : <div dangerouslySetInnerHTML={{ __html: room.accuracy_star_rating }}></div></div>
                                          <div>Checkin Rating : <div dangerouslySetInnerHTML={{ __html: room.checkin_star_rating }}></div></div>
                                          <div>Location Rating : <div dangerouslySetInnerHTML={{ __html: room.location_star_rating }}></div></div>
                                          <div>Value Rating : <div dangerouslySetInnerHTML={{ __html: room.value_star_rating }}></div></div>
                                        </div>
                                        <div className="tab-pane " id={"nav-contact" + index} role="tabpanel" aria-labelledby={"nav-contact-tab" + index}>

                                          No Review Yet!
                                        </div>
                                        <div className="tab-pane " id={"nav-about" + index} role="tabpanel" aria-labelledby={"nav-about-tab" + index}>
                                          <div dangerouslySetInnerHTML={{ __html: room.summary }}></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>

                          </div>
                      })
                    }
                    <div className='row mt-3'></div>
                  </div>


                )






                :
                <ReactSpinner />


              }


<ReactPaginate

containerClassName="pagination w-100"
previousLabel={"prev"}
nextLabel={"next"}
breakLabel={"..."}
breakClassName={"break-me"}
pageCount={this.state.last_page}
marginPagesDisplayed={2}
pageRangeDisplayed={3}
onPageChange={this.handlePageClick}
subContainerClassName={"pages pagination"}
activeClassName={"active"} />

            </div>
            <div className='col-md-12 _desk-h'>
 
            <div className='row mt-3'><ReactPaginate

containerClassName="pagination w-100"
previousLabel={"previous"}
nextLabel={"next"}
breakLabel={"..."}
breakClassName={"break-me"}
pageCount={this.state.last_page}
marginPagesDisplayed={2}
pageRangeDisplayed={5}
onPageChange={this.handlePageClick}
subContainerClassName={"pages pagination"}
activeClassName={"active"} /></div>
 


    <div className={this.state.map_view_mode ? "_desk-h row _mob-h" : "_desk-h row"}>
                  {
                    this.state.is_search_now == false ?
                      this.state.search_result.map((room, index) => {
                        return <div className="theme-search-results-item _br-3 _mb-20 _bsh-xl theme-search-results-item-grid col-md-6 col-xs-12">
                        
                          <div className="banner _h-30vh banner-">
                            <div className="banner-bg" style={{ backgroundImage: `url(${room.featured_image})` }} />
                          </div>
                          <div dangerouslySetInnerHTML={{ __html: room.overall_star_rating }}></div>
                                    
                                   
                                    {/* <p className="theme-search-results-item-location">
                                  <i className="fa fa-map-marker" />Distance from {this.state.page_data.meta_title} : {this.getDistance(parseFloat(room.latitude),parseFloat(room.key_latitude), parseFloat(room.longitude), parseFloat(room.key_longitude))} Km
                                  </p> */}
                                   
                                   
                                   
                          <div className="theme-search-results-item-grid-body">
                            <a className="theme-search-results-item-mask-link" href="#" />
                           
                            <div className="theme-search-results-item-grid-header">
                              
                              <h5 className="theme-search-results-item-title _fs">{room.name}</h5>
                            </div>
                           
                           
                            <div className="theme-search-results-item-grid-caption">
                              <div className="row" data-gutter={10}>
                              <div className='col-xs-12'>
                                  <h6>  <i className="fa fa-map-marker" />{room.city} / {room.state}  <ReactCountryFlag svg code={room.country} /></h6>
                              </div>
                              <div className='col-xs-12'>
                                  <h6>  <i className='fa fa-calendar' /> {room.subscription_start_date} ~ {room.subscription_end_date}</h6>
                              </div>
                              <div className='col-xs-12'>
                                  <h6>  <i className='fa fa-calendar' /> {room.sub_name}</h6>
                              </div>
                              <div className='col-xs-12'>
                              {
                                      room.review_count ?
                                      <div className="col-xs-9 ">
                                   <div dangerouslySetInnerHTML={{ __html: room.overall_star_rating }}></div>
                                  <div className="theme-search-results-item-hotel-rating">
                                    <div className="theme-search-results-item-hotel-rating-title">
                                      <b>{room.avg_rating}</b>
                                      <br />{room.review_count} Reviews {room.review_count == 0 ? 'Yet' : ''}
                                    </div>
                                  </div>
                                </div>
                         
                            : null}
                              </div>
                            
                         
                                
                              
                                
                                <div className="col-xs-12 ">
                                  <div className="theme-search-results-item-price">
                                    <div className="theme-search-results-item-price-tag"><span>{room.rooms_price.currency_code == 'USD' ? '$' : room.rooms_price.currency_code}</span><strong>{room.rooms_price.original_night}</strong></div>
                                    <div className="theme-search-results-item-price-sign">avg/night</div>
                                  </div>
                                </div>
                                <div className="col-md-12 ">
                                    <div className="theme-search-results-item-book">
                                      
                                      <a target="_blank" to={`/homes/${room.address_url}/${room.id}`} className="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" >Listing Detail</a>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      })
                      :
                      <ReactSpinner />
                  }
                </div> 
 

          </div>
          <div className={this.state.map_view_mode ? 'col-md-6' : 'col-md-6 _mob-h'}>
              {
                this.state.page_data.cLat ?
                  <div style={{ height: '90vh', width: '100%' }} id="search_google_map">
                    <SearchMap
                      data={this.state.search_result}
                      handleMapChange={this.handleMapChange}
                      defaultCenter={this.state.map_center ? this.state.map_center : { lat: (max_maplatitude + min_maplatitude) / 2 ? (max_maplatitude + min_maplatitude) / 2 : this.state.page_data.cLat, lng: (max_maplongitude + min_maplongitude) / 2 ? (max_maplongitude + min_maplongitude) / 2 : this.state.page_data.cLong }}
                      zoom={this.state.map_zoom ? this.state.map_zoom : (this.state.search_result.length ? this.getBoundsZoomLevel({ lat: max_maplatitude, lng: max_maplongitude }, { lat: min_maplatitude, lng: min_maplongitude }) : 11)}
                      hover_room={this.state.hover_room}
                    >
                    </SearchMap>
                  </div>


                  : <div>GoogleMap</div>
              }
            </div>
        </div>
      </div>
    </div>
    </div>
  }
}

export default Search