// standard library

import React, { Component , Suspense } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch,   withRouter  } from 'react-router-dom';
import Pricing from '../pages/Pricing/Pricing'
import {Provider } from 'react-redux'
import store from '../store'
import Header from '../common/header/Header';
import Footer from '../common/footer/Footer';
import Chatbox from '../common/chatbox/Chatbox';

class Main extends Component {
    constructor(props){
      super(props)
     
    }
  
    render() {
        return (
                <Router basename="/" >
                <div className="body">
                <Header/>
                <Suspense fallback={<div>Loading...</div>}>
                <Switch >
                <Route  path='/pricing' component = {Pricing}/>
                    <Route  path='/pricingplan/:planId' component = {Pricing}/>
                  </Switch>
                  </Suspense>
                  <Chatbox/>
                  <Footer/>
                    </div>
                </Router>
        )
    }
}



export default withRouter(props =><Main {...props}/>)
if (document.getElementById('root')) {
    ReactDOM.render(<Provider store  = {store}><Main /></Provider>, document.getElementById('root'));
}
