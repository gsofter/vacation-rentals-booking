import React from 'react'
 
import { BrowserRouter as Router, Route ,Link} from 'react-router-dom';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Axios from 'axios';

class ContactUs extends React.PureComponent{
    constructor(props){
      super(props);
      this.state = {
        name: "",
        email: "",
        feedback: ""
      };
      this.handleSubmit = this.handleSubmit.bind(this);
      this.handleChange = this.handleChange.bind(this);
    }
    handleChange(event){
      this.setState({
        [event.target.name] : event.target.value,
        [event.target.email] : event.target.value,
        [event.target.feedback] : event.target.value,
      })
    }
    handleSubmit(event){
      event.preventDefault();
      this.setState({
        name: "",
        email: "",
        feedback: ""
      });
      Axios.post(
        "/getMail",{
          data: {
            'name': this.state.name,
            'email': this.state.email,
            'phone_number': this.state.phone_number,
            'account_type': this.state.account_type,
            'feedback': this.state.feedback
          }
        }
      ).then(Response =>{
        toast.success("Thank you! We will back to you soon!", {
          position: toast.POSITION.TOP_CENTER
        });
      })
    }
    render(){
      return ( <main>
        {/* contact starts */}
        <section className="contact-page" style={{marginTop: '97px'}}>
          <div className="contact_inner">
            <div className="contact-map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51217.84283639826!2d-93.29805190049649!3d36.64767968953203!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87cf01e9c1f60ea9%3A0xf3370960da92ac34!2sBranson%2C+MO+65616%2C+USA!5e0!3m2!1sen!2sin!4v1554930946066!5m2!1sen!2sin" width="100%" frameBorder={0} style={{border: 0}} allowFullScreen />
            </div>
            <div className="con-mid">
              <div className="container">
                <div className="row">
                  <div className="col-md-8">
                    <div className="con-l">
                      <div className="con-wrapper">
                        <h4>Contact Us</h4>
                        <form className="row" onSubmit={this.handleSubmit}>
                          <div className="col-md-6">
                            <div className="con-list">
                              <label>Name</label>
                              <input type="text" placeholder="Enter your name"  name="name"   value={this.state.name} onChange={this.handleChange} />
                            </div>
                          </div>
                          <div className="col-md-6">
                            <div className="con-list">
                              <label>Email Address</label>
                              <input  placeholder="Enter your email address"  name="email" type="email"  value={this.state.email} onChange={this.handleChange}/>
                            </div>
                          </div>
                          <div className="col-md-6">
                            <div className="con-list">
                              <label>I'm</label>
                              <select name='account_type' onChange={this.handleChange}>
                                <option value=''>Select</option>
                                <option value='traveler'>Traveler</option>
                                <option value='owner'>Owner/Manager</option>
                              </select>
                            </div>
                          </div>
                          <div className="col-md-6">
                            <div className="con-list">
                              <label>Phone</label>
                              <input type="text" placeholder="Enter your phone number" name='phone_number'  onChange={this.handleChange}/>
                            </div>
                          </div>
                          <div className="col-md-12">
                            <div className="con-list">
                              <label>Message</label>
                              <div className="rel-in">
                                <textarea row={2} type="text" name='feedback' value={this.state.feedback} onChange={this.handleChange} />
                                <button type="submit"><i className="fa fa-paper-plane-o" aria-hidden="true"  />
                                </button></div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div className="col-md-4">
                    <div className="con-r">
                      <div className="con-wrapper">
                        <h4>Contact Information</h4>
                        <ul className="cont-list-parent">
                          <li>
                            <i className="fa fa-map-marker" />
                            <span>Branson,Missouri 65616</span>
                          </li>
                          <li><i className="fa fa-phone" />
                            <span><a href="tel:(417) 232-6205">(417) 232-6205</a></span>
                          </li>
                          <li>
                            <i className="fa fa-envelope" />
                            <span><a href="mailto:robert@vacation.rentals">robert@vacation.rentals</a></span>
                          </li>
                        </ul>
                        <ul className="social-links">
                          <li>
                            <a href="#"><i className="fa fa-facebook" /></a>
                          </li>
                          <li>
                            <a href="#"><i className="fa fa-google-plus" /></a>
                          </li>
                          <li>
                            <a href="#"><i className="fa fa-twitter" /></a>
                          </li>
                          <li>
                            <a href="#"><i className="fa fa-linkedin" /></a>
                          </li>
                          <li>
                            <a href="#"><i className="fa fa-pinterest" /></a>
                          </li>
                          <li>
                            <a href="#"><i className="fa fa-youtube" /></a>
                          </li>
                          <li>
                            <a href="#"><i className="fa fa-instagram" /></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        {/* contact ends*/}
      </main>);
        // return(
            
        //       <main id="site-content" role="main">
        //       <ToastContainer/>
        //         <div className="page-container-responsive page-container-auth margintop" style={{marginTop: 40, marginBottom: 40}}>
        //           <div className="row d-flex mb-5 justify-content-center">
        //             <div className="col-10">
        //               <div className="row d-md-flex mb-5 justify-content-between">
        //                 <div className="col-md-4 col-12 d-md-flex">
        //                   <a href="#contact_form" className="d-md-flex align-items-stretch feature-box-link">
        //                     <div className="feature-box fbox-center fbox-bg fbox-plain">
        //                       <div className="fbox-icon">
        //                         <i className="icon-envelope" />
        //                       </div>
        //                       <h3>Sales &amp; General Inquiries<span className="subtitle icon-blue">sales@vacation.rentals</span><span className="subtitle">Or contact us using the form below</span></h3>
        //                     </div>
        //                   </a>
        //                 </div>
        //                 <div className="col-md-4 col-12 d-md-flex">
        //                   <a href="/help" className="d-md-flex align-items-stretch feature-box-link">
        //                     <div className="feature-box fbox-center fbox-bg fbox-plain">
        //                       <div className="fbox-icon">
        //                         <i className="icon-book" />
        //                       </div>
        //                       <h3>Knowledgebase &amp; Support<span className="subtitle">Checkout our knowledgebase for general support inquiries</span></h3>
        //                     </div>
        //                   </a>
        //                 </div>
        //                 <div className="col-md-4 col-12 d-md-flex">
        //                   <a href="/faq" className="d-md-flex align-items-stretch feature-box-link">
        //                     <div className="feature-box fbox-center fbox-bg fbox-plain">
        //                       <div className="fbox-icon">
        //                         <i className="icon-question-alt" />
        //                       </div>
        //                       <h3>FAQ<span className="subtitle">Have questions? Well, we got answers.</span></h3>
        //                     </div>
        //                   </a>
        //                 </div>
        //               </div>
        //               <hr />
        //               <div className="row mt-5">
        //                 <div className="col-12 col-md-8">
        //                   <div className="form-wrapper signup-form-fields">
        //                     <form method="POST" onSubmit={this.handleSubmit} acceptCharset="UTF-8" id="contact_form" className="vr_form ng-pristine ng-valid" noValidate="novalidate">
        //                       <input name="_token" type="hidden" defaultValue="URu8AOAwQKpfJrrjFS7raa3CPR0QzFAU1onV9pv9" className="tooltipstered" />
        //                       <div className="row row-condensed mb-4">
        //                         <input id="ip_address" name="ip_address" type="hidden" className="tooltipstered" />
        //                         <label className="text-left col-sm-3 lang-chang-label sr-only">
        //                           Name<em className="text-danger">*</em>
        //                         </label>
        //                         <div className="col-12 col-sm-9">
        //                           <input id="conName" className="focus tooltipstered" placeholder="Name" name="name" type="text" value={this.state.name} onChange={this.handleChange} />
        //                         </div>
        //                       </div>
        //                       <div className="row row-condensed mb-2">
        //                         <label className="text-left col-sm-3 lang-chang-label sr-only">
        //                           Email<em className="text-danger">*</em>
        //                         </label>
        //                         <div className="col-12 col-sm-9">
        //                           <input id="conEmail" className="focus tooltipstered" placeholder="Email Address" name="email" type="email"  value={this.state.email} onChange={this.handleChange} />
        //                         </div>
        //                       </div>
        //                       <div className="row row-condensed mb-2">
        //                         <div className="col-12 col-sm-9">
        //                           <div className="control-group row-space-top-3 row-space-2 ">
        //                             <h6 className="row-space-1">Reason for Inqury : </h6>
        //                           </div>
        //                           <div className="control-group row-space-2 field_ico" id="inputUserType">
        //                             <div className="row">
        //                               <div className="col-12 col-md-4">
        //                                 <input type="radio" name="contact_type" id="box-1" defaultValue="support" className="contact_type_group" />
        //                                 <label htmlFor="box-1">Support</label>
        //                               </div>
        //                               <div className="col-12 col-md-4">
        //                                 <input type="radio" name="contact_type" id="box-2" defaultValue="sales" className="contact_type_group" defaultChecked />
        //                                 <label htmlFor="box-2">Sales</label>
        //                               </div>
        //                               <div className="col-12 col-md-4">
        //                                 <input type="radio" name="contact_type" id="box-3" defaultValue="general" className="contact_type_group" />
        //                                 <label htmlFor="box-3">General Inquiry</label>
        //                               </div>
        //                             </div>
        //                           </div>
        //                         </div>
        //                       </div>
        //                       <div className="row row-condensed mb-4">
        //                         <label className="text-left col-sm-3 lang-chang-label sr-only">
        //                           Feedback<em className="text-danger">*</em>
        //                         </label>
        //                         <div className="col-12 col-sm-9">
        //                           <textarea id="conFeedback" className="focus tooltipstered" placeholder="Feedback" name="feedback" cols={50} rows={10} value={this.state.feedback} onChange={this.handleChange} />
        //                           <div className="text-right mt-3">
        //                             <input className="contact_submit lang-btn-cange btn btn-primary btn-large btn-large2 tooltipstered" type="submit" value="Submit" />
        //                           </div>
        //                         </div>
        //                       </div>
        //                     </form>
        //                   </div>
        //                 </div>
        //                 <div className="col-12 col-md-4">
        //                   <h3 >We're here to help</h3>
        //                   <p>Whether you're interested in <a href="https://www.vacation.rentals/help/topic/3/how-to-host">listing a property</a>, have a question on <a href="https://www.vacation.rentals/help/topic/10/booking-a-place">how to place a booking</a> for your next vacation destination, or just would like to <a href="https://www.vacation.rentals/help/topic/1/how-it-works">know more about Vacation.Rentals</a> - we want to hear from you!</p>
        //                   <p className="my-5">
        //                     <span className="bold d-block"> Is this an account related support issue?</span>
        //                     <span className="d-block">Make sure to visit our knowledgebase.  If you still have questions, please feel free to use the form to contact us.</span>
        //                   </p>
        //                   <hr />
        //                   <div className="response-block my-5">
        //                     <h6>Get the latest Vacation.Rentals updates</h6>
        //                     <ul className="list-layout list-inline d-flex social-share-widget-container">
        //                       <li>
        //                         <a href="https://www.facebook.com/www.Vacation.Rentals" className="footer-icon-container" target="_blank">
        //                           <span className="screen-reader-only">Facebook</span>
        //                           <i className="icon footer-icon icon-facebook" />
        //                         </a>
        //                       </li>
        //                       <li>
        //                         <a href="https://plus.google.com/103512039900259107148" className="footer-icon-container" target="_blank">
        //                           <span className="screen-reader-only">Google_plus</span>
        //                           <i className="icon footer-icon icon-google-plus" />
        //                         </a>
        //                       </li>
        //                       <li>
        //                         <a href="https://twitter.com/Vacarent" className="footer-icon-container" target="_blank">
        //                           <span className="screen-reader-only">Twitter</span>
        //                           <i className="icon footer-icon icon-twitter" />
        //                         </a>
        //                       </li>
        //                       <li>
        //                         <a href="https://www.linkedin.com/in/vacarent/" className="footer-icon-container" target="_blank">
        //                           <span className="screen-reader-only">Linkedin</span>
        //                           <i className="icon footer-icon icon-linkedin" />
        //                         </a>
        //                       </li>
        //                       <li>
        //                         <a href="https://www.pinterest.com/nofeevacationrentals" className="footer-icon-container" target="_blank">
        //                           <span className="screen-reader-only">Pinterest</span>
        //                           <i className="icon footer-icon icon-pinterest" />
        //                         </a>
        //                       </li>
        //                       <li>
        //                         <a href="https://www.youtube.com/vacationrentals" className="footer-icon-container" target="_blank">
        //                           <span className="screen-reader-only">Youtube</span>
        //                           <i className="icon footer-icon icon-youtube" />
        //                         </a>
        //                       </li>
        //                       <li>
        //                         <a href="https://www.instagram.com/vacationhomesforrent" className="footer-icon-container" target="_blank">
        //                           <span className="screen-reader-only">Instagram</span>
        //                           <i className="icon footer-icon icon-instagram" />
        //                         </a>
        //                       </li>
        //                     </ul>
        //                   </div>
        //                 </div>
        //               </div>
        //             </div>
        //           </div>
        //         </div>
        //       </main>
             
        // )
    }
}

export default ContactUs