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
    constructor(props){
        super(props)
    }
    render(){
        return(
            <form className="ng-pristine ng-valid ng-valid-maxlength">
                <div className="js-section list_hover">
                    <Propertytitle title={this.props.data.name ? this.props.data.name  : ''} onChange={this.props.handleChangeTitle} />
                    <Propertyeditor value={this.props.data.summary ? this.props.data.summary : ''} name='summary'   onChange={this.props.handleChangeSummary} />
                </div>
                <div className="js-section list_hover">
                    <h4 className="row-space-top-0 row-space-1">The Space</h4>
                    <Guesteditor value={this.props.data.room_description ? this.props.data.room_description.access : ''} name='access' onChange={this.props.onDescriptionChange}/>
                    <Interactioneditor value={this.props.data.room_description ? this.props.data.room_description.interaction : ''} name='interaction'  onChange={this.props.onDescriptionChange}/>
                    <Othereditor value={this.props.data.room_description ? this.props.data.room_description.notes : ''} name='notes'  onChange={this.props.onDescriptionChange}/>
                    <Houseeditor value={this.props.data.room_description ? this.props.data.room_description.house_rules : ''} name='house_rules' onChange={this.props.onDescriptionChange}/>
                </div>
                <hr className="row-space-top-6 row-space-5 more_details_hr" />
                <div className="js-section list_hover col-sm-12">
                    <h4 className="row-space-top-0 row-space-1">The Neighborhood</h4>
                    <Overvieweditor value={this.props.data.room_description ? this.props.data.room_description.neighborhood_overview : ''} name='neighborhood_overview' onChange={this.props.onDescriptionChange}/>
                    <Gettingeditor value={this.props.data.room_description ? this.props.data.room_description.transit : ''} name='transit' onChange={this.props.onDescriptionChange}/>
                </div>
            </form>
        )
    }
}

export default Formcontent;