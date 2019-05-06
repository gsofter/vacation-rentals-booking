import React from 'react';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Propertyeditor extends React.Component {
    render(){
        return(
            <div id="help-summary">
                <div className="row">
                    <div className="col-8">
                        <label className="label-large">Property Summary <b className="requiredRJ">*</b></label>
                    </div>
                    <div className="col-4">
                        <div className="pull-right h6" ><span className="ng-binding">10000</span> characters left</div>
                    </div>
                </div>
                <MyStatefulEditor/>
            </div>
           
        )
    }
}

export default Propertyeditor;