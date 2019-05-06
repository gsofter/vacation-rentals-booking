import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

const Submenu = () => {
    
        return(
            
                <div className="manage-listing-header fixed-top" id="js-manage-listing-header">
                    <div className="subnav ml-header-subnav">
                        <ul className="subnav-list ">
                            <li className="show-if-collapsed-nav hide" id="collapsed-nav">
                                <a href="/pricing_listing_details1" className="subnav-item show-collapsed-nav-link" id="price-id">
                                <i className="icon icon-reorder show-collapsed-nav-link--icon" />
                                <span className="show-collapsed-nav-link--text">
                                    Pricing, listing details…
                                </span>
                                </a>
                            </li>
                            <li className="subnav-text">
                                <span id="listing-name"> Apartment in Dewgaon </span>
                                <span className="see-all-listings-link">
                                <span className="text-very-muted">(</span><span className="text-muted"><a href="https://www.vacation.rentals/rooms" className="text-normal link-underline">see all listings</a></span><span className="text-very-muted">)</span>
                                </span>
                            </li>
                            <li className="lang-left">
                                <a href="/view" className="subnav-item pull-right" id="preview-btn" title="Preview your listing as it will appear when active." target="_blank">
                                <i className="icon icon-eye" />
                                View
                                </a>
                            </li>
                            </ul>
                            <ul className="subnav-list has-collapsed-nav hide-md tespri">
                            <li className="show-if-collapsed-nav" id="collapsed-nav">
                                <a href="/pricing_listing_details2" className="subnav-item show-collapsed-nav-link">
                                    <i className="icon icon-reorder show-collapsed-nav-link--icon" />
                                    <span className="show-collapsed-nav-link--text">
                                        Pricing, listing details…
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
           
        )
    }


export default Submenu;