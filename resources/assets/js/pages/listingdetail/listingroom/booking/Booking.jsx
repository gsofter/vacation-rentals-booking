import React from 'react';
import Wishlist from './Wishlist'
import axios from 'axios'
import { BrowserRouter as Router, Route ,Link} from 'react-router-dom';
import moment from 'moment';
import 'moment/locale/zh-cn';
import 'moment/locale/en-gb';
import zhCN from 'rc-calendar/lib/locale/zh_CN';
import enUS from 'rc-calendar/lib/locale/en_US';
import RangeCalendar from 'rc-calendar/lib/RangeCalendar';
import DatePicker from 'rc-calendar/lib/Picker';
const format = 'MM-DD-YYYY';
const fullFormat = 'MM-DD-YYYY';
const cn = location.search.indexOf('cn') !== -1;
import InputRange from 'react-input-range';
import 'react-input-range/lib/css/index.css'
import 'rc-calendar/assets/index.css';
import ChatModal from 'react-responsive-modal';
import 'react-spinning-wheel/dist/style.css';
import ReactCountryFlag from "react-country-flag";
import ReactPaginate from 'react-paginate';
import { ReactSpinner } from 'react-spinning-wheel';
const now = moment();
// import './booking.scss'
import Chathistory from './Chathistory';
import Chatbox from './Chatbox';
import {connect} from 'react-redux'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import {openChatBoxAction} from '../../../../actions/chatmodule/chatmoduleActions'
import {
  FacebookShareButton,
  GooglePlusShareButton,
  LinkedinShareButton,
  TwitterShareButton,
  TelegramShareButton,
  WhatsappShareButton,
  PinterestShareButton,
  VKShareButton,
  OKShareButton,
  RedditShareButton,
  TumblrShareButton,
  LivejournalShareButton,
  MailruShareButton,
  ViberShareButton,
  WorkplaceShareButton,
  LineShareButton,
  EmailShareButton,
} from 'react-share';
import {
  FacebookIcon,
  TwitterIcon,
  TelegramIcon,
  WhatsappIcon,
  GooglePlusIcon,
  LinkedinIcon,
  PinterestIcon,
  VKIcon,
  OKIcon,
  RedditIcon,
  TumblrIcon,
  LivejournalIcon,
  MailruIcon,
  ViberIcon,
  WorkplaceIcon,
  LineIcon,
  EmailIcon,
} from 'react-share';
now.locale('en-gb').utcOffset(0);
const metas = document.getElementsByTagName('meta');
class Picker extends React.PureComponent {
  constructor(props) {
    super(props)
    this.state = {
      hoverValue: [],
      latLng: { lat: 0, lng: 0 },
    
    };

    this.onHoverChange = this.onHoverChange.bind(this)

  }


  onHoverChange(hoverValue) {

    this.setState({ hoverValue });
  }

  render() {
    const props = this.props;
    const { showValue } = props;
    const calendar = (
      <RangeCalendar
        hoverValue={this.state.hoverValue}
        onHoverChange={this.onHoverChange}
        type={this.props.type}
        defaultValue={now}
        format={format}
        onChange={props.onChange}
        disabledDate={props.disabledDate}
      />);
    return (
      <DatePicker
        open={this.props.open}
        onOpenChange={this.props.onOpenChange}
        calendar={calendar}
        minDate={moment()}
        value={props.value}
      >
        {
          () => {
            return (
              <input
                className={props.className}
                placeholder={props.placeholder}
                readOnly
                type="text"
                name={props.name}
                value={showValue && showValue.format(fullFormat) || ''}
              />
            );
          }
        }
      </DatePicker>);
  }
}
class Booking extends React.PureComponent {
    constructor(props){
        super(props);
        this.state = {
            room_id : this.props.room_id,
            startValue: null,
            endValue: null,
            startOpen: false,
            endOpen: false,
            checkin : null,
            checkout : null,
            number_of_guests : 1,
            is_pricing : false,
            price_result : {},
            is_chat_modal_open : false,
            message : '',
            chat_history : [],
            isLogedIn : metas['isLogedin'].content
        }
        this.onStartOpenChange = this.onStartOpenChange.bind(this)
        this.onEndOpenChange = this.onEndOpenChange.bind(this)
        this.onStartChange = this.onStartChange.bind(this)
        this.onEndChange = this.onEndChange.bind(this)
        this.disabledStartDate = this.disabledStartDate.bind(this)
        this.handleChange = this.handleChange.bind(this)
        this.handlePriceCalculate = this.handlePriceCalculate.bind(this)
        this.openChatModal = this.openChatModal.bind(this)
        this.RequestBook = this.RequestBook.bind(this)
        
     
    }
    openChatModal(){
      if(metas['isLogedin'].content == 'true'){
         
        if(this.props.user_details.id != metas['LogedUserId'].content){
          axios.get('/ajax/chat/getContactId/' + this.props.user_details.id + '/' + metas['LogedUserId'].content)
          .then(result =>{
            const contactID = result.data
            this.props.openChatBoxAction(contactID)
          })
        }
        else{
          toast.error('This is your listing.')
        }
        
      }
      else{
        // open login modal
      }
    }
    handleChange(e){
        let name = e.target.name
        let value = e.target.value
        this.setState({
            [name] : value,
            is_pricing : true
        }, ()=>{
          this.handlePriceCalculate()
        })
        
    }
   
