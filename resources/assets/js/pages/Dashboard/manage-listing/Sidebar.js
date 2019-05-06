import React from 'react'
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import MenuItem from './MenuItem'
class Sidebar extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        var body = document.body,
        html = document.documentElement;
      
        return (
            <div className="col-lg-2 lang-pos col-md-3 listing-nav-sm nopad" id="js-manage-listing-nav h-100">
            <div className="nav-sections height_adj">
            <ul className="list-unstyled margin-bot-5 list-nav-link">
                <li className="nav-item nav-basics pre-listed nav-active">
                
                <a href={`basics`}>
                    <MenuItem menu_text='Basics'/>
                </a>
                </li>
                <li className="nav-item nav-description pre-listed">
               
                <a href={`description`}>
                <MenuItem menu_text='Description'/>
                </a>
                </li>
                <li className="nav-item nav-location pre-listed">
                
                <a href={`location`}> <MenuItem menu_text='Location'/>
                </a>
                </li>
                <li className="nav-item nav-amenities pre-listed" data-track="amenities" ng-class="(step == 'amenities') ? 'nav-active' : ''">
                
                <a href={`amenities`}>
                <MenuItem menu_text='Amenities'/>
                </a>
                </li>
                <li className="nav-item nav-photos pre-listed" data-track="photos" ng-class="(step == 'photos') ? 'nav-active' : ''">
                
                <a href={`photos`}>
                <MenuItem menu_text='Photos'/>
                </a>
                </li>
                <li className="nav-item nav-video pre-listed" data-track="video" ng-class="(step == 'video') ? 'nav-active' : ''">
                
                <a href={`video`}>
                <MenuItem menu_text='Video'/>
                </a>
                </li>
            </ul>
            <ul className="list-unstyled margin-bot-5 list-nav-link">
                <li className="nav-item nav-guidebook post-listed" >
                
                <a href="/guidebook">
                <MenuItem menu_text='Location'/>
                </a>
                </li>
            </ul>
            <ul className="list-unstyled margin-bot-5 list-nav-link list-nav-link">
                <li className="nav-item nav-pricing pre-listed" data-track="pricing" ng-class="(step == 'pricing') ? 'nav-active' : ''">
                
                <a href={`pricing`}>
                    <div className="row nav-item">
                    <div className="col-sm-12 va-container">
                        <span className="va-middle">Pricing
                        </span>
                        <div className="instant-book-status pull-right">
                        <div className="instant-book-status__on hide">
                            <i className="icon icon-bolt icon-beach h3">
                            </i>
                        </div>
                        <div className="instant-book-status__off hide">
                            <i className="icon icon-bolt icon-light-gray h3">
                            </i>
                        </div>
                        </div>
                        <div className="js-new-section-icon not-post-listed pull-right transition visible">
                        <i className="nav-icon icon icon-add icon-grey">
                        </i>
                        </div>
                        <div className="pull-right lang-left-change">
                        <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed hide">
                        </i>
                        <i className="dot dot-success hide">
                        </i>
                        </div>
                    </div>
                    </div>
                </a>
                </li>
                <li className="nav-item nav-calendar pre-listed" id="remove-manage" data-track="calendar" ng-class="(step == 'calendar') ? 'nav-active' : ''">
                
                <a href={`calendar`}>
                    <div className="row nav-item">
                    <div className="col-sm-12 va-container">
                        <span className="va-middle">Calendar
                        </span>
                    </div>
                    </div>
                </a>
                </li>
                <li className="nav-item nav-terms pre-listed" data-track="terms" ng-class="(step == 'terms') ? 'nav-active' : ''">
                
                <a href={`terms`}>
                    <div className="row nav-item">
                    <div className="col-sm-12 va-container">
                        <span className="va-middle">Terms
                        </span>
                        <div className="instant-book-status pull-right">
                        <div className="instant-book-status__on hide">
                            <i className="icon icon-bolt icon-beach h3">
                            </i>
                        </div>
                        <div className="instant-book-status__off hide">
                            <i className="icon icon-bolt icon-light-gray h3">
                            </i>
                        </div>
                        </div>
                        <div className="js-new-section-icon not-post-listed pull-right transition visible">
                        <i className="nav-icon icon icon-add icon-grey">
                        </i>
                        </div>
                        <div className="pull-right lang-left-change">
                        <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed hide">
                        </i>
                        <i className="dot dot-success hide">
                        </i>
                        </div>
                    </div>
                    </div>
                </a>
                </li>
                <li className="nav-item nav-basics pre-listed" data-track="plans" ng-class="(step == 'plans') ? 'nav-active' : ''">
                
                <a href={`plans`}>
                    <div className="row nav-item">
                    <div className="col-sm-12 va-container">
                        <span className="va-middle">Publish
                        </span>
                        <div className="instant-book-status pull-right">
                        <div className="instant-book-status__on hide">
                            <i className="icon icon-bolt icon-beach h3">
                            </i>
                        </div>
                        <div className="instant-book-status__off hide">
                            <i className="icon icon-bolt icon-light-gray h3">
                            </i>
                        </div>
                        </div>
                        <div className="js-new-section-icon not-post-listed pull-right transition hide">
                        <i className="nav-icon icon icon-add icon-grey">
                        </i>
                        </div>
                        <div className="pull-right lang-left-change">
                        <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed ">
                        </i>
                        <i className="dot dot-success hide">
                        </i>
                        </div>
                    </div>
                    </div>
                    </a>
                </li>
            </ul>
            </div>
            <div className="publish-actions text-center">
            <div id="user-suspended">
            </div>
            <div id="availability-dropdown">
                <i className="dot row-space-top-2 col-top dot-danger">
                </i>&nbsp;
                <div className="select">
                <select className="room_status_dropdown" disabled>
                    <option value="Listed">Listed
                    </option>
                    <option value="Unlisted">Unlisted
                    </option>
                    <option value="Draft" >Draft
                    </option>
                </select>
                </div>
            </div>
            <div id="js-publish-button" className="mt-2">
                <div className="not-post-listed text-center">
                <div className="animated text-lead text-muted steps-remaining js-steps-remaining show" style={{opacity: 1}}>Complete
                    <strong className="text-highlight">
                    <span id="steps_count">6
                    </span> steps
                    </strong> to list your space.
                </div>
                
                {/* <a className="animated btn btn-large btn-host btn-primary list-your-space js-list-space-button" to="subscription">
                    Buy Subscription
                </a> */}
                </div>
            </div>
            </div>
        </div>
        
        )
    }
}
export default Sidebar