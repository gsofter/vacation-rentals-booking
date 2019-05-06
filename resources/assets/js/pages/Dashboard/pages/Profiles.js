import React from 'react'
import { BrowserRouter as Router, Route ,Link} from 'react-router-dom';
import Editprofile from './Profiles/Editprofile'
import Photos from './Profiles/Photos'
import Verification  from './Profiles/Verification'
import Reviews  from './Profiles/Reviews'
class Profiles extends React.Component{
    render(){
        return(
            <div className="page-container-responsive space-top-4 space-4">
            <div className="row">
              <div className="col-md-3 trip-left-sec">
                <ul className="sidenav-list">
                  <li>
                  <a href='/dashboard/editprofile'  aria-selected={this.props.location.pathname ===  `/dashboard/editprofile` || this.props.location.pathname ===  `/dashboard/myprofile`} className="sidenav-item">Edit Profile</a>
    
                    
                  </li>
                  <li>
                  <a href='/dashboard/photos'  aria-selected={this.props.location.pathname ===  `/dashboard/photos`} className="sidenav-item">Photos</a>
                    
                  </li>
                  <li>
                  <a href='/dashboard/edit_verification'  aria-selected={this.props.location.pathname ===  `/dashboard/edit_verification`} className="sidenav-item">Trust and Verification</a>
                    
                  </li>
                  <li>
                  <a href='/dashboard/reviews'  aria-selected={this.props.location.pathname ===  `/dashboard/reviews`} className="sidenav-item">Reviews</a>
                    
                  </li>
                </ul>    </div>
              <div className="col-md-9 trip-right-sec">
                 <Route exact path='/dashboard/editprofile' component = {Editprofile}/>
                 <Route  path='/dashboard/myprofile' component = {Editprofile}/>
                 <Route  path='/dashboard/photos' component = {Photos}/>
                 <Route  path='/dashboard/edit_verification' component = {Verification}/>
                 <Route  path='/dashboard/reviews' component = {Reviews}/>
              </div>
            </div>
          </div>
        )
    }
}

export default Profiles