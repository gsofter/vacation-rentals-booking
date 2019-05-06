import React from 'react';

class Currency extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        let currency_items = this.props.data.map((currency) => {
            return <option key={currency.id} value={currency.code}>{currency.code}</option>
        })
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Set your default currency:</h4>
                </div>
                <div className="base_text">
                    <div className="col-md-6 base_amut bottom_space">
                        <label className="h6">Pick your default currency <i rel="tooltip" className="icon icon-question" title="Currency type displayed when guests view your listing" /></label>
                        <div className="base_select select"> 
                            <select name="currency_code" value={this.props.value} onChange={this.props.onChange}>
                                {currency_items}
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