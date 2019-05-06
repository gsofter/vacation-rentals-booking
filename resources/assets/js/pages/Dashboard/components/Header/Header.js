import React from 'react'
import { BrowserRouter as Router, Route ,Link} from 'react-router-dom';
import logo from '../../../../common/header/logo.png'

class Header extends React.Component{

    render(){
        return(
          <nav className="navbar navbar-expand-lg navbar-light bg-light">
          <a className="navbar-brand" to="/"><img className="logo" src={logo} alt="logo"/></a>
          <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span className="navbar-toggler-icon"></span>
          </button>

          <div className="collapse navbar-collapse" id="navbarSupportedContent">
              <ul className="navbar-nav ml-auto">
                 
                  <li className="nav-item">
                      <a className="nav-link menuitems" to='/dashboard/inbox'  >Mail</a>
                  </li>
                  <li className="nav-item ">
                      <a className="nav-link menuitems" to="/dashboard/myprofile">Hey <span >Kashirin</span></a>
                  </li>
                  
                  <li className="nav-item listitem">
                      <a className="nav-link listmenuitems" to="/rooms/new">List your Home<span className="sr-only">(current)</span></a>
                  </li>
              </ul>
              
          </div>
         
      </nav>
            
        )
    }
}

export default Header