import React from 'react';
import Interactiontitle from './interactiontitle/Interactiontitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Interactioneditor extends React.Component {
    render(){
        return(
            <div className="row-space-2">
                <Interactiontitle/>
                <MyStatefulEditor/>
            </div>
        )
    }
}

export default Interactioneditor;