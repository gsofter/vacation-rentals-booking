import React from 'react';
import Guesttitle from './guesttitle/Guesttitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Guesteditor extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="row-space-2">
                <Guesttitle value={this.props.value}/>
                <MyStatefulEditor value={this.props.value} onChange={(value) => this.props.onChange(this.props.name ? this.props.name : 'texteditor_for_description', value)}/>
            </div>
        )
    }
}

export default Guesteditor;