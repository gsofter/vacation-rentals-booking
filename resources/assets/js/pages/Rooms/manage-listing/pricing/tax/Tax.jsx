import React from 'react';

class Tax extends React.Component {
    constructor(props){
        super(props)
    }

    render(){
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Tax rate:</h4>
                </div>
                <div className="base_text">
                    <div className="col-xl-6 col-lg-12 base_amut bottom_space clearfix">
                        <label className="h6">Enter your Tax rate</label>
                        <div className="base_pric" ng-init="tax=''">
                        <input type="text" data-extras="true" id="autosavetax" name="tax"  className="input-stem input-large" data-saving="additional-saving" value={this.props.value ? this.props.value : ''} onChange={this.props.onChange} />
                        <div className="price_doller raja-bhaiya-right">%</div>
                        </div>
                        {/* <p className="help-block-error ng-hide" ng-show="tax_invalid">Tax must be number</p> */}
                        <p data-error="tax" className="ml-error hide" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Tax;