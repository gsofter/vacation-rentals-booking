import React from 'react';

class Refundable extends React.Component {
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Refundable Damage Fee:</h4>
                </div>
                <div className="base_text">
                    <div className="col-md-6 base_amut bottom_space clearfix">
                        <label className="h6">Refundable Damage Fee</label>
                        <div className="base_pric">
                        <div className="price_doller input-prefix">p</div>
                        <input type="number" min={0} id="price-security" name="security" defaultValue className="autosubmit-text input-stem input-large" data-saving="additional-saving" />
                        </div>
                        <p data-error="security" className="ml-error hide" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Refundable;