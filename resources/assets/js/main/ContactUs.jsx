// standard library

import React, { Component , Suspense } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch,   withRouter  } from 'react-router-dom';
// import Home from '../pages/Home/Home'
// import Login from '../pages/Login/Login'
// import Help from '../pages/Help/Help.jsx'
import ContactUs from '../pages/Contactus/ContactUs'
// import NewRooms from '../pages/Rooms/NewRooms'
// import Dashboard from '../pages/Dashboard/Dashboard'
// import Manage_listing from '../pages/Rooms/manage-listing/Manage_listing'
// import Listingdetail from '../pages/listingdetail/Listingdetail'
// import Search from '../pages/Search/Search'
// import Pricing from '../pages/Pricing/Pricing'
// import PricingPlan from '../pages/Pricing/PricingPlan'
// import {StripeProvider} from 'react-stripe-elements';
// import SubscriptionRoom from '../pages/Rooms/manage-listing/subscription/SubscriptionRoom'
import {Provider } from 'react-redux'
import store from '../store'
import Header from '../common/header/Header';
import Footer from '../common/footer/Footer';
import Chatbox from '../common/chatbox/Chatbox';
// import SignUp  from '../common/social/SignUp';
// import WhyHost from '../pages/other/WhyHost';
// import Features from '../pages/other/Features';
// import PriceToList from '../pages/other/PriceToList';
// import OurStory from '../pages/other/OurStory';
// import TrustSafety from '../pages/other/TrustSafety';
// import Inbox from '../pages/Inbox/Inbox';

class Main extends Component {
    constructor(props){
      super(props)
     
    }
    componentDidUpdate(prevProps) {
      if (this.props.location.pathname !== prevProps.location.pathname) {
          console.log('Route change!');
      }
    }
    render() {
        return (
          // <StripeProvider apiKey="pk_live_U8hqowvDTqTO4x1I7Wm67SUX00hjzdOcUZ">
                <Router basename="/" >
                <div className="body">
                <Header/>
                <Suspense fallback={<div>Loading...</div>}>
                <Switch >
                <Route  path='/contactus' component = {ContactUs}/>
                {/* <Route  path='/dashboard' component={Dashboard}/> */}
                    {/* <Route  exact path='/' component = {Home}/> */}
                    {/* <Route  path='/login' component = {Login}/>
                    <Route  path='/users/signup_social' component = {SignUp}/>
                    <Route  path='/help' component = {Help}/>
                    <Route  path='/faq' component = {Help}/>
                    
                    <Route  path='/pricing' component = {Pricing}/>
                    <Route  path='/pricingplan/:planId' component = {PricingPlan}/>
                    <Route  path='/search' component = {Search}/>
                   
                   
                    <Route  path='/inbox' component={Inbox}/>
                    <Route  path='/rooms/new' component={NewRooms}/>
                    <Route  path='/rooms/:roomId/subscribe_property' component={SubscriptionRoom}/>
                    <Route  path='/rooms/manage-listing/:roomId' component={Manage_listing}/>
                    <Route  path='/homes/:address_url/:roomId' component={Listingdetail}/>
                    <Route  path='/about-us/why-host' component={WhyHost}/>
                    <Route  path='/about-us/features' component={Features}/>
                    <Route  path='/about-us/price-to-list' component={PriceToList}/>
                    <Route  path='/about-us/our-story' component={OurStory}/>
                    <Route  path='/about-us/trust-safety' component={TrustSafety}/> */}
                  </Switch>
                  </Suspense>
                  <Chatbox/>
                  <Footer/>
                    </div>
                </Router>
          // </StripeProvider>
        )
    }
}



export default withRouter(props =><Main {...props}/>)
if (document.getElementById('root')) {
    ReactDOM.render(<Provider store  = {store}><Main /></Provider>, document.getElementById('root'));
}
