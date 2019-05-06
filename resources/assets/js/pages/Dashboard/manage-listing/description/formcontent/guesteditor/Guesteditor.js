import React from 'react';
import Guesttitle from './guesttitle/Guesttitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Guesteditor extends React.Component {
    render(){
        return(
            <div className="row-space-2">
                <Guesttitle/>
                <MyStatefulEditor/>
            </div>
        )
    }
}

export default Guesteditor;