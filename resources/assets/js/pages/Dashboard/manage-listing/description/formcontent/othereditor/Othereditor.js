import React from 'react';
import Othertitle from './othertitle/Othertitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Othereditor extends React.Component {
    render(){
        return(
            <div className="row-space-2">
                <Othertitle/>
                <MyStatefulEditor/>
            </div>
        )
    }
}

export default Othereditor;