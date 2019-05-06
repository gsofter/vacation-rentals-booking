import React from 'react';
import Accordion from '../components/Accordion'
import AmenitiesInfo from '../components/AmenitiesInfo'
import Amenities from '../components/Amenities'
import Description from '../components/Description'
import HouseRule from '../components/Description'
import SeasonalRateCalendar from '../components/SeasonalRateCalendar'
import Axios from 'axios';
class SummaryExtend extends React.PureComponent {
    constructor(props){
        super(props);
        this.state = {
            bathrooms : [],
            house_type : {},
            rooms_description : {}
        }
    }
    componentDidMount(){
        Axios.get(`/ajax/homes/housetype/${this.props.room_id}`)
        .then(Response =>{
            this.setState({
                house_type : Response.data.house_type
            })
        })
        Axios.get(`/ajax/homes/amenities_type/${this.props.room_id}`)
        .then(Response =>{
            this.setState({
                amenities : Response.data.amenities,
                amenities_icon : Response.data.amenities_icon,
                amenities_type : Response.data.amenities_type,
                safety_amenities : Response.data.safety_amenities,
            })
        })
        Axios.get(`/ajax/homes/descriptions/${this.props.room_id}`)
        .then(Response =>{
            this.setState({
                rooms_description : Response.data.rooms_description
            })
        })
    }
    render(){
        let accordion_list = [
            { title :  'The Space' , content :<AmenitiesInfo bathrooms={this.state.bathrooms ? this.state.bathrooms : []} bedrooms={this.state.bedrooms ? this.state.bedrooms : []} room_detail={this.props.room_detail}/> },
            { title : 'Amenities' , content : <Amenities amenities_type={this.state.amenities_type} amenities={this.state.amenities} amenities_icon={this.state.amenities_icon}/> },
            { title :  'Description' , content : <Description rooms_description={this.state.rooms_description}/> },
            { title :  'House Rules' , content : <HouseRule rooms_description={{ house_rule : this.state.rooms_description ? this.state.rooms_description.house_rules : ''}}/> },
            { title :  'Availability & Pricing' , content : <SeasonalRateCalendar room_id = {this.props.room_id} /> },
        ];
        return(
            <div id="summary-extend">
                <div className="col-lg-12 lang-chang-label col-sm-12 p-0" id="details-column">
                <h4 className="row-space-4 text-center-sm">
                    About this listing
                </h4>
                <div className="row row-condensed text-muted text-center">
                    <div className="col-md-3 col-sm-3 col-xs-4 roomty">
                    <i className="icon icon-entire-place icon-size-2" />
                    <div className="numfel">{this.state.house_type ? this.state.house_type.name : 'Nan'}</div>
                    </div>
                    <div className="col-md-3 col-sm-3 col-xs-3 roomty">
                    <i className="icon icon-group icon-size-2" />
                    <div className="numfel">{this.props.room_detail ? this.props.room_detail.accommodates : 0} Guests</div>
                    </div>
                    <div className="col-md-3 col-sm-3 col-xs-3 roomty">
                    <i className="icon icon-double-bed icon-size-2" />
                    <div className="numfel">{this.props.room_detail ? this.props.room_detail.bedrooms : 0}  Bedrooms</div>
                    </div>
                    <div className="col-md-3 col-sm-3 col-xs-3 roomty">
                    <i className="icon icon icon-bathtub icon-size-2" />
                    <div className="numfel"> {this.props.room_detail ? this.props.room_detail.bathrooms : 0}  Bathrooms</div>
                    </div>
                </div>
                <hr />
                <div className="summary_content description-container" dangerouslySetInnerHTML={{ __html : (this.props.room_detail ? this.props.room_detail.summary : '') }}>
                   
                </div>
                <Accordion data={accordion_list}/>

                <hr />
                </div>
            </div>
        );
    }
}

export default SummaryExtend;