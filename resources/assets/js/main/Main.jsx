import React, { Component , Suspense } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch,   withRouter  } from 'react-router-dom';
import Home from '../pages/Home/Home'
import {Provider } from 'react-redux'
import store from '../store'
import Header from '../common/header/Header';
import Footer from '../common/footer/Footer';
const metas = document.getElementsByTagName('meta');
import Chatbox from '../common/chatbox/Chatbox';
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
                <Router basename="/" >
                <div className="body">
                <Header/>
                <Suspense fallback={<div>Loading...</div>}>
                <Switch >
                    <Route  exact path='/' component = {Home}/>
                    
                  </Switch>
                  </Suspense>
                  {
                    metas['isLogedin'].content == 'true' && <Chatbox/>
                  }
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
