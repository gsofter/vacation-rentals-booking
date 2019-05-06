import React from 'react';
import '../list.css';

class Transportationlist extends React.Component {
    render(){
        return(
            <div className="amenites_list">
                <div className="amenities_left">
                    <h3>Transportation</h3>
                    <p>Let your guests know beforehand what types of transportation there is or they will need</p>
                </div>
                <div className="amenities_right">
                    <div className="amenitie_poduct">
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Bus (Public)</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Car Essential </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Car not necessary</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Car Recommended</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Chauffeur</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Shuttle service (free)</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Shuttle service (paid)</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Taxi service</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Shuttle</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Valet Parking</span>     
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Transportationlist;