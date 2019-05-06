import React from 'react';
import '../list.css';

class Safetylist extends React.Component {
    render(){
        return(
            <div className="amenites_list">
                <div className="amenities_left">
                    <h3>Home Safety</h3>
                    <p>Smoke and carbon monoxide detectors are strongly encouraged for all listings.</p>
                </div>
                <div className="amenities_right">
                    <div className="amenitie_poduct">
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Smoke Detector</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Carbon Monoxide Detector</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">First Aid Kit</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Safety Card</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Fire Extinguisher</span>     
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Safetylist;