import React from 'react';
import Interactiontitle from './interactiontitle/Interactiontitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Interactioneditor extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="row-space-2">
                <Interactiontitle value={this.props.value}/>
                <MyStatefulEditor  value={this.props.value} onChange={(value) => this.props.onChange(this.props.name ? this.props.name : 'texteditor_for_description', value)}/>
            </div>
        )
    }
}

export default Interactioneditor;