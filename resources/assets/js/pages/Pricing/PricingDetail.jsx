import React from 'react'
import './pricingdetail.css'
import PlanOption from './PlanOption'
class PricingDetail extends React.PureComponent{
    constructor(props){
        super(props)

    }
    render(){
        return  <div className="price_table"> <div className="column_1">
        <ul>
          <li className="header_row_1 align_center">
            <div className="pack-title">{this.props.detail.Name}</div>
          </li>
          <li className="header_row_2 align_center">
            <div className="price"><span>${this.props.detail.annual_fee}<small>/MONTH</small></span></div>
          </li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.is_availability_calendar}/>Availability calendar</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.rank_above_basic_in_search}/>Ranks above Basic in search results	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.average_inquiries_than_basic}/>Averages 68% more inquiries than Basic	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.link_personal_website}/>Link to your personal website	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.phone_number_published}/>Phone number published	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.free_special_offers}/>Free special offers	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.rank_above_bronze_in_search}/>Ranks above Bronze in search results	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.sms_inquiry_alerts}/>Text message (SMS) inquiry alerts	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.rnak_above_sliver_in_search}/>Ranks above Silver in search results	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.rank_highest_in_search}/>Ranks highest in search results	</span></li>
          <li className="row_style_2 align_center"><span><PlanOption active={this.props.detail.featured_on_home_page}/>Featured on home page	</span></li>
        </ul></div></div>
    }
}

export default PricingDetail