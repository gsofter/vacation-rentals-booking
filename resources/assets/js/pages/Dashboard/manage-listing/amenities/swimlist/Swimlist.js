import React from 'react';
import '../list.css';

class Swimlist extends React.Component {
    render(){
        return(
            <div className="amenites_list">
                <div className="amenities_left">
                    <h3>Swimming Pools</h3>
                    <p>Select all the pools that are available to your guests</p>
                </div>
                <div className="amenities_right">
                    <div className="amenitie_poduct">
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Children's pool</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">indoor community pool </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Indoor pool private </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Infinity pool </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Jacuzzi </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Outdoor community pool </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Private Outdoor pool </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Private Outdoor pool heated</span>     
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Swimlist;