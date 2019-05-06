import React from 'react';
import Gettingtitle from './gettingtitle/Gettingtitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Gettingeditor extends React.Component {
    render(){
        return(
            <div>
                <Gettingtitle/>
                <MyStatefulEditor/>
            </div>
        )
    }
}

export default Gettingeditor;