import React from 'react';

class Monthly extends React.Component {
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                    <h4>Set your weekly and monthly price:</h4>
                </div>
                <div className="base_text">
                    <div className="col-md-6 base_amut bottom_space">
                        <label className="h6"> Weekly Price <i rel="tooltip" className="icon icon-question" title="Rate is based on a 7 night stay, each additional night is billed at the standard nightly rate up until the next 7 nights is reached for a single reservation." /></label>
                        <div className="base_pric">
                        <div className="price_doller input-prefix">p</div>
                        <input type="number" min={0} limit-to={9} data-extras="true" id="price-week" defaultValue name="week" className="autosubmit-text input-stem input-large" data-saving="additional-saving" />
                        </div>
                        <p data-error="week" className="ml-error" />
                    </div>
                    <div className="col-md-6 base_amut bottom_space">
                        <label className="h6">Monthly Price <i rel="tooltip" className="icon icon-question" title="Rate is based on a 30 night stay.  Each additional night is billed at the nightly rate, then weekly rate, until the next 30 nights is reached for a single reservation." /></label>
                        <div className="base_pric">
                        <div className="price_doller input-prefix">p</div>
                        <input type="number" min={0} limit-to={9} data-extras="true" defaultValue id="price-month" name="month" className="autosubmit-text input-stem input-large" data-saving="additional-saving" />
                        </div>
                        <p data-error="month" className="ml-error" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Monthly;