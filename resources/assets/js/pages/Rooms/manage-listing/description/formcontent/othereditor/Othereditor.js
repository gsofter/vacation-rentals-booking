import React from 'react';
import Othertitle from './othertitle/Othertitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Othereditor extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="row-space-2">
                <Othertitle  value={this.props.value}/>
                <MyStatefulEditor  value={this.props.value} onChange={(value) => this.props.onChange(this.props.name ? this.props.name : 'texteditor_for_description', value)}/>
            </div>
        )
    }
}

export default Othereditor;