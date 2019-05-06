import React from 'react';

class Occupancy extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Base Occupancy and Charges per Add'l Guest</h4>
                </div>
                <div className="base_text" id="guest_charge_wrapper">
                <div className="col-xl-4 col-lg-12 base_amut bottom_space">
                    <label className="h6">Number of Max Occupants 
                    <i rel="tooltip" className="icon icon-question" title="The total number of guests your listing is able to accomodate." />
                    </label>
                    <div className="base_pric">
                    <input type="number" min={0} value={this.props.max_guests} onChange={this.props.handleRoomChange} id="price-max-guests" name="max_guests" className="autosubmit-text input-stem input-large" data-saving="additional-saving" />
                    </div>
                    <p data-error="max_guests" className="ml-error hide" />
                </div>
                <div className="col-xl-4 col-lg-12 base_amut bottom_space">
                    <label className="h6">Number of Base Occupants <i rel="tooltip" className="icon icon-question" title="The base number of guests allowed during a reservation before additional guest charges are applied." /></label>
                    <div className="base_pric">
                    <input type="number" min={0}  id="price-guests"  value={this.props.guests}  onChange={this.props.onChange} name="guests" className="autosubmit-text input-stem input-large" data-saving="additional-saving" />
                    </div>
                    <p data-error="guests" className="ml-error hide" />
                </div>
                <div className="col-xl-4 col-lg-12 base_amut bottom_space">
                    <label className="h6">Charges Per Add'l Guest</label>
                    <div className="base_pric">
                    <div className="base_pric">
                        <div className="price_doller input-prefix">{this.props.code}</div>
                        <input type="number" min={0} limit-to={9} data-extras="true" id="price-additional_guest"  value={this.props.additional_guest}  onChange={this.props.onChange} name="additional_guest" className="autosubmit-text input-stem input-large" data-saving="additional-saving" />
                    </div>
                    </div>
                    <p data-error="additional_guest" className="ml-error hide" />
                </div>
                </div>
            </div>
        )
    }
}

export default Occupancy;