import React from 'react'
import { Link} from 'react-router-dom';
class Footer extends React.PureComponent{
    render(){
        return(
            <div id="footer" className="container-brand-dark footer-surround footer-container" style={{width: '100%'}}>
            <footer className="page-container-responsive ng-scope" ng-controller="footer">
              <div className="row row-condensed">
                <div className="col-md-4 rj_footer">
                  <div className="foot-column">
                    <h2 className="h5 font_strong">Company</h2>
                    <ul className="list-layout">
                      <li><a href="/about-us/why-host" className="link-contrast">Why Host</a></li>
                      <li><a href="/about-us/features" className="link-contrast">Features</a></li>
                      <li><a href="/pricing" className="link-contrast">Price To List</a></li>
                      <li><a href="/blog" className="link-contrast">Blog</a></li>
                      <li><a href="/about-us/our-story" className="link-contrast">Our Story</a></li>
                    </ul>
                  </div>
                </div>

                {/* <div className="col-md-4 rj_footer">
                  <div className="foot-column">
                    <h2 className="h5 font_strong">Vacation Rentals</h2>
                    <ul className="list-layout">
                      <li><a href="/rentals/florida" className="link-contrast">Florida</a></li>
                      <li><a href="/rentals/colorado" className="link-contrast">Colorado</a></li>
                      <li><a href="/rentals/hawaii" className="link-contrast">Hawaii</a></li>
                      <li><a href="/rentals/florida/kissimmee" className="link-contrast">Kissimmee</a></li>
                    </ul>
                  </div>
                </div> */}
                <div className="col-md-4 rj_footer">
                  <div className="foot-column">
                    <h2 className="h5 font_strong">Support</h2>
                    <ul className="list-layout">
                      <li><a href="/about-us/trust-safety" className="link-contrast">Trust &amp; Safety</a></li>
                      {/* <li><a href="/services/property-managers-can-list-with-us" className="link-contrast">Property Managers</a></li> */}
                      <li><a href="/help" className="link-contrast">FAQ</a></li>
                    </ul>
                  </div>
                </div>
                <div className="col-md-4 rj_footer">
                  <div className="foot-column">
                    <h2 className="h5 font_strong">Site Info</h2>
                    <ul className="list-layout">
                     
                      <li><a href="/contactus" className="link-contrast">Contact Us</a></li>
                      <li><a href="/sitemap" className="link-contrast">Sitemap</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <hr className="space-top-4 space-4 hide-sm row" />
              <div >
                <h2 className="h5 space-4 text-center">Join Us On</h2>
                <ul className="list-layout list-inline text-center">
                  <link itemProp="url"  />
                  <meta itemProp="logo"  />
                  <li>
                    <a href="https://www.facebook.com/www.Vacation.Rentals" className="link-contrast footer-icon-container" target="_blank">
                      <span className="screen-reader-only">Facebook</span>
                      <i className="icon footer-icon icon-facebook" />
                    </a>
                  </li>
                  <li>
                    <a href="https://plus.google.com/103512039900259107148" className="link-contrast footer-icon-container" target="_blank">
                      <span className="screen-reader-only">Google_plus</span>
                      <i className="icon footer-icon icon-google-plus" />
                    </a>
                  </li>
                  <li>
                    <a href="https://twitter.com/Vacarent" className="link-contrast footer-icon-container" target="_blank">
                      <span className="screen-reader-only">Twitter</span>
                      <i className="icon footer-icon icon-twitter" />
                    </a>
                  </li>
                  <li>
                    <a href="https://www.linkedin.com/in/vacarent/" className="link-contrast footer-icon-container" target="_blank">
                      <span className="screen-reader-only">Linkedin</span>
                      <i className="icon footer-icon icon-linkedin" />
                    </a>
                  </li>
                  <li>
                    <a href="https://www.pinterest.com/nofeevacationrentals" className="link-contrast footer-icon-container" target="_blank">
                      <span className="screen-reader-only">Pinterest</span>
                      <i className="icon footer-icon icon-pinterest" />
                    </a>
                  </li>
                  <li>
                    <a href="https://www.youtube.com/vacationrentals" className="link-contrast footer-icon-container" target="_blank">
                      <span className="screen-reader-only">Youtube</span>
                      <i className="icon footer-icon icon-youtube" />
                    </a>
                  </li>
                  <li>
                    <a href="https://www.instagram.com/vacationhomesforrent" className="link-contrast footer-icon-container" target="_blank">
                      <span className="screen-reader-only">Instagram</span>
                      <i className="icon footer-icon icon-instagram" />
                    </a>
                  </li>
                </ul>
                <div className="space-top-2 copy-txt text-muted text-center">
                  © 2018 Vacation.Rentals----- | All rights reserved. |
                  <a href="/legal/terms-of-service" className="text-muted">
                    Terms of Service  | 					</a>
                  <a href="/legal/privacy-policy" className="text-muted">
                    Privacy Policy  | 					</a>
                  <a href="/legal/copyright-policy" className="text-muted">
                    Copyright Policy 					</a>
                </div>
              </div>
            </footer>
          </div>
        )
    }
}

export default Footer