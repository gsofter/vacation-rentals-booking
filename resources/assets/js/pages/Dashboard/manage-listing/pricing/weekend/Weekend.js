import React from 'react';

class Weekend extends React.Component {
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Set your weekend price:</h4>
                </div>
                <div className="base_text">
                    <div className="col-md-6 base_amut bottom_space">
                        <label className="h6">Weekend Price <i rel="tooltip" className="icon icon-question" title="Rate charged for weekend reservations.  Please note, if a reservation includes both a weekday & weekend your listing rate will be displayed as an average of the base nightly rate and the weekend rate." /></label>
                        <div className="base_pric">
                        <div className="price_doller input-prefix">p</div>
                        <input type="number" min={0} limit-to={9} data-extras="true" id="price-weekend" defaultValue name="weekend" className="autosubmit-text input-stem input-large" data-saving="weekend-saving" />
                        </div>
                        <p data-error="weekend" className="ml-error" />
                    </div>
                    <div className="col-md-6 base_amut bottom_space">
                        <label className="h6">Select weekend days</label>
                        <div className="base_pric">
                        <select className="rjpricesec" name="weekenddays">
                            <option value={1}> Friday - Saturday </option>
                            <option value={2}> Saturday - Sunday </option>
                            <option value={3}> Sunday </option>
                        </select>
                        </div>
                        <p data-error="weekenddays" className="ml-error" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Weekend;