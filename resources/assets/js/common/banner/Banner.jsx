import React from 'react';
import './banner.css';

import 'rc-calendar/assets/index.css';
import Calendar from 'rc-calendar';
import RangeCalendar from 'rc-calendar/lib/RangeCalendar';
import DatePicker from 'rc-calendar/lib/Picker';
import zhCN from 'rc-calendar/lib/locale/zh_CN';
import enUS from 'rc-calendar/lib/locale/en_US';
import PlacesAutocomplete from 'react-places-autocomplete';
import {
  geocodeByAddress,
  geocodeByPlaceId,
  getLatLng,
} from 'react-places-autocomplete';
import Autocomplete from 'react-google-autocomplete';
import moment from 'moment';
import 'moment/locale/zh-cn';
import 'moment/locale/en-gb';
import Masks from '../../components/ui_elements/Masks';
const format = 'MM-DD-YYYY';
const fullFormat = 'MM-DD-YYYY';
const cn = location.search.indexOf('cn') !== -1;

const now = moment();
now.locale('en-gb').utcOffset(0);





class Picker extends React.PureComponent {
  constructor(props) {
    super(props)
    this.state = {
      hoverValue: [],
      latLng: { lat: 0, lng: 0 }
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
        locale={cn ? zhCN : enUS}
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
                
                name={props.name}
                value={showValue && showValue.format(fullFormat) || ''}
              />
            );
          }
        }
      </DatePicker>);
  }
}
class Bannner extends React.PureComponent {

  constructor(props) {
    super(props)
    this.state = {
      startValue: null,
      endValue: null,
      startOpen: false,
      endOpen: false,
      width: 0,
      height: 0,
      address: ''
    }
    this.onStartOpenChange = this.onStartOpenChange.bind(this)
    this.onEndOpenChange = this.onEndOpenChange.bind(this)
    this.onStartChange = this.onStartChange.bind(this)
    this.onEndChange = this.onEndChange.bind(this)
    this.disabledStartDate = this.disabledStartDate.bind(this)
    this.handleChange = this.handleChange.bind(this)
    this.handleSelect = this.handleSelect.bind(this)
  }
  handleChange(address) {
    this.setState({ address });
  };

