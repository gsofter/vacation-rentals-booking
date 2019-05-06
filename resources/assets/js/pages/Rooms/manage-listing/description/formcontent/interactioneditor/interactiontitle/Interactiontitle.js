import React from 'react';

class Interactiontitle extends React.Component {
    render(){
        return(
            <div className="row">
                <div className="col-8">
                <label className="label-large">Interaction with Guests</label>
                </div>
                <div className="col-4">
                <div className="pull-right h6" ng-show="!interaction_overflow"><span ng-init="interaction_len=0; interaction_limit=5000" className="ng-binding">{5000-this.props.value.replace(/<\/?[^>]+(>|$)/g, "").length}</span> characters left</div>
                </div>
            </div>
        )
    }
}

export default Interactiontitle;