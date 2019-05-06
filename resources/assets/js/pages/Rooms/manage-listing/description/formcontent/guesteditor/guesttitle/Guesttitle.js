import React from 'react';

class Guesttitle extends React.Component {
    render(){
        return(
            <div className="row">
                <div className="col-8">
                <label className="label-large">Guest Access</label>
                </div>
                <div className="col-4">
                <div className="pull-right h6" ng-show="!access_overflow"><span ng-init="access_limit=5000" className="ng-binding">{10000-this.props.value.replace(/<\/?[^>]+(>|$)/g, "").length}</span> characters left</div>
                </div>
            </div>
        )
    }
}

export default Guesttitle;