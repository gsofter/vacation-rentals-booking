import React from 'react'
import Main from './Main'
import { BrowserRouter as Router, Route, Switch, Link , withRouter  } from 'react-router-dom';
import PropTypes from 'prop-types';

class LocationListener extends React.PureComponent {
    
    constructor(props){
        super(props)
        this.state = {
            router: PropTypes.object
        }
    }
    componentDidMount() {
      this.handleLocationChange(this.state.router.history.location);
      this.unlisten = 
        this.state.router.history.listen(this.handleLocationChange);
    }
  
    componentWillUnmount() {
      this.unlisten();
    }
  
    handleLocationChange(location) {
      // your staff here
      console.log(`- - - location: '${location.pathname}'`);
    }
  
    render() {
      return this.props.children;
    }
  }    
  
export default class App extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        return  <BrowserRouter>
        <LocationListener>
                    <Route component={Main} />
                    </LocationListener>
                </BrowserRouter>
    }
}
