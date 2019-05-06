import React from 'react'
import { Route } from 'react-router-dom';
// import Header from '../Dashboard/components/Header/Header'
import Header from '../../common/header/Header'
import Footer from '../../common/footer/Footer'
import '../../main/new.css';
import axios from 'axios';
import PlacesAutocomplete, { geocodeByAddress, getLatLng } from 'react-places-autocomplete';
import { ToastContainer, toast } from 'react-toastify';
  import 'react-toastify/dist/ReactToastify.css';

class NewRooms extends React.Component {

   constructor(props) {
      super(props)
      this.state = {
         others: [],
         active_home_type: 0,
         active_accommodates: 0,
         selected_city: '',
         is_selected_home_type: false,
         is_selected_accommodates: false,
         is_selected_city: false,
         address: '',
         latLng: '',
         plan_type: [],
         property_type: [],
         room_type: []
      }
      this.handleChangeHometype = this.handleChangeHometype.bind(this)
      this.removeSelecedHomeType = this.removeSelecedHomeType.bind(this)
      this.handleChangeAccommodates = this.handleChangeAccommodates.bind(this)
      this.removeChangeAccommodates = this.removeChangeAccommodates.bind(this)
      this.handleSetCity = this.handleSetCity.bind(this)
      this.removeSelectedCity = this.removeSelectedCity.bind(this)
      this.handleChange = this.handleChange.bind(this)
      this.handleSelect = this.handleSelect.bind(this)
      this.handleSubmit = this.handleSubmit.bind(this)
       
   }
   
   componentDidMount() {
      axios.get('/ajax/rooms/new')
         .then(res => {

            let result = res.data;
            this.setState({
               plan_type: result.plan_type,
               property_type: result.property_type,
               room_type: result.room_type
            });
         })
   }

   handleChangeHometype(e) {
      // e.preventdefault();
      console.log(e.target.value)
      this.setState({
         active_home_type: e.target.value,
         is_selected_home_type: true
      })
   }

   handleChangeAccommodates(e) {
      console.log(e.target.value)
      this.setState({
         is_selected_accommodates: true,
         active_accommodates: e.target.value
      })
   }
   removeChangeAccommodates() {
      this.setState({
         is_selected_accommodates: false
      })
   }
   handleSetCity(e) {
      console.log(e.target.value)
      this.setState({
         is_selected_city: true,
         selected_city: e.target.value
      })
   }
   removeSelectedCity() {
      this.setState({
         is_selected_city: false,
         selected_city: '',
         address: '',
      })
   }
   removeSelecedHomeType(e) {
      this.setState({
         is_selected_home_type: false
      })
   }

