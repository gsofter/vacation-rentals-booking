import React from 'react';
import '../list.css';

class Commonlist extends React.Component {
    render(){
        return(
            <div className="amenites_list">
                <div className="amenities_left">
                    <h3>Common Amenities</h3>
                </div>
                <div className="amenities_right">
                    <div className="amenitie_poduct">
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint" name="amenities"/>
                                <span className="comspn">Essentials</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">TV</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">Cable TV</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">Air Conditioning </span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  defaultValue={5} name="amenities"/>
                                <span className="comspn">Heating</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">Kitchen</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">Internet</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">Wireless Internet</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">Coffee Machine</span>     
                            </label>
                        </div>
                        <div className="col-md-6">
                            <label className="label-large label-inline amenity-label pos-rel">
                                <input type="checkbox" className="comint"  name="amenities"/>
                                <span className="comspn">Coffee Maker</span>     
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Commonlist;