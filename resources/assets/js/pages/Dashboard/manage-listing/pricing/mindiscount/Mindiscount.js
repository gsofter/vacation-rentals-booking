import React from 'react';

class Mindiscount extends React.Component {
    render(){
        return(
            <div className="add_early mb-3">
            <div className="row">
            <div style={{display: 'none'}} className="js-saving-progress saving-progress price_rules-last_min-saving">
                <h5>Saving... </h5>
            </div>
            <div ng-init="last_min_items = []; lm_errors= [];">
                <div className="add_early_bird"> <a href="javascript:void(0)" className="btn btn-success" ng-click="add_price_rule('last_min')"> + Add Last min discounts </a> </div>
            </div>
            </div>
        </div>
        )
    }
}

export default Mindiscount;