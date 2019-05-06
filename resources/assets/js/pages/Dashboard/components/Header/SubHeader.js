import React from 'react'
import { Link } from "react-router-dom";

class Subheader extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        console.log(this.props)
        return(
            <div className="subnav hide-print">
                <div className="page-container-responsive">
                  <ul className="subnav-list">
                    <li>
                      <a href="/dashboard" aria-selected="true" className="subnav-item">Dashboard</a>
                    </li>
                    <li>
                      <a href={`${this.props.match.url}/inbox`} aria-selected="false" className="subnav-item">Inbox</a>
                    </li>
                    <li>
                      <a href={`${this.props.match.url}/inbox`} aria-selected="false" className="subnav-item">Your Listings</a>
                    </li>
                    <li>
                      <a href={`${this.props.match.url}/inbox`} aria-selected="false" className="subnav-item">Your Trips</a>
                    </li>
                    <li>
                      <a href={`${this.props.match.url}/inbox`} aria-selected="false" className="subnav-item">Profile</a>
                    </li>
                    <li>
                      <a href={`${this.props.match.url}/inbox`} aria-selected="false" className="subnav-item">Account</a>
                    </li>
                    <li className="hide">
                      <a href={`${this.props.match.url}/inbox`} className="subnav-item">Travel Credit</a>
                    </li>
                    <li className="hide">
                      <a href={`${this.props.match.url}/inbox`} className="subnav-item">Disputes
                      </a>
                    </li>
                  </ul>
                </div>
            </div>
        )
    }
}

export default Subheader