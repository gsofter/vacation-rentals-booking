import React from 'react';
import Gettingtitle from './gettingtitle/Gettingtitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Gettingeditor extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div>
                <Gettingtitle  value={this.props.value}/>
                <MyStatefulEditor  value={this.props.value} onChange={(value) => this.props.onChange(this.props.name ? this.props.name : 'texteditor_for_description', value)}/>
            </div>
        )
    }
}

export default Gettingeditor;