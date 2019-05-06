import React from 'react'

class AmenitiesInfo extends React.PureComponent {
    constructor(props) {
        super(props)
    }
    render() {
        let bedroom_list = this.props.bedrooms ? this.props.bedrooms : []
        bedroom_list = bedroom_list.map((bedroom) => {
            let bedroom_details = JSON.parse(bedroom.bedroom_details)
            let detail_list = []
            for (var i in bedroom_details) {
                if (bedroom_details[i] > 0) {
                    detail_list.push(<label key={i}>{i} {bedroom_details[i]}</label>)
                }
            }

            console.log(bedroom_details)
            return <li key={bedroom.id}>
                <span>{bedroom.bedroom_name} : </span>
                <label>{detail_list}</label>
            </li>
        })
        let bathroom_list = this.props.bathrooms ? this.props.bathrooms : []
        bathroom_list = bathroom_list.map((bathroom) => {
            // let bedroom_details = JSON.parse(bedroom.bedroom_details)
            // let detail_list = []
            // for (var i in bedroom_details) {
                // if (bedroom_details[i] > 0) {
                    // detail_list.push(<label>{i} {bedroom_details[i]}</label>)
                // }
            // }

            // console.log(bedroom_details)
            return <li key={bathroom.id} >
                <span>{bathroom.bathroom_name} : </span>
                <label>type {bathroom.bathroom_type} {bathroom.bathfeature ? bathroom.bathfeature : ''}</label>
            </li>
        })
        return (<div className='row'>
            <div className='col-md-12 space-top-sm-2 lang-chang-label col-sm-12'>
                <div className="info_title">Property Id: <strong>{this.props.room_detail ? this.props.room_detail.id : 'Nan'}</strong></div>
                <ul className="right-space rj_the_space">
                    <li>
                        <div className="rj_list_head"><span>Bedrooms: </span></div>
                        <ul className="rj_list_dist">
                            {bedroom_list}
                        </ul>
                    </li>
                    <li>
                        <div className="rj_list_head"><span>Bathrooms: </span></div>
                        <ul className="rj_list_dist">
                            {bathroom_list}
                        </ul>
                    </li>            
                </ul>
                { this.props.room_detail && this.props.room_detail.bed_type_name ? <div class="info_title">Property type: <strong>{this.props.room_detail.bed_type_name}</strong></div> : ''}
                <div className="info_title">bedrooms: <strong>  {this.props.room_detail ? this.props.room_detail.bedrooms : ''}</strong></div> 
                <div className="info_title">property_type: <strong>{this.props.room_detail ? this.props.room_detail.property_type_name : ''} </strong></div>
                <div className="info_title">accommodates: <strong>  {this.props.room_detail ? this.props.room_detail.accommodates : ''}</strong></div>
            </div>
        </div>)
    }
}
export default AmenitiesInfo