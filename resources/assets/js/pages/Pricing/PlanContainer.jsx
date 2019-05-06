import React from 'react'
import axios from 'axios'
import { Link } from 'react-router-dom'
var ReactScriptLoaderMixin = require('react-script-loader').ReactScriptLoaderMixin;
import StripeForm from './StripeForm'
import {Elements, StripeProvider} from 'react-stripe-elements';
import PayPalCheckout from './PaypalButton';
import PricingDetail from './PricingDetail'
 class PlanContainer extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            plan_detail : {},
          
        }
    }
    componentDidMount(){
        let planId = this.props.planId
        console.log('planId', planId)
        axios.get(`/ajax/membershiptype/${planId}`)
        .then(result => {
            this.setState({
                plan_detail : result.data,
             
            })
        })
    }
    render(){
        return <div className="container">
        <div className="row">
          <aside className="col-sm-6">
            <h3>Plan Details</h3>
            <article className="card">
              <div className="card-body p-5">
                <PricingDetail detail = {this.state.plan_detail}/>
               </div>  
            </article> 
          </aside> 
          <aside className="col-sm-6">
          <h3>Subscribe Form</h3>
            <article className="card">
              <div className="card-body p-5">
                <ul className="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                  <li className="nav-item">
                    <a className="nav-link active" data-toggle="pill" href="#nav-tab-card">
                      <i className="fa fa-credit-card" /> Stripe</a></li>
                  <li className="nav-item">
                    <a className="nav-link" data-toggle="pill" href="#nav-tab-paypal">
                      <i className="fab fa-paypal" />  Paypal</a></li>
                  {/* <li className="nav-item">
                    <a className="nav-link" data-toggle="pill" href="#nav-tab-bank">
                      <i className="fa fa-university" />  Bank Transfer</a></li> */}
                </ul>
                <div className="tab-content">
                  <div className="tab-pane  show active" id="nav-tab-card">
                    <p className="alert alert-success mb-5">Please input your card details!</p>
                    <Elements>
                    <StripeForm planId={this.props.planId}/>
                    </Elements>
                  </div> {/* tab-pane.// */}
                  <div className="tab-pane " id="nav-tab-paypal">
                    <PayPalCheckout planId={this.props.planId} />
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
                  </div> {/* tab-pane.// */}
                </div> {/* tab-content .// */}
                <a className="btn btn-success w-100 mt-5" to = '/pricing'>Back To Listing Page</a>
              </div> {/* card-body.// */}
            </article> {/* card.// */}
          </aside> {/* col.// */}
        </div> {/* row.// */}
      </div>
    }
}

export default PlanContainer