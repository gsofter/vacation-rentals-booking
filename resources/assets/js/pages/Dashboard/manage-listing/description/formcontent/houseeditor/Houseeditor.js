import React from 'react';
import Housetitle from './housetitle/Housetitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Houseeditor extends React.Component {
    render(){
        return(
            <div className="row-space-2">
                <Housetitle/>
                <MyStatefulEditor/>
            </div>
        )
    }
}

export default Houseeditor;