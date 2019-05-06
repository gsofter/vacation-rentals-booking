import React from 'react';

class Nightly extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                    <h4>Set the default nightly price guests will see for your listing:</h4>
                </div>
                <div className="base_text">
                    <div className="col-md-6 base_amut bottom_space clearfix">
                        <label className="h6">Charges per night</label>
                        <div className="base_pric">
                        <div className="price_doller input-prefix">{this.props.code}</div>
                        <input type="number" value={this.props.value} onChange={this.props.onChange} data-suggested id="price-night" name="night" className="input-stem input-large autosubmit-text" data-saving="base_price" />
                        
                        </div>
                        <p data-error="night" className="ml-error" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Nightly;