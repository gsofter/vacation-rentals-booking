import React from 'react'
import './subscriptionroom.css'
import { BrowserRouter as Router, Redirect, Link } from 'react-router-dom';
import Header from "../../../../common/header/Header";
import StripeSubscribeRoom from './StripeSubscribeRoom'
import axios from 'axios'
import LoadingScreen from 'react-loading-screen';
import LoaingIcon from './icon_loading.png'
var ReactScriptLoaderMixin = require('react-script-loader').ReactScriptLoaderMixin;
import { Elements, StripeProvider } from 'react-stripe-elements';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import PayPalCheckout from './PaypalButton';
class SubscriptionRoom extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            listings: [],
            plan_type: {},
            plan_types: [],
            result: {},
            publish_listings: [parseFloat(this.props.match.params.roomId)],
            room_id: this.props.match.params.roomId,
            default_listing_fee: null,
            additional_fee: null,
            isLoading : true ,
            is_redirect : false
        }
        this.handleSelectListing = this.handleSelectListing.bind(this)
        this.onSubmit = this.onSubmit.bind(this)
        this.handleChangeMembership = this.handleChangeMembership.bind(this)
        this.SuccessPaypalSubscribe = this.SuccessPaypalSubscribe.bind(this)
    }
    componentDidMount() {
        axios.get('/ajax/rooms/getpublishlistings/' + this.props.match.params.roomId)
            .then(result => {
                console.log(result.data)
                this.setState({
                    listings: result.data.listings,
                    plan_types: result.data.plan_types,
                    result: result.data.result,
                    room_id: result.data.room_id,
                    // default_listing_fee: result.data.subscribed_listings.length ? result.data.plan_type.annual_fee / 2 : result.data.plan_type.annual_fee,
                    // additional_fee: result.data.plan_type.annual_fee / 2,
                    isLoading : false
                })
            })
    }
    SuccessPaypalSubscribe(listing_id){
        let listings = this.state.listings
        let publish_listings = this.state.publish_listings
        listings.map((listing, index) =>{
            if(listing.id == listing_id){
                listings[index].status = 'Subscribed'
            }
        })
        let listing_index = publish_listings.indexOf(listing_id);

        if (listing_index != -1) {
            publish_listings.splice(listing_index, 1)
        }
        this.setState({
            listings : listings,
            publish_listings : publish_listings
        })
    }
    handleSelectListing(event, listingId) {
        let { publish_listings } = this.state
        let listing_index = publish_listings.indexOf(listingId);

        if (listing_index != -1) {
            publish_listings.splice(listing_index, 1)
        }
        else {
            publish_listings.push(listingId)
        }
        this.setState({
            publish_listings: publish_listings
        })
    }

    handleChangeMembership(listing_index, listing_id, event) {
        let value = event.target.value
        let { listings } = this.state
        listings[listing_index].membership_type = value
        this.setState({
            listings: listings
        })

    }
    onSubmit(token, coupon_code) {
        console.log(token, coupon_code)
        if(token){
            let listings  = this.state.listings.map((listing) =>{
                if(listing.status !='Subscribed') return listing
            })
            axios.post('/ajax/rooms/post_subscribe_property/' + this.props.match.params.roomId, { token: token, coupon_code :coupon_code,  listings: listings, publish_listings: this.state.publish_listings })
                .then(result => {
                    console.log(result)
                    if(result.data.status == 'error'){
                        toast.error(result.data.message, {
                            position: toast.POSITION.TOP_RIGHT
                        });
                    }
                    if(result.data.status == 'success'){
                        toast.success("Subscribed successfully!", {
                            position: toast.POSITION.TOP_RIGHT
                        });
                        location.href = '/dashboard/rooms'
                       
                    }
                    else{
                        toast.error(result.data.message, {
                            position: toast.POSITION.TOP_RIGHT
                        });
                    }
                    
                    // location.href = '/dashboard/rooms'
                    // this.setState({
                    //     is_redirect : true
                    // })
                    
                })
        }
        else{
            toast.error("Cannot generate token!", {
                position: toast.POSITION.TOP_RIGHT
            });
        }
    }
    render() {
        console.log(this.state.listings, this.state.publish_listings, '________________________________')
        let total_price = 0;
        if(this.state.is_redirect){
            return <Redirect to='/dashboard/rooms' />
        }
        
        if(this.state.isLoading){
            return <LoadingScreen
            loading={true}
            bgColor='#f1f1f1'
            spinnerColor='#9ee5f8'
            textColor='#676767'
            logoSrc='https://cdn2.iconfinder.com/data/icons/large-svg-icons-part-2/512/real_estate_vector_symbol-512.png'
            text='Payment Initializing! Please wait a few seconds.'
          > </LoadingScreen>
        }
        else if(this.state.listings.length == 0){
            return <div className='container mt-5 p-5'>
                <h4>No rooms to publish!</h4>
            </div>
        }
        else return <main id="site-content" className="whole_list ng-scope border-top container" role="main">
            <ToastContainer />
            <div className="manage-listing-row-container row">
                <aside className="col-md-6 bg-primary row float-right">

                    <div className="container pt-5">
                        {
                            this.state.listings.map((listing, listing_index) => {
                                if (listing.id == this.props.match.params.roomId && listing.status != 'Subscribed') {
                                    return <div className="row listing_item pb-3" key={listing_index}>
                                        <div className="col-md-4">
                                            <a href="#">
                                                <img className="img-fluid rounded mb-3 mb-md-0" src={listing.featured_image} />
                                            </a>
                                        </div>
                                        <div className="col-md-8">
                                            <h3 className="listing_detail ml-0">{listing.name}</h3>
                                            <h3 className="listing_detail ml-0">ID:{listing.id}</h3>
                                            <div className="form-group row">
                                                <label className="col-md-4 text-white">Membership:</label>
                                                <select className="col-md-8 p-0 pl-2 bg-primary text-white" value={listing.membership_type} onChange={(e) => { this.handleChangeMembership(listing_index, listing.id, e) }} >
                                                    <option value={0}>Please Select</option>
                                                    {
                                                        this.state.plan_types.map((plan, index) => {
                                                            return <option key={index} value={plan.id}>{plan.Name}</option>
                                                        })
                                                    }
                                                </select>
                                            </div>
                                            <a className="redirect_to_listing" href="#">Manage Listing</a>
                                        </div>
                                    </div>
                                }
                            })
                        }
                        {
                            this.state.listings.map((listing, listing_index) => {
                                if (listing.id != this.props.match.params.roomId  && listing.status != 'Subscribed') {
                                    return <div className="row listing_item mt-3 pb-3" key={listing_index}>
                                        <div className="col-md-4">
                                            <a href="#">
                                                <img className="img-fluid rounded mb-3 mb-md-0" src={listing.featured_image} />
                                            </a>
                                        </div>
                                        <div className="col-md-8">
                                            <h3 className="listing_detail ml-0">{listing.name}</h3>
                                            <h3 className="listing_detail ml-0">ID:{listing.id}</h3>
                                            <div className="form-group row">
                                                <label className="col-md-4 text-white">Membership:</label>
                                                <select className="col-md-8 p-0 pl-2 bg-primary text-white" value={listing.membership_type} onChange={(e) => { this.handleChangeMembership(listing_index, listing.id, e) }} >
                                                    <option value={0}>Please Select</option>
                                                    {
                                                        this.state.plan_types.map((plan, index) => {
                                                            return <option key={index} value={plan.id}>{plan.Name}</option>
                                                        })
                                                    }
                                                </select>
                                            </div>
                                            <div className="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" className="custom-control-input" id={"listing_checkbox_" + listing_index} name="example1" onChange={(e) => this.handleSelectListing(e, listing.id)} />
                                                <label className="custom-control-label listing_detail  p-1" htmlFor={"listing_checkbox_" + listing_index}>Do you want to publish this listing?</label>
                                            </div>
                                            <a className="redirect_to_listing" href="#">Manage Listing</a>
                                        </div>
                                    </div>
                                }
                            })
                        }
                        {

                            this.state.plan_types.map((membership, membership_index) => {
                                let count_membership = 0;
                                for (let iiii = 0; iiii < this.state.listings.length; iiii++) {
                                    if (this.state.listings[iiii].membership_type == membership.id && this.state.publish_listings.indexOf(this.state.listings[iiii].id) != -1  && this.state.listings[iiii].status != 'Subscribed') {
                                        count_membership++;
                                        console.log(count_membership, '+++++++++++')
                                    }
                                }
                                console.log(count_membership, '------------')
                                if (count_membership) {
                                    total_price += membership.annual_fee * count_membership
                                    return <div className="row listing_item mt-3 pb-3" key={membership_index}>
                                        <div className="col-md-6 listing_detail">{membership.Name}</div>
                                        <div className="col-md-3 listing_detail">${membership.annual_fee} × {count_membership} </div>
                                        <div className="col-md-3 listing_detail">${membership.annual_fee * count_membership} </div>
                                    </div>
                                }
                            })
                        }
                        <div className="row listing_item mt-3 pb-3"  >
                            <div className="col-md-6 listing_detail">Total</div>
                            <div className="col-md-3 listing_detail"></div>
                            <div className="col-md-3 listing_detail">{total_price}</div>
                        </div>


                    </div>

                </aside>

                <aside className="col-md-6 float-left">
                    <article className="card">
                        <div className="card-body p-5">
                            <ul className="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                                <li className="nav-item">
                                    <a className="nav-link active show" data-toggle="pill" href="#nav-tab-card">
                                        <i className="fa fa-cc-stripe" /> Stripe</a></li>
                                <li className="nav-item">
                                    <a className="nav-link" data-toggle="pill" href="#nav-tab-paypal">
                                        <i className="fa fa-cc-paypal" /> Paypal</a></li>
                            </ul>
                            <div className="tab-content">
                                <div className="tab-pane  active show" id="nav-tab-card">
                                    <Elements>
                                        <StripeSubscribeRoom roomId={this.props.match.params.roomId} onSubmit={(token, card_data) => this.onSubmit(token, card_data)} />
                                    </Elements>
                                </div>
                                <div className="tab-pane " id="nav-tab-paypal">
                                    <p>Paypal subscribe!</p>
                                    {
                                        this.state.listings.map((listing, index) =>{
                                            return listing.status != 'Subscribed' && this.state.publish_listings.includes(listing.id) && listing.membership_type && listing.membership_type != '0' && listing.id == this.props.match.params.roomId ? 
                                            <div className='mt-4'  key={index} >
                                                <h5>{listing.name}</h5>
                                                <h6 className='mt-1 mb-1'>Room ID : {listing.id}</h6>
                                                <h6 className='mt-1 mb-1'>Membership : {
                                                    this.state.plan_types.map(plan =>{
                                                        // console.log(plan.id, parseFloat(listing.membership_type))
                                                        return plan.id == parseFloat(listing.membership_type) ? plan.Name : null
                                                    })
                                                }</h6>
                                                <h6 className='mt-1 mb-1'>Price : {
                                                    this.state.plan_types.map(plan =>{
                                                        // console.log(plan.id, parseFloat(listing.membership_type))
                                                        return plan.id == parseFloat(listing.membership_type) ? '$' + plan.annual_fee : null
                                                    })
                                                }</h6>

                                                <PayPalCheckout  paymentSuccess={()=>this.SuccessPaypalSubscribe(listing.id)} planId={parseFloat(listing.membership_type)} roomId={listing.id}/>
                                                <hr/>
                                            </div>
                                            : null
                                        })
                                       
                                    }
                                    {
                                         this.state.listings.map((listing, index) =>{
                                            return listing.status != 'Subscribed' && this.state.publish_listings.includes(listing.id) && listing.membership_type && listing.membership_type != '0' && listing.id != this.props.match.params.roomId ? 
                                            <div className='mt-4'  key={index} >
                                                <h5>{listing.name}</h5>
                                                <h6 className='mt-1 mb-1'>Room ID : {listing.id}</h6>
                                                <h6 className='mt-1 mb-1'>Membership : {
                                                    this.state.plan_types.map(plan =>{
                                                        // console.log(plan.id, parseFloat(listing.membership_type))
                                                        return plan.id == parseFloat(listing.membership_type) ? plan.Name : null
                                                    })
                                                }</h6>
                                                <h6 className='mt-1 mb-1'>Price : {
                                                    this.state.plan_types.map(plan =>{
                                                        // console.log(plan.id, parseFloat(listing.membership_type))
                                                        return plan.id == parseFloat(listing.membership_type) ? '$' + plan.annual_fee : null
                                                    })
                                                }</h6>
                                                
                                                <PayPalCheckout paymentSuccess={()=>this.SuccessPaypalSubscribe(listing.id)} planId={parseFloat(listing.membership_type)} roomId={listing.id}/>
                                                <hr/>
                                            </div>
                                            : null
                                        })
                                    }
                                    <p>
                                    
                                        
                                    </p>
                                    <p><strong>Note:</strong> You must subscribe for every listings. </p>
                                </div>
                                <div className="tab-pane " id="nav-tab-bank">
                                    <p>Bank accaunt details</p>
                                    <dl className="param">
                                        <dt>BANK: </dt>
                                        <dd> THE WORLD BANK</dd>
                                    </dl>
                                    <dl className="param">
                                        <dt>Accaunt number: </dt>
                                        <dd> 12345678912345</dd>
                                    </dl>
                                    <dl className="param">
                                        <dt>IBAN: </dt>
                                        <dd> 123456789</dd>
                                    </dl>
                                    <p><strong>Note:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </aside>

            </div>
        </main>

    }
}

export default SubscriptionRoom