  handleSelect(address) {

    geocodeByAddress(address)
      .then(results => getLatLng(results[0]))
      .then(latLng => {
        this.setState({
          latLng: latLng
        })
      })
      .catch(error => console.error('Error', error));
    this.setState({ address })
  };
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
    this.setState({
      startValue: value[0],
      startOpen: false,
      endOpen: true,
    });
  }

  onEndChange(value) {
    this.setState({
      endValue: value[1],
    });
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
  componentWillMount() {
  }
  componentDidMount() {
  }
  componentWillUnmount() {
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
  render() {
    const state = this.state;
    let home_page_media = this.props.home_page_media

    let home_page_sliders = this.props.home_page_sliders.map((slider) => {
      return <li className="slider-image" key={slider.id} style={{ backgroundImage: `url(${slider.image_url})`, height: '100%', top: 'unset', backgroundSize: 'cover', backgroundPosition: 'center' }}>

      </li>
    })
    let search_guest_options = [];
    for (let i = 1; i <= 30; i++) {
      search_guest_options.push(
        i < 30 ? <option value={i} key={i}> {i} Guest </option> : <option value={i} key={i}> {i}+ Guest </option>
      )
    }
    return (

      <div className="hero shift-with-hiw js-hero">

        <div className="hero__background" data-native-currency="ZAR" aria-hidden="true">
          {
            home_page_media == 'Slider' ?
              <ul className="rslides" id="home_slider">
                {home_page_sliders}
              </ul>
              :
              <video autoplay loop="loop" id="pretzel-video" className="video-playing"></video>
          }

        </div>
        <div className="hero__content page-container page-container-full text-center" style={{ padding: '0px !important' }}>
          <div className="va-container va-container-v va-container-h">
            <div className="rjbanercont">
              <h3>
                <h1 className="left_cls white">Vacation Rentals From Owners And Property Managers</h1>
                <div className="hero-sub-text mt-15 white shadow-text d-flex justify-content-center">
                  <h1 className="text-container">
                    <div className="animated fadeIn mr-20 d-inline-block delay-4s slower">No Fees.</div>
                    <div className="animated zoomIn slower d-inline-block">No Commissions.</div>
                    <div className="animated fadeIn ml-20 d-inline-block delay-4s slower">100% Verified.</div>
                  </h1>
                </div>
              </h3>
            </div>
            <div className="va-middle">
              <div className="back-black">
                <h3>
                  {/* <span className="left_cls white">Vacation Rentals From Owners And Property Managers</span> */}

                </h3>
                <div className="show-sm hide-md sm-search">
                  <form id="simple-search" className="simple-search hide js-p1-simple-search">
                    <div className="alert alert-with-icon alert-error  hide space-2 js-search-error"><i className="icon alert-icon icon-alert-alt" />
                      Please set location
                  </div>
                    <label htmlFor="simple-search-location" className="screen-reader-only">
                      City, State, or Prop ID
                  </label>
                    <input type="text" placeholder="City, State,  Property ID" autoComplete="off" name="locations" id="simple-search-location" className="input-large js-search-location" />
                    <div className="row row-condensed space-top-2 space-2">
                      <div className="col-sm-6">
                        <label htmlFor="simple-search-checkin" className="screen-reader-only">
                          Check In
                      </label>

                        <input id="simple-search-checkin" type="text" name="checkin" className="input-large checkin js-search-checkin" placeholder="Check In" />
                      </div>
                      <div className="col-sm-6">
                        <label htmlFor="simple-search-checkout" className="screen-reader-only">
                          Check Out
                      </label>

                        <input id="simple-search-checkout" type="text" name="checkout" className="input-large checkout js-search-checkout" placeholder=" Check Out" />
                      </div>
                    </div>
                    <div className="select select-block space-2">
                      <label htmlFor="simple-search-guests" className="screen-reader-only">
                        Number of guests
                    </label>
                      <select id="simple-search-guests" name="guests" className="js-search-guests">
                        {search_guest_options}
                      </select>
                    </div>
                    <button type="submit" className="btn btn-primary btn-large btn-block">
                      messages.home.no_of_guest
                  </button>
                  </form>
                  <form className="input-addon js-p1-search-cta" id="sm-search-field" method="get" action='/search' id="searchbar-form" name="simple-search">

                    <PlacesAutocomplete
                      value={this.state.address}
                      onChange={this.handleChange}
                      onSelect={this.handleSelect}
                    >
                      {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                        <label className="input-stem input-large fake-search-field bg-transparent">
                          <div className="input-group mb-3">
                            <input
                              {...getInputProps({
                                placeholder: 'City, State,  Property ID',
                                className: 'menu-autocomplete-input text-truncate form-inline location input-large input-contrast form-control border border-primary',
                                name: "locations",
                                type: "text",
                                name: "locations",
                                id: "location",
                                autoComplete: "off",
                                required: 'true',

                              })}
                              style={{ borderRadius: '10px 10px 10px 10px' ,    padding:' 0px 0px 0px 10px'}}
                            />
                            {/* <input type="text" className=" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" /> */}
                            <div className="input-group-append" style={{ 
    position: 'absolute',
    right: '0px',
    border: 'none',
    height: 'calc(100% - 10px)',
    marginTop: '5px',
    right: '5px',
    zIndex: 1000
 }}>
                              <button className="btn btn-primary" style={{ borderRadius: '10px', margin : '0px' }} >Search</button>
                            </div>
                          </div>

                          <div className="autocomplete-dropdown-container" style={{ position: 'absolute', paddingLeft: '50px', width: '300px' }}>
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
                        </label>
                      )}
                      {/* custom render function */}
                    </PlacesAutocomplete>

                    {/* <span className="">
                   City, State, or Prop ID
                  </span> */}
                    {/* <button className='p-0 border-0 col-md-2 bg-transparent' ></button> */}
                  </form>

                </div>
              </div>
            </div>
          </div>
          <div className="hero__content-footer hide-sm d-md-flex justify-content-center">
            <div className="col-sm-8">
              <div id="searchbar">
                <div className="searchbar rjsearchbar" data-reactid=".1">
                  <form className="simple-search clearfix" method="get" action='/search' id="searchbar-form" name="simple-search">
                    <div className="saved-search-wrapper searchbar__input-wrapper">

                      <PlacesAutocomplete
                        value={this.state.address}
                        onChange={this.handleChange}
                        onSelect={this.handleSelect}
                      >
                        {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                          <label className="input-placeholder-group searchbar__location">
                            <span className="input-placeholder-label screen-reader-only">City, State,  Property ID</span>
                            {/* <input className="menu-autocomplete-input text-truncate form-inline location input-large input-contrast" 
          placeholder="City, State,  Property ID" 
         /> */}
                            <input
                              {...getInputProps({
                                placeholder: 'City, State,  Property ID',
                                className: 'menu-autocomplete-input text-truncate form-inline location input-large input-contrast',
                                name: "locations",
                                type: "text",
                                name: "locations",
                                id: "location",
                                autoComplete: "off",
                                required: 'true'
                              })}
                            />
                            <div className="autocomplete-dropdown-container" style={{ position: 'absolute', paddingLeft: '50px', width: '300px' }}>
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
                          </label>
                        )}
                        {/* custom render function */}
                      </PlacesAutocomplete>


                      <div className="searchbar__location-error hide">Please set location</div>
                      <label className="input-placeholder-group searchbar__checkin">
                        <span className="input-placeholder-label screen-reader-only">Check In</span>
                        <Picker
                          onOpenChange={this.onStartOpenChange}
                          type="start"
                          showValue={state.startValue}
                          open={this.state.startOpen}
                          value={[state.startValue, state.endValue]}
                          onChange={this.onStartChange}
                          disabledDate={(date) => this.disableDate(date)}
                          name='checkin'
                          id="checkin" className="checkin text-truncate input-large input-contrast ui-datepicker-target" placeholder="Check In"
                        />
                      </label>
                      <label className="input-placeholder-group searchbar__checkout">
                        <span className="input-placeholder-label screen-reader-only">Check Out</span>
                        <Picker
                          onOpenChange={this.onEndOpenChange}
                          open={this.state.endOpen}
                          type="end"
                          showValue={state.endValue}
                          disabledDate={this.disabledStartDate}
                          value={[state.startValue, state.endValue]}
                          onChange={this.onEndChange}
                          name='checkout'
                          id="checkout" readOnly="readonly" className="checkout input-large text-truncate input-contrast ui-datepicker-target" placeholder="Check Out"
                        />
                        {/* <input type="text" id="checkout"  readOnly="readonly" className="checkout input-large text-truncate input-contrast ui-datepicker-target" placeholder="Check Out" /> */}
                      </label>
                      <label className="searchbar__guests">
                        <span className="screen-reader-only">Number of guests</span>
                        <div className="select select-large">
                          <select id="guests" name="guests">
                            {search_guest_options}
                          </select>
                        </div>
                      </label>
                      <div id="autocomplete-menu-sbea76915" aria-expanded="false" className="menu hide" >
                        <div className="menu-section">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="source" defaultValue="bb" />
                    <button id="submit_location" type="submit" className="searchbar__submit btn btn-primary btn-large">Search</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* Bottom mask style 4 */}
        <Masks style='4' />
        {/*/ Bottom mask style 4 */}

      </div>
    )
  }
}

export default Bannner;