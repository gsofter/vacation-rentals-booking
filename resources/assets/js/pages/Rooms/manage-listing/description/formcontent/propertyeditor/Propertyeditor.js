import React from 'react';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Propertyeditor extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div id="help-summary">
                <div className="row">
                    <div className="col-8">
                        <label className="label-large">Property Summary <b className="requiredRJ">*</b></label>
                    </div>
                    <div className="col-4">
                        <div className="pull-right h6" ><span className="ng-binding">{10000-this.props.value.replace(/<\/?[^>]+(>|$)/g, "").length}</span> characters left</div>
                    </div>
                </div>
                <MyStatefulEditor  value={this.props.value} onChange={(value) => this.props.onChange(this.props.name ? this.props.name : 'texteditor_for_description', value)}/>
            </div>
           
        )
    }
}

export default Propertyeditor;