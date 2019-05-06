import React from 'react';
import Overviewtitle from './overviewtitle/Overviewtitle';
import MyStatefulEditor from '../../../mystatefuleditor/MyStatefulEditor';

class Overvieweditor extends React.Component {
    render(){
        return(
            <div className="row-space-2">
                <Overviewtitle/>
                <MyStatefulEditor/>
            </div>
        )
    }
}

export default Overvieweditor;