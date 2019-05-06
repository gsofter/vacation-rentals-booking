import React from 'react';

class Cleanfee extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Cleaning Fee: </h4>
                </div>
                <div className="base_text">
                <div className="col-xl-6 col-lg-12 base_amut bottom_space">
                    <label className="h6"> Cleaning fee</label>
                    <div className="base_pric">
                    <div className="price_doller input-prefix">{this.props.code}</div>
                    <input type="number" min={0} limit-to={9} data-extras="true" id="price-select-cleaning_fee" name="cleaning"  className="autosubmit-text input-stem input-large" data-saving="additional-saving" value={this.props.fee_value} onChange={this.props.onChange} />
                    </div>
                    <p data-error="cleaning" className="ml-error" />
                </div>
                <div className="col-xl-6 col-lg-12 base_amut">
                    <label className="h6">Cleaning Fee calculation</label>
                    <div className="base_select select">
                    <select name="cleaning_fee_type" data-saving="additional-saving" className="rjpricesec" value={this.props.type_value} onChange = {this.props.onChange}>
                        <option value={0}> Single Fee </option>
                        <option value={1}> Per Night </option>
                        <option value={2}> Per Guest </option>
                        <option value={3}> Per Night &amp; Guest </option>
                    </select>
                    </div>
                    <p data-error="cleaning_fee_type" className="ml-error" />
                </div>
                </div>
            </div>
        )
    }
}

export default Cleanfee;