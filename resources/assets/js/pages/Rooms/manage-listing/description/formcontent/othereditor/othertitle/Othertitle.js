import React from 'react';

class Othertitle extends React.Component {
    render(){
        return(
            <div className="row">
                <div className="col-8">
                <label className="label-large">Other Things to Note</label>
                </div>
                <div className="col-4">
                <div className="pull-right h6" ng-show="!notes_overflow"><span ng-init="notes_limit=5000" className="ng-binding">{5000-this.props.value.replace(/<\/?[^>]+(>|$)/g, "").length}</span> characters left</div>
                </div>
            </div>
        )
    }
}

export default Othertitle;