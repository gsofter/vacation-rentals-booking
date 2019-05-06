import React from 'react';
import SummaryExtend from './summaryextend/SummaryExtend';

class Roomdetail extends React.PureComponent {
    constructor(props){
        super(props);
    }

    render(){
        console.log('________________', this.props.room_detail)
        
        return(
            <div id="details" className="details-section webkit-render-fix">
                <SummaryExtend 
                room_id = {this.props.room_id}
                room_detail = {this.props.room_detail}
                //rooms_description={this.props.rooms_description} amenities_type={this.props.amenities_type} amenities={this.props.amenities} amenities_icon={this.props.amenities_icon} bathrooms={this.props.bathrooms} bedrooms={this.props.bedrooms}  house_type = {this.props.house_type}  />
                />
               
            </div>
        );
    }
}

export default Roomdetail;