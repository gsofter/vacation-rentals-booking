import React from 'react';
import Housetitle from './housetitle/Housetitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Houseeditor extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="row-space-2">
                <Housetitle value={this.props.value} />
                <MyStatefulEditor  value={this.props.value} onChange={(value) => this.props.onChange(this.props.name ? this.props.name : 'texteditor_for_description', value)}/>
            </div>
        )
    }
}

export default Houseeditor;