import React from 'react';

class Currency extends React.Component {
    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Set your default currency:</h4>
                </div>
                <div className="base_text">
                    <div className="col-md-6 base_amut bottom_space">
                        <label className="h6">Pick your default currency <i rel="tooltip" className="icon icon-question" title="Currency type displayed when guests view your listing" /></label>
                        <div className="base_select select"> 
                            <select name="currency_code">
                                <option value="USD">USD</option>
                                <option value="GBP">GBP</option>
                                <option value="EUR">EUR</option>
                                <option value="AUD">AUD</option>
                                <option value="SGD">SGD</option>
                                <option value="SEK">SEK</option>
                                <option value="DKK">DKK</option>
                                <option value="MXN">MXN</option>
                                <option value="BRL">BRL</option>
                                <option value="MYR">MYR</option>
                                <option value="PHP">PHP</option>
                                <option value="CHF">CHF</option>
                                <option value="INR">INR</option>
                                <option value="ARS">ARS</option>
                                <option value="CAD">CAD</option>
                                <option value="CNY">CNY</option>
                                <option value="CZK">CZK</option>
                                <option value="HKD">HKD</option>
                                <option value="HUF">HUF</option>
                                <option value="IDR">IDR</option>
                                <option value="ILS">ILS</option>
                                <option value="JPY">JPY</option>
                                <option value="KRW">KRW</option>
                                <option value="NOK">NOK</option>
                                <option value="NZD">NZD</option>
                                <option value="PLN">PLN</option>
                                <option value="RUB">RUB</option>
                                <option value="THB">THB</option>
                                <option value="TRY">TRY</option>
                                <option value="TWD">TWD</option>
                                <option value="VND">VND</option>
                                <option value="ZAR">ZAR</option>
                            </select>
                        </div>
                        <p data-error="currency_code" className="ml-error" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Currency;