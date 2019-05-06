import React from 'react';

class Weekend extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Set your weekend price:</h4>
                </div>
                <div className="base_text">
                    <div className=" col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 base_amut bottom_space">
                        <label className="h6">Weekend Price <i rel="tooltip" className="icon icon-question" title="Rate charged for weekend reservations.  Please note, if a reservation includes both a weekday & weekend your listing rate will be displayed as an average of the base nightly rate and the weekend rate." /></label>
                        <div className="base_pric">
                        <div className="price_doller input-prefix">{this.props.code}</div>
                        <input type="number" value={this.props.value} onChange={this.props.onChange} data-extras="true" id="price-weekend"  name="weekend" className="autosubmit-text input-stem input-large" data-saving="weekend-saving" />
                        </div>
                        <p data-error="weekend" className="ml-error" />
                    </div>
                    <div className=" col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 base_amut bottom_space">
                        <label className="h6">Select weekend days</label>
                        <div className="base_pric">
                        <select className="form-control border" name="weekenddays">
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