import React from 'react';
import Propertytitle from './propertytitle/Propertytitle';
import Propertyeditor from './propertyeditor/Propertyeditor';
import Guesteditor from './guesteditor/Guesteditor';
import Interactioneditor from './interactioneditor/Interactioneditor';
import Othereditor from './othereditor/Othereditor';
import Houseeditor from './houseeditor/Houseeditor';
import Overvieweditor from './overvieweditor/Overvieweditor';
import Gettingeditor from './gettingeditor/Gettingeditor';


class Formcontent extends React.Component {
    render(){
        return(
            <form className="ng-pristine ng-valid ng-valid-maxlength">
                <div className="js-section list_hover">
                    <Propertytitle/>
                    <Propertyeditor/>
                </div>
                <div className="js-section list_hover">
                    <h4 className="row-space-top-0 row-space-1">The Space</h4>
                    <Guesteditor/>
                    <Interactioneditor/>
                    <Othereditor/>
                    <Houseeditor/>
                </div>
                <hr className="row-space-top-6 row-space-5 more_details_hr" />
                <div className="js-section list_hover col-sm-12">
                    <h4 className="row-space-top-0 row-space-1">The Neighborhood</h4>
                    <Overvieweditor/>
                    <Gettingeditor/>
                </div>
            </form>
        )
    }
}

export default Formcontent;