import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';
import './subfooter.css';

class Subfooter extends React.Component {
    render(){
        return(
            <div className="manage-listing-footer">
                <div className="container-brand-dark footer-panel">
                    <div className="row row-table"> 
                        <div className="col-4 col-foot site rj-foot"><span className="text-muted">© 2018 Vacation.Rentals----- | All rights reserved.</span></div>
                        <div className="col-4 col-foot site-list text-center rj-foot text-muted">
                            <a href="/why_host" className="text-muted">Why Host</a> |
                            <a href="/features" className="text-muted">Features</a> |
                            <a href="/price_to_list" className="text-muted">Price To List</a> |
                            <a href="/blog" className="text-muted">Blog</a> |
                            <a href="/our_story" className="text-muted">Our Story</a> |
                            <a href="/contact_us" className="text-muted">Contact Us</a> |
                        </div>
                        <div className="col-4 col-foot">
                            <ul className="list-layout list-inline pull-right">
                                <li>
                                    <a href="/facebook" className="link-contrast footer-icon-container" target="_blank">
                                        <span className="screen-reader-only">Facebook</span>
                                        <i className="icon footer-icon icon-facebook"></i> 
                                    </a>        
                                </li>
                                <li>
                                    <a href="/google_plus" className="link-contrast footer-icon-container" target="_blank">
                                        <span className="screen-reader-only">Google_plus</span>
                                        <i className="icon footer-icon icon-google-plus"></i> 
                                    </a>       
                                </li>
                                <li>
                                    <a href="/twitter" className="link-contrast footer-icon-container" target="_blank">
                                        <span className="screen-reader-only">Twitter</span>
                                        <i className="icon footer-icon icon-twitter"></i> 
                                    </a>      
                                </li>
                                <li> 
                                    <a href="/linkedin" className="link-contrast footer-icon-container" target="_blank">
                                        <span className="screen-reader-only">Linkedin</span>
                                        <i className="icon footer-icon icon-linkedin"></i> 
                                    </a>    
                                </li>
                                <li>
                                    <a href="/pinterest" className="link-contrast footer-icon-container" target="_blank">
                                        <span className="screen-reader-only">Pinterest</span>
                                        <i className="icon footer-icon icon-pinterest"></i> 
                                    </a>       
                                </li>
                                <li>
                                    <a href="/youtube" className="link-contrast footer-icon-container" target="_blank">
                                        <span className="screen-reader-only">Youtube</span>
                                        <i className="icon footer-icon icon-youtube"></i> 
                                    </a>        
                                </li>
                                <li>
                                    <a href="/instagram" className="link-contrast footer-icon-container" target="_blank">
                                        <span className="screen-reader-only">Instagram</span>
                                        <i className="icon footer-icon icon-instagram"></i> 
                                    </a>        
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Subfooter;