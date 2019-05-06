import React from 'react';
import '../list.css';

class Itlist extends React.Component {
    render(){
        return(
            <div className="amenites_list">
                <div className="amenities_left">
                    <h3>IT &amp; Communication</h3>
                    <p>Tell your guests how they can stay connected to your property</p>
                </div>
                <div className="amenities_right">
                    <div className="amenitie_poduct">
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Bluetooth Speakers</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Computer</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Fax</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Internet access wired (Cat 5)</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities" />
                                <span className="comspn">Internet access (WiFi)</span>     
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Itlist;