    onStartOpenChange(startOpen) {
        this.setState({
          startOpen,
        });
      }
    
      onEndOpenChange(endOpen) {
        this.setState({
          endOpen,
        });
        
      }
    
      onStartChange(value) {
        let checkin=   value[0]
        this.setState({
            checkin : checkin,
          startOpen: false,
          is_pricing : true,
          endOpen: true,
        });
        this.handlePriceCalculate()
      }
    
      onEndChange(value) {
        let {checkin, checkout, number_of_guests} = this.state
          checkout=  value[1]
        this.setState({
            checkout : checkout,
            is_pricing : true
        });
        axios.post('/ajax/rooms/price_calculation', {checkin : checkin, checkout : checkout, guest_count : number_of_guests, room_id : this.props.room_id})
        .then(result => {
            this.setState({
                price_result : result.data,
                is_pricing : false
            })
        })
      }
    
      disabledStartDate(endValue) {
        if (!endValue) {
          return false;
        }
        const startValue = this.state.startValue;
        if (!startValue) {
          return false;
        }
        return endValue.diff(startValue, 'days') < 0;
      }
      disableDate(date) {
        let selected_date = date;
    
        let now = moment();
    
        let diff_day = now.diff(selected_date, 'days')
    
        if (diff_day > 0) {
          return true
        }
        else {
          return false
    
        }
      }
      handlePriceCalculate(){
          let {checkin, checkout, number_of_guests} = this.state
          if(checkin !=null && checkout != null){
              axios.post('/ajax/rooms/price_calculation', {checkin : checkin, checkout : checkout, guest_count : number_of_guests, room_id : this.props.room_id})
              .then(result => {
                this.setState({
                    price_result : result.data,
                    is_pricing : false
                })
              })
          }
      }
      RequestBook(){
        if(this.state.isLogedIn){
          if(this.props.user_details.id != metas['LogedUserId'].content){
          let  {checkin , checkout , number_of_guests } = this.state
          let request_user_id =  metas['LogedUserId'].content
          if(checkin !=null && checkout != null){
            axios.post('/ajax/book/request/' +  this.props.room_id, 
            {
              checkin : checkin, checkout : checkout, guest_count : number_of_guests, room_id : this.props.room_id, request_user_id : request_user_id
            }).then(result =>{
              if(result.data.status == 'success')
              {
                toast.success(result.data.message)
              }
              else{
                toast.error(result.data.message)
              }
            })
          }
        }
        else{
            toast.error('This is your listing')
        }
         
        }
        else{
          alert("You can request after Login")
        }

      }
    render(){
      let accommodates_array = []
      for(let ii =1 ; ii <= this.props.room_detail.accommodates; ii ++){
        accommodates_array.push(
          <option value={ii} key={ii}>{ii}</option>
        )
      }
        return(
            <div className="col-lg-4 col-sm-12" style={{top:'1px'}}>
                  <ToastContainer/>
                <form onSubmit={this.handleSubmit}>
                
                    <div id="pricing" style={{position: 'relative', top: '-40px'}}>
                        <div id="price_amount" className="book-it-price-amount pull-left h3 text-special">
                            <span className="lang-chang-label">$</span> 
                            <span id="rooms_price_amount" className="lang-chang-label" >200</span>
                        </div>
                    </div>
                    <div id="book_it" className="display-subtotal" style={{top: '-1px'}}>
                        <div className="panel book-it-panel">
                            <div className="panel-body panel-light">
                                <div className="form-fields">
                                    <div className="row row-condensed space-1">
                                        <div className="col-md-9 col-sm-12 lang-chang-label">
                                            <div className="row row-condensed">
                                                <div className="col-sm-6 space-1-sm lang-chang-label">
                                                    <label htmlFor="checkin"><font style={{verticalalign: 'inherit'}}><font style={{verticalalitge: 'inherit'}}>
                                                    Check in
                                                    </font></font></label>
                                                    <Picker
                                                        onOpenChange={this.onStartOpenChange}
                                                        type="start"
                                                        showValue={this.state.checkin ? (this.state.checkin) : null}
                                                        open={this.state.startOpen}
                                                        value={[this.state.checkin ? (this.state.checkin) : null, this.state.checkout ? (this.state.checkout) : null]}
                                                        onChange={this.onStartChange}
                                                        disabledDate={(date) => this.disableDate(date)}
                                                        name='checkin'
                                                        id="checkin" className="checkin ui-datepicker-target hasDatepicker" placeholder="Check In"
                                                        />

                                                    
                                                </div>
                                                <div className="col-sm-6 space-1-sm">
                                                    <label htmlFor="checkout"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                                                        Check out
                                                        </font></font></label>
                                                        <Picker
                                                            onOpenChange={this.onEndOpenChange}
                                                            open={this.state.endOpen}
                                                            type="end"
                                                            showValue={this.state.checkout ? (this.state.checkout) : null}
                                                            disabledDate={this.disabledStartDate}
                                                            value={[this.state.checkin ? (this.state.checkin) : null, this.state.checkout ? (this.state.checkout) : null]}
                                                            onChange={this.onEndChange}
                                                            name='checkout'
                                                            id="checkout" readOnly="readonly" className="checkout ui-datepicker-target hasDatepicker" placeholder="Check Out"
                                                            />
                                                     
                                                </div>
                                            </div>
                                        </div>
                                        <div className="col-md-3 col-sm-12 book_select">
                                            <label htmlFor="number_of_guests"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                                                Guests
                                                </font></font></label>
                                            <div className="select select-block">
                                            <select id="number_of_guests" name="number_of_guests" onChange = {this.handleChange} value = {this.state.number_of_guests}>
                                               {accommodates_array}
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="js-book-it-status">

                                    <div className="js-book-it-enabled clearfix">
                                        {this.state.is_pricing ?  <ReactSpinner /> : null}
                                        {this.state.price_result.status == 'Available' ? 
                                         <div className="js-subtotal-container book-it__subtotal panel-padding-fit" style={{}}>
                                         <table className="table table-bordered price_table">
                                           <tbody>
                                             <tr>
                                               <td className="pos-rel room-night">
                                                 <span className="lang-chang-label"> $</span>
                                                 <span className="lang-chang-label" id="rooms_price_amount_1" value>{this.state.price_result.base_rooms_price}</span> <span className="lang-chang-label">  x </span><span id="total_night_count" value>{this.state.price_result.total_nights}</span> Night
                                                 <i id="service-fee-tooltip" rel="tooltip" className="icon icon-question" title="Average nightly rate is rounded" />
                                               </td>
                                               <td>
                                                 <span className="lang-chang-label">$</span>
                                                 <span id="total_night_price" value>{this.state.price_result.total_night_price}</span>
                                               </td>
                                             </tr>
                                             <tr className="early_bird booking_period text-beach" style={{display: 'none'}}>
                                               <td>
                                                 <span className="booked_period_discount" value>0</span>% early bird discount
                                               </td>
                                               <td>
                                                 $
                                                 <span className="booked_period_discount_price" value>0</span>
                                               </td>
                                             </tr>
                                             <tr className="last_min booking_period text-beach" style={{display: 'none'}}>
                                               <td>
                                                 <span className="booked_period_discount" value>0</span>%
                                                 last min discount
                                               </td>
                                               <td>
                                                 $<span className="booked_period_discount_price" value>0</span>
                                               </td>
                                             </tr>
                                             <tr className="weekly text-beach" style={{display: 'none'}}>
                                               <td>
                                                 <span id="weekly_discount" value>0</span>% weekly price discount
                                               </td>
                                               <td>
                                                 $<span id="weekly_discount_price" value>0</span>
                                               </td>
                                             </tr>
                                             <tr className="monthly text-beach" style={{display: 'none'}}>
                                               <td>
                                                 <span id="monthly_discount" value>0</span>% monthly price discount
                                               </td>
                                               <td>-
                                                 $<span id="monthly_discount_price" value>0</span>
                                               </td>
                                             </tr>
                                             <tr className="long_term text-beach" style={{display: 'none'}}>
                                               <td>
                                                 <span id="long_term_discount" value>0</span>% length of stay discount
                                               </td>
                                               <td>
                                                 -$<span id="long_term_discount_price" value>0</span>
                                               </td>
                                             </tr>
                                             {
                                               this.state.price_result.additional_guest ? 
                                               <tr className="additional_price"  >
                                               <td>
                                                 Additional Guest fee <i rel="tooltip" className="icon icon-question" title="
                                                                     If reservation is for more than 6 guests, a $0 fee per additional guest will be applied.
                                                                   " />
                                               </td>
                                               <td>
                                                 $<span id="additional_guest" value>{this.state.price_result.additional_guest}</span>
                                               </td>
                                             </tr>
                                             : null
                                             }
                                             
                                             {
                                               this.state.price_result.security_fee ? 
                                               <tr className="security_price" style={{display: 'table-row'}}>
                                               <td>
                                                 Security fee <i id="service-fee-tooltip" rel="tooltip" className="icon icon-question" title="This is the security deposit amount charged by the host.  Please see the host's, cancellation/refund policy for additional terms" />
                                               </td>
                                               <td>
                                                 $<span id="security_fee" value>{this.state.price_result.security_fee}</span>
                                               </td>
                                             </tr>
                                             : null
                                             }
                                             
                                             <tr className="cleaning_price" style={{display: 'table-row'}}>
                                               <td>
                                                 Cleaning fee
                                               </td>
                                               <td>
                                                 $<span id="cleaning_fee" value>{this.state.price_result.cleaning_fee}</span>
                                               </td>
                                             </tr>
                                            
                                             {
                                               this.state.price_result.additional ? 
                                               (
                                                 this.state.price_result.additional.map((additional, index) =>{
                                                  return <tr key={index} className="cleaning_price" style={{display: 'table-row'}}>
                                                  <td>
                                                    {additional.label}
                                                  </td>
                                                  <td>
                                                    $<span id="cleaning_fee" value>{additional.price}</span>
                                                  </td>
                                                </tr>
                                                
                                                 })
                                               )
                                               :
                                               null
                                             }
                                              <tr className="taxes_price" style={{display: 'table-row'}}>
                                               <td>
                                                 Taxes <i id="taxes-fee-tooltip" rel="tooltip" className="icon icon-question" title="Tax Charges" />
                                               </td>
                                               <td>$
                                                 <span id="total_taxes_pay" value>{this.state.price_result.total_taxes_pay}</span>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>Total </td>
                                               <td>
                                                 <span className="lang-chang-label">$</span><span id="total" value>{this.state.price_result.total}</span>
                                               </td>
                                             </tr>
                                           </tbody>
                                         </table>
                                       </div>
                                       : null}
                                       {this.state.price_result.status && this.state.price_result.status == 'Not available'  ? this.state.price_result.error : null}
                                        <div className="js-book-it-btn-container row-space-top-2 ">
                                            <button type="button" id="request_book_btn" className="js-book-it-btn btn btn-large btn-block btn-primary" onClick={this.RequestBook}>
                                            <span className="book-it__btn-text "><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                                                    Request to Book
                                                </font></font></span>
                                            </button>
                                            <input type="hidden" name="instant_book" defaultValue="request_to_book" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="panel wishlist-panel">
                            <div className="panel-body panel-light">
                                <Wishlist roomId={this.props.room_id}/>
                                
                                <div id="contact_wrapper" className="row-space-top-3 text-center">
                                    <button id="host-profile-contact-btn" className="btn btn-small btn-primary" type="button" onClick={()=>this.openChatModal()}><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                                        Contact host
                                        </font></font></button>
                                </div>
                                <div className="other-actions  text-center">
                                    <div className="social-share-widget space-top-3 p3-share-widget">
                                        <span className="share-title text-center"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                                            Share:
                                        </font></font></span>
                                        
                                        <div className="text-center">
                                             <div className='d-inline-block'>
                                             <FacebookShareButton url={document.location.href}>
                                              <FacebookIcon size={32} round={true} />
                                             </FacebookShareButton>
                                             </div>
                                             <div className='d-inline-block'> 
                                             <TwitterShareButton url={document.location.href}>
                                              <TwitterIcon size={32} round={true} />
                                             </TwitterShareButton>
                                             </div>
                                             <div className='d-inline-block'>
                                             <GooglePlusShareButton url={document.location.href}>
                                             <GooglePlusIcon size={32} round={true} />
                                             </GooglePlusShareButton>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        );
    }
}

 
const mapStateToProps = state =>({
  ...state
})
const mapDispatchToProps = dispatch =>({
  openChatBoxAction : (contactID) => dispatch(openChatBoxAction(contactID)) ,
  // renderStopSidebarAction : () => dispatch(renderStopSidebarAction) 
})

export default connect(mapStateToProps, mapDispatchToProps)(Booking)