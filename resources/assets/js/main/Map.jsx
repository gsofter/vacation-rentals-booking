import React from "react";
import ReactDOM from "react-dom";
import { compose, withProps } from "recompose";
import {
  withScriptjs,
  withGoogleMap,
  GoogleMap,
  Marker
} from "react-google-maps";
import PlacesAutocomplete from 'react-places-autocomplete';
const MyMapComponent = compose(
  withProps({
    /**
     * Note: create and replace your own key in the Google console.
     * https://console.developers.google.com/apis/dashboard
     * The key "AIzaSyBkNaAGLEVq0YLQMi-PYEMabFeREadYe1Q" can be ONLY used in this sandbox (no forked).
     */
    googleMapURL:
      "https://maps.googleapis.com/maps/api/js?key=AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs&v=3.exp&libraries=geometry,drawing,places",
    loadingElement: <div style={{ height: `100%` }} />,
    containerElement: <div style={{ height: `400px` }} />,
    mapElement: <div style={{ height: `100%` }} />
  }),
  withScriptjs,
  withGoogleMap
)(props => (
  <GoogleMap defaultZoom={8} defaultCenter={{ lat: -34.397, lng: 150.644 }}>
    {props.isMarkerShown && (
      <Marker position={{ lat: -34.397, lng: 150.644 }} />
    )}
  </GoogleMap>
));



ReactDOM.render(

<div>
    <PlacesAutocomplete
        value='florida'
        
        >
        {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
        <div className="">
            <input
            {...getInputProps({
                placeholder: 'Where do you want to go?',
                className: "form-in",
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
    <MyMapComponent isMarkerShown />
</div>
, document.getElementById("root"));
