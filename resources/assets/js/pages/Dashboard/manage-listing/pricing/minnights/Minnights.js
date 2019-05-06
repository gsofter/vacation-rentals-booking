import React from 'react';

class Minnights extends React.Component {
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Minimum nights of booking required:</h4>
                </div>
                <div className="base_text">
                    <div className="col-md-6 base_amut bottom_space clearfix">
                        <label className="h6">Enter minimum night</label>
                        <div className="base_pric">
                        <input type="number" min={0} limit-to={9} data-extras="true" defaultValue={1} id="price-minimum_stay" name="minimum_stay" className="autosubmit-text input-stem input-large" data-saving="additional-saving" />
                        </div>
                        <p data-error="minimum_stay" className="ml-error" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Minnights;