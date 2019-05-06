import React from 'react'
import './roomdetail.css'
import { BrowserRouter as Router, Route ,Link} from 'react-router-dom';
class RoomDetail extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        return <div className="room_detail_map">
        {/* <button></button> */}
        <img className="img-responsive" src={this.props.room_data.featured_image}/>
        <h6 className="room_detail_title_map">{this.props.room_data.name}</h6>
        {/* <p className="room_detail_description_map" dangerouslySetInnerHTML={{ __html : this.props.room_data.summary }}></p> */}
        <a href={`/homes/${this.props.room_data.address_url}/${this.props.room_data.id}`}  className="btn btn-primary-inverse btn-block theme-search-results-item-price-btn" >Listing Detail</a>
        </div>
    }
}

export default RoomDetail