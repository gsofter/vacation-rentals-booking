import React from 'react';

class Nightly extends React.Component {
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
                        <div className="price_doller input-prefix">p</div>
                        <input type="number" min={0} limit-to={9} data-suggested id="price-night" defaultValue name="night" className="input-stem input-large autosubmit-text" data-saving="base_price" />
                        <input type="hidden" id="price-night-old" defaultValue name="night_old" className="input-stem input-large autosubmit-text" />
                        </div>
                        <p data-error="night" className="ml-error" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Nightly;