   handleSubmit(event) {
      event.preventDefault();
      const post_data = {
         active_home_type: this.state.property_type[this.state.active_home_type].id,
         address: this.state.address,
         active_accommodates: this.state.active_accommodates,
         latitude: this.state.latLng.lat,
         longitude: this.state.latLng.lng,
         latlng: this.state.latLng
      }
      axios.post('/ajax/rooms/create', post_data)
         .then(res => {
            // console.log(res);
            console.log(res.data);
            if (res.data.status == 'success') {
             
               toast.success("New Room Created Successfully", {
                  position: toast.POSITION.TOP_RIGHT
                });
                this.props.history.push(res.data.redirect_url);
                  // history.push(res.data.redirect_url)
            }
            else{
               toast.error(res.data.message, {
                  position: toast.POSITION.TOP_RIGHT
                });
            }
         });
   }
   handleChange(address) {
      this.setState({ address });
   };
   handleSelect(address) {
      geocodeByAddress(address)
         .then(console.log('succsss', address))
         .then(results => getLatLng(results[0]))
         .then(latLng => {
            this.setState({
               address: address, latLng: latLng, is_selected_city: true,
               selected_city: address
            });
            console.log(this.state);
         })
         .catch(error => console.error('Error', error));
   };
   render() {
      let home_type_buttons = []
      let home_type_options = []
      let ii = 0;
      this.state.property_type.forEach(home_type => {
         if (ii < 3) {
            home_type_buttons.push(
               <button className="btn btn-large type alert-highlighted-element hover-select-highlight" type="button" key={ii} value={ii} onClick={this.handleChangeHometype}>
                  {/* <i className={"icon " + home_type.icon + " h4 icon-kazan mrg_left"} /> */}
                  <i className={"icon " + home_type.icon + " h4 icon-kazan mrg_left"} />
                  {home_type.name}
               </button>
            )
            ii++
         }
         else {
            home_type_options.push(
               <option data-icon-class="icon-star-alt" key={ii} value={ii}>
                  {home_type.name}
               </option>
            )
            ii++
         }
      })
      /////////////// Apartment, House, Bed & Breakfast, Other setting as hometype //////////////////////////////
      let home_type_section = !this.state.is_selected_home_type ? (
         <div className="btn-group" >
            {home_type_buttons}
            <div className="select select-large other-select" id="property-select">
               <select className="alert-highlighted-element hover-select-highlight ng-pristine ng-untouched ng-valid" id="property_type_dropdown" onChange={this.handleChangeHometype}>
                  <option>Other</option>
                  {home_type_options}
               </select>
            </div>
         </div>
      ) : (
            <div className="active-selection " onClick={this.removeSelecedHomeType} >
               <div data-type="property_type_id" className="selected-item property_type_id">
                  <div className="active-panel" ng-click="property_type_rm()">
                     <div className="active-title active-col">
                        <div className="h4 title-value ng-binding">

                           <i className={"icon " + this.state.property_type[this.state.active_home_type].icon + " h4 "} />
                           {this.state.property_type[this.state.active_home_type].name}

                        </div>
                     </div>
                     <div className="active-caret active-col">
                        <i className="icon icon-caret-right" />
                     </div>
                     <div className="active-message active-col">
                        {/* {this.state.home_type[this.state.active_home_type].description} */}
                        Vacation.Rentals----- guests love the variety of home types available.
               </div>
                  </div>
               </div>
            </div>
         )

      /////////////////// Person numbers setting as accommodate ///////////////////////////
      let accomodates_select = [];
      for(let i = 0 ; i < 30 ; i ++){
         accomodates_select.push(
            <option key={i} className="accommodates" data-accommodates={i+1} value={i + 1}>
            {i+1}
            </option>
         )
      }
      let accommodates_section = !this.state.is_selected_accommodates ? (<div className="unselected row row-condensed" ng-hide="selected_accommodates">
         <div className="col-sm-3">
            <div className="panel accommodates-panel">
               <div className="panel-body panel-light alert-highlighted-element hover-select-highlight">
                  <div className="col-sm-12" style={{ padding: '0px !important' }}>
                     <div className="select select-large" style={{ width: '100%' }}>
                        <i className="icon icon-group h4 icon-kazan va-middle icons-accommodates" />
                        <select id="accomodates-select" style={{ width: '100% !important' }} className="hover-select-highlight ng-pristine ng-untouched ng-valid" onChange={this.handleChangeAccommodates}>
                           <option>Select</option>
                           {
                              accomodates_select
                           }
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      ) : (
            <div className="active-selection ng-hide" ng-show="selected_accommodates" onClick={this.removeChangeAccommodates} >
               <div data-type="person_capacity" className="selected-item person_capacity">
                  <div className="active-panel">
                     <div className="active-title active-col">
                        <div className="h4 title-value ng-binding">
                           <i className="icon icon-kazan h4 icon-group" />
                           {this.state.active_accommodates}
                        </div>
                     </div>
                     <div className="active-caret active-col">
                        <i className="icon icon-caret-right" />
                     </div>
                     <div className="active-message active-col">
                        Whether you're hosting a lone traveler or a large group, it's important for your guests to feel comfortable.
               </div>
                  </div>
               </div>
            </div>);

      /////////////////// Location search as city section //////////////////////////
      let city_section = !this.state.is_selected_city ? (
         <div className="row col-sm-12">
            <div className="panel location lys-location alert-highlighted-element">
               <div className=" location-panel-body ">

                  {/* <input className="pull-left alert-highlighted-element geocomplete ng-pristine ng-untouched ng-valid" name="location_input" type="text"  placeholder="Enter a location" autoComplete="off"  id="location_input" onBlur={this.handleSetCity} /> */}

                  <PlacesAutocomplete
                     value={this.state.address}
                     onChange={this.handleChange}
                     onSelect={this.handleSelect}
                  >
                     {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                        <label className="input-placeholder-group w-100" style={{ paddingTop: '0px', paddingBottom: '0px' }}>

                           <input
                              {...getInputProps({
                                 placeholder: 'Enter a Location',
                                 className: 'pull-left alert-highlighted-element geocomplete ng-valid ng-dirty ng-touched',
                                 name: "locations",
                                 type: "text",
                                 name: "locations",
                                 id: "location",

                                 autoComplete: "off",
                              })}
                           />
                           <div className="autocomplete-dropdown-container" style={{ position: 'absolute', marginTop: '35px', width: '300px', background: 'white' }}>
                              {loading && <div>Loading...</div>}
                              {suggestions.map(suggestion => {
                                 const className = suggestion.active
                                    ? 'suggestion-item--active'
                                    : 'suggestion-item';
                                 // inline style for demonstration purpose
                                 const style = suggestion.active
                                    ? { backgroundColor: '#fafafa', cursor: 'pointer', textAlign: 'left', paddingTop: '10px', padding: '10px', borderBottom: 'solid 1px gray', background: 'white' }
                                    : { backgroundColor: '#ffffff', cursor: 'pointer', textAlign: 'left', paddingTop: '10px', padding: '10px', borderBottom: 'solid 1px gray', background: 'white' };
                                 console.log(suggestion)
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

               </div>
            </div>
         </div>

      ) : (
            <div className="active-selection ng-hide" ng-show="city_show" onClick={this.removeSelectedCity}>
               <div className="selected-item city" data-type="city">
                  <div className="active-panel" ng-click="city_rm()">
                     <div className="active-title active-col">
                        <div className="h4 title-value ng-binding">
                           <i className="icon icon-kazan h4 icon-map-marker" />
                           {this.state.selected_city}
                        </div>
                     </div>
                     <div className="active-caret active-col">
                        <i className="icon icon-caret-right" />
                     </div>
                     <div className="active-message active-col">
                        What a great place to call home
      </div>
                  </div>
               </div>
            </div>
         )

      ////////////////////////////// Search button with page migration and modal /////////////////////////////////////////////
      let search_button = ''
      if (this.state.is_selected_accommodates && this.state.is_selected_city && this.state.is_selected_home_type) {
         search_button =
            <div className="row text-left space-top-3">
               <div id="js-submit-button">
                  <div className="lys-continue-button-wrapper">
                     {/* <a href="/dashboard/managelist"  className="btn btn-primary btn-large btn-block submit" onClick={this.handleAdd}>
            Continue
         </a> */}
                     <input className="btn btn-primary btn-large btn-block submit" type="submit" value="Continue" />

                  </div>
               </div>
            </div>
      }
      return (
          
          
          
            <main id="site-content" role="main"  >
             <ToastContainer />
               <div className="page-container-full">
                  <div className="panel lys-panel-header">
                     <div className="panel-body panel-light">
                        <div className="row">
                           <div className="col-sm-10 col-center text-center">
                              <h1 className="h2" style={{ marginBottom: 0 }}>List your Home</h1>
                              <p className="text-lead" style={{ marginBottom: 3 }}>
                                 Vacation.Rentals----- lets you make money renting out your place.
                        </p>
                           </div>
                        </div>
                        <div />
                     </div>
                     <div className="panel-body panel-medium back-change">
                        <div className="page-container-responsive">
                           <div className="row">
                              <div className="col-lg-7 col-md-11 col-md-push-1 col-lg-push-2 list-space">
                                 <div id="alert-row" className="row">
                                    <div id="alert-status" className="col-lg-10 col-md-11 lys-alert" />
                                 </div>
                                 <form method="POST" onSubmit={this.handleSubmit} acceptCharset="UTF-8" className="host-onboarding-form ng-pristine ng-invalid ng-invalid-required" name="lys_new">

                                    <div className="row space-top-4 space-1">
                                       <div id="property-type-id-header" className="h5 text-light">
                                          <strong>
                                             Home Type
                                    </strong>
                                       </div>
                                    </div>
                                    <div className="row fieldset fieldset_property_type_id">
                                       {home_type_section}
                                    </div>
                                    <div className="row space-top-3 space-1">
                                       <div id="person-capacity-header" className="h5 text-light">
                                          <strong>
                                             Accommodates
                                    </strong>
                                       </div>
                                    </div>
                                    <div className="row fieldset fieldset_person_capacity">
                                       {accommodates_section}
                                    </div>
                                    <div className="row space-top-3 space-1">
                                       <div id="city-header" className="h5 text-light">
                                          <strong> Location </strong>
                                       </div>
                                    </div>
                                    <div className="row fieldset fieldset_city">
                                       {city_section}
                                    </div>
                                    {search_button}
                                    <div id="cohosting-signup-widget-banner" className="hide-sm hide-md" />
                                 </form>
                              </div>
                           </div>
                           <div className="space-5 row"> </div>
                        </div>
                     </div>
                     <div className="panel-medium back-change">
                        <div className="page-container-responsive col-center">
                           <div className="row">
                              <div className="col-md-4 text-center hand-icn space-5">
                                 <i className="icon icon-handshake icon-kazan icon-size-3" />
                                 <h4>Trust &amp; Experience</h4>
                                 <div className="text-lead text-color-light">
                                    As property owners ourselves, we at Vacation.Rentals are well versed in the vacation rental industry.  You can trust that we will provide you with the marketing tools and resources you need most when listing your properties.
                           </div>
                              </div>
                              <div className="col-md-4 text-center hand-icn space-5">
                                 <i className="icon icon-host-guarantee icon-kazan icon-size-3" />
                                 <h4>Convenience</h4>
                                 <div className="text-lead text-color-light">
                                    Your time is priceless. Listing with Vacation.Rentals saves your valuable time, allowing you to focus on what’s most important: Making sure your guests have the best experience possible
                           </div>
                              </div>
                              <div className="col-md-4 text-center hand-icn space-5">
                                 <i className="icon icon-lock icon-kazan icon-size-3" />
                                 <h4>Exposure</h4>
                                 <div className="text-lead text-color-light">
                                    Get the word out and showcase your property to our large community of guests, giving you the exposure you need to fill your vacancies.
                           </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </main>
            )
   }
}
export default NewRooms