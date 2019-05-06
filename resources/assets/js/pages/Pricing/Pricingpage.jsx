import React from 'react'
import axios from 'axios'
import './pricingtable.css'
import PricingList from './PricingList';
class Pricingpage extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            types : [],
            current_plan : ''
        }
    }
    componentDidMount(){
        axios.get('/ajax/membershiptypes')
        .then(result => {
            console.log(result)
            this.setState({
                types : result.data.data,
                current_plan : result.data.current_plan
            })
        })
    }
    render(){
        return <div><div className="container comparison mb-4">
        <table>
          <thead>
            <tr style={{borderTop : 'solid 1px gray'}}>
              <th className="tl"></th>
              {
                  this.state.types.map((type, index) => {
                        return  <th className="compare-heading" key={index}>
                        {type.Name}
                      </th>
                  })
              }
            </tr>
            <tr>
              <th className=""><h3>Listing Features	</h3></th>
              {
                  this.state.types.map((type, index) => {
                        return   <th className="price-info" key={index}>
                        {/* {type.original_fee != type.annual_fee ? <div className="price-was">Was ${type.original_fee}</div> : null} */}

                        <div className="price-now"><span>${type.annual_fee} </span> /year</div>
                        <div>
                            
                            
                        </div>
                      </th>
                  })
              }

             
              
            </tr>
          </thead>
          <tbody>
                <tr>
                    <td />
                    <td colSpan={4}>Availability calendar	</td>
                </tr>
                <PricingList title="Availability calendar" attribute = 'is_availability_calendar' types={this.state.types} />

                <tr>
                    <td />
                    <td colSpan={4}>Ranks above Bronze in search results</td>
                </tr>
                <PricingList title="Ranks above Bronze in search results" attribute = 'rank_above_bronze_in_search' types={this.state.types} />
         
                <tr>
                    <td />
                    <td colSpan={4}>Ranks above Silver in search results</td>
                </tr>
                <PricingList title="Ranks above Silver in search results" attribute = 'rnak_above_sliver_in_search' types={this.state.types} />
         
         
{/*          
                <tr>
                    <td />
                    <td colSpan={4}>Ranks above Basic in search results		</td>
                </tr>
                <PricingList title="Ranks above Basic in search results	" attribute = 'rank_above_basic_in_search' types={this.state.types} />
          */}
                <tr>
                    <td />
                    <td colSpan={4}>More inquiries than Bronze</td>
                </tr>
                <PricingList title="More inquiries than Bronze" attribute = 'average_inquiries_than_basic' types={this.state.types} />
         
                <tr>
                    <td />
                    <td colSpan={4}>Link to your personal website</td>
                </tr>
                <PricingList title="Link to your personal website" attribute = 'link_personal_website' types={this.state.types} />
         
         
                <tr>
                    <td />
                    <td colSpan={4}>Phone number published</td>
                </tr>
                <PricingList title="Phone number published" attribute = 'phone_number_published' types={this.state.types} />
         
         
                <tr>
                    <td />
                    <td colSpan={4}>Free special offers</td>
                </tr>
                <PricingList title="Free special offers" attribute = 'free_special_offers' types={this.state.types} />
         
         
               
         
                <tr>
                    <td />
                    <td colSpan={4}>Text message (SMS) inquiry alerts</td>
                </tr>
                <PricingList title="Text message (SMS) inquiry alerts" attribute = 'sms_inquiry_alerts' types={this.state.types} />
         
                <tr>
                    <td />
                    <td colSpan={4}>Free custom video</td>
                </tr>
                <PricingList title="Free custom video" attribute = 'free_custom_video' types={this.state.types} />
         
         
               
         
                <tr>
                    <td />
                    <td colSpan={4}>Ranks highest in search results</td>
                </tr>
                <PricingList title="Ranks highest in search results" attribute = 'rank_highest_in_search' types={this.state.types} />
         
         
                <tr>
                    <td />
                    <td colSpan={4}>Featured on home page</td>
                </tr>
                <PricingList title="Featured on home page" attribute = 'featured_on_home_page' types={this.state.types} />
         
          </tbody>
        </table>
      </div></div>
    }
}

export default Pricingpage