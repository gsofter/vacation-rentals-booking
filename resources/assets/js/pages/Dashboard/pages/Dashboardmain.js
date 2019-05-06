import React from 'react'
import { BrowserRouter as Router, Route ,Link} from 'react-router-dom';

class Dashboardmain extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            userinfo : {
                    first_name : '',
                    last_name : ''
            },
            page_data : {}
           
        }
    }
    componentDidMount(){
        fetch('/ajax/dashboard/index')
      .then(response => response.json())
      .then(data => {
          console.log(data)
          this.setState({
            userinfo : data.user_info,
            page_data : data.data
          })
      });
    }
    render(){
        let {userinfo, page_data} = this.state
        if(page_data.option == 'guest_dashboard'){
            return(
                <div className="page-container-responsive space-top-4 space-4">
        <div className="row">
          <div className="col-md-3 lang-chang-label dash-left-sec">
            <div className="panel space-4">
              <div className="media media-photo-block
             dashboard-profile-photo panel-image ">
                <a href={"/users/show/" + userinfo.id} title="View Profile">
                  <img src={userinfo.profile_pic ? userinfo.profile_pic.src : data.profile_pic} className="img-responsive" width={190} height={190} title={userinfo.first_name} alt={userinfo.first_name} />
                </a>
                <div className="upload-profile-photo-cta btn btn-contrast btn-block text-wrap">
                  <a href="/dashboard/photos" className="link-reset">
                    <i className="icon icon-camera" />
                    Add Profile Photo
                  </a>          </div>
              </div>
              <div className="panel-body">
                <h2 className="text-center">
                  {userinfo.first_name}
                </h2>
                <ul className="list-unstyled text-center">
                  <li className="custom_link">
                    <a href={"/users/show/" + userinfo.id}>View Profile</a>
                  </li>
                  <li>
                    <a href="/dashboard/myprofile" className="btn btn-primary btn-block text-wrap space-top-1" id="edit-profile">Complete Profile</a>
                  </li>
                </ul>
              </div>
            </div>
            <div className="panel quick_panel">
              <div className="panel_head">
                <h3>Quick Links</h3>
              </div>
              <div className="panel_body">
                <ul>
                  <li><a href="https://www.vacation.rentals/rooms">View/Manage Listing</a></li>
                  <li><a href="https://www.vacation.rentals/my_reservations">Reservations</a></li>
                  <li><a href="https://www.vacation.rentals/users/reviews">Reviews</a></li>
                  <li><a href="https://www.vacation.rentals/invite">Referrals</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div className="col-md-9 dash-right-sec pull-left">
            <div className="panel space-4">
              <div className="panel-header">
                <span className="lang-chang-label"> Welcome to Vacation.Rentals-----,</span> {userinfo.first_name}!
              </div>
              <div className="panel-body">
                <p>
                  Check your messages, view upcoming trip information, and find travel inspiration all from your dashboard.  Before booking your first stay, make sure to:                           </p>
                <ul className="list-unstyled">
                  <li className="space-2">
                    <strong><a href="https://www.vacation.rentals/users/edit">Complete Your Profile</a></strong>
                    <div>Upload a photo and write a short bio to help hosts get to know you before inviting you into their home.</div>
                  </li>
                </ul>
              </div>
            </div>
            <div className="panel space-4">
              <div className="panel-header">
                Notifications
              </div>
              <div className="panel-body">
                <ul className="list-unstyled hdb-light-bg">
                  <li className="default alert3">
                    <div className="row row-table ">
                      <div className="col-11 col-middle">
                        <span className="dashboard_alert_text">
                          Please confirm your email address by clicking on the link we just emailed you. If you cannot find the email, you can <a href="https://www.vacation.rentals/users/request_new_confirm_email">request a new confirmation email</a> or <a href="https://www.vacation.rentals/users/edit">change your email address</a>.
                        </span>
                      </div>
                      <div className="col-1 col-middle">
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div className="panel space-4 pajinate">
              <div className="panel-header">
                Messages (0 new)
              </div>
              <ul className="list-layout pajinate-item-container">
              </ul>
              <div className="panel-body">
                <div className="d-block pagination-container mb-20">
                  <div className="pagination-nav">
                    <ul className="pagination d-flex align-items-center justify-content-center"><a className="previous_link" /><span className="ellipse less" style={{display: 'block'}}>...</span><span className="ellipse more active_page" style={{display: 'block'}}>...</span>
                    <a className="next_link" /></ul>
                  </div>
                </div>
                <div className="d-block all-referrals-container mt-10 text-center">
                  <a href="/dashboard/inbox">All messages</a>
                </div>
              </div>
            </div>
            <div className="panel space-4 referral-container pajinate">
              <div className="panel-header">
                Referrals (0 new)
              </div>
              <ul className="list-layout pajinate-item-container">
              </ul>
              <div className="panel-body">
                <div className="d-block pagination-container mb-20">
                  <div className="pagination-nav">
                    <ul className="pagination d-flex align-items-center justify-content-center"><a className="previous_link" /><span className="ellipse less" style={{display: 'block'}}>...</span><span className="ellipse more active_page" style={{display: 'block'}}>...</span><a className="next_link" /></ul>
                  </div>
                </div>
                <div className="d-block all-referrals-container mt-10 text-center">
                  <a className="all-referrals-link" href="https://www.vacation.rentals/invite">All referrals</a>
                </div>
              </div>
            </div>
            <section className="hg_section bg-white p-4">
              <div className="container">
                <div className="row d-flex">
                  <div className="col-sm-12 col-md-9 col-lg-9">
                    {/* Title element */}
                    <div className="kl-title-block">
                      {/* Title with alternative font, custom size, theme color and bold style */}
                      <h3 className="tbk__title kl-font-alt fs-l fw-bold tcolor">
                        Get the word out!
                      </h3>
                      {/* Sub-title with custom size and thin style */}
                      <h4 className="tbk__subtitle fs-s fw-thin">
                        Invite other property owners and managers to list on Vacation.Rentals
                      </h4>
                    </div>
                    {/*/ Title element */}
                  </div>
                  {/*/ col-sm-12 col-md-9 col-lg-9 mb-sm-35 */}
                  <div className="col-sm-12 col-md-3 co-lg-3 d-flex flex-column align-self-center justify-content-center">
                    {/* Button full color style */}
                    <a href="https://www.vacation.rentals/invite" className="btn-element btn btn-fullcolor btn-md w-100" style={{margin: '0 10px 10px 0'}} title="Get Started!">
                      <span>Get Started!</span>
                    </a>
                  </div>
                  {/*/ col-sm-12 col-md-3 co-lg-3 d-flex align-self-center justify-content-center */}
                </div>
                {/*/ row */}
              </div>
              {/*/ container */}
            </section>              </div>
        </div>
      </div>
            )
        }
        else{
        return(
          <div className="col-md-9">
                  <div className="aside-main-content">
                    <div className="side-cnt">
                      <div className="row">
                        <div className="col-md-12">
                          <div className="pro-detial">
                            <div className="row align-items-center">
                              <div className="col-md-2">
                                <div className="user-profile">
                                  <img src={this.state.page_data.profile_pic} className="img-responsive" alt="profile" />
                                </div>
                              </div>
                              <div className="col-md-8">
                                <h3>Hello, {userinfo.first_name}!</h3>
                                <span>Good Morning!</span>
                                <p>Guess how many nights you've hosted this year?</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div className="col-md-12">
                          <div className="profile-tab">
                            <ul className="nav nav-tabs">
                              <li><a data-toggle="tab" href="#listing" className="active show">My
                                  Listings</a></li>
                              <li><a data-toggle="tab" href="#trips" className>My Trips</a></li>
                            </ul>
                            <div className="tab-content">
                              <div id="listing" className="tab-pane   active show">
     
                                <ul className="list-group list-group-flush">
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Pending
                                    Reservations <span className="badge badge-primary badge-pill">{page_data.pending_reservation_count}</span></li>
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Upcoming
                                    Reservations <span className="badge badge-primary badge-pill">{page_data.upcoming_reservation_count}</span></li>
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Current
                                    Reservations <span className="badge badge-primary badge-pill">{page_data.current_reservation_count}</span></li>
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Total
                                    Listings <span className="badge badge-pill no-pd">{page_data.listing_count}</span></li>
                                </ul>
                              </div>
                              <div id="trips" className="tab-pane  ">
 
                                <ul className="list-group list-group-flush">
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Pending
                                    Trips <span className="badge badge-primary badge-pill">{page_data.pending_trip_count}</span></li>
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Upcoming
                                    Trips <span className="badge badge-primary badge-pill">{page_data.upcoming_trip_count}</span></li>
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Current
                                    Trips <span className="badge badge-primary badge-pill">{page_data.current_trip_count}</span></li>
                                  <li className="list-group-item d-flex justify-content-between align-items-center">Total
                                    Listings <span className="badge badge-pill no-pd">{page_data.all_trip_count}</span></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="aside-main-content">
                    <div className="row">
                      <div className="col-12">
                        <div className="full-box">
                          <ul className="nav nav-tabs fullbox-tab">
                            <li><a data-toggle="tab" href="#pending-request" className="active show">
                                <span className="badge badge-pill badge-warning">{page_data.pending_count}</span> Pending
                                Requests and
                                Inquiries</a></li>
                            <li><a data-toggle="tab" href="#notifications" className>Notifications <span className="badge badge-pill badge-secondary">{page_data.notification_count}</span></a></li>
                            {/* <li><a data-toggle="tab" href="#referrals" className>Referrals <span className="badge badge-pill badge-secondary">2</span></a></li> */}
                          </ul>
                          <div className="tab-content">
                            <div id="pending-request" className="tab-pane   active show">
                              <div className="content">
                                <h3>Get the word out!</h3>
                                <p>Invite other property owners and managers to list on
                                  Vacation.Rentals</p>
                                <button className="btn btn-outline-primary">Get started</button>
                              </div>
                            </div>
                            <div id="notifications" className="tab-pane ">
                           
                              
                              <div className="content">
                                <h3>Notification </h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta,
                                  eaque dolorem? Dolorum cum maiores at harum, vel nulla fugiat,
                                  error esse, tenetur explicabo doloribus fuga nobis magni nihil
                                  quae libero.</p>
                              </div>
                           
                            </div>
                            <div id="referrals" className="tab-pane ">
                              <div className="content">
                                <h3>Referrals</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta,
                                  eaque dolorem? Dolorum cum maiores at harum, vel nulla fugiat,
                                  error esse, tenetur explicabo doloribus fuga nobis magni nihil
                                  quae libero.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        //     <div className="host-dashboard">
        //     <div className="page-container-full">
        //         <div className="header-color">
        //             <div className="page-container-responsive">
        //                 <div className=" header-background">
        //                     <div className="col-md-8 text-contrast hide-phone">
        //                         <div className="row">
        //                             <div className="col-md-2">
        //                                 <div className="va-container va-container-h collapsed-header">
        //                                     <div className="va-middle">
        //                                         <a className="media-photo media-round pull-right">
        //                                             <img src={this.state.page_data.profile_pic} className="img-responsive" />
        //                                         </a>
        //                                     </div>
        //                                 </div>
        //                             </div>
        //                         </div>
        //                     </div>
        //                     <div className="text-contrast col-md-4 panel-right collapsed-header host-summary-widget">
        //                         <div className="va-container collapsed-header va-container-h">
        //                             <div className="va-middle text-contrast text-lead">
        //                                 <div ng-controller="Tabsh" className="ng-scope">
        //                                      
        
        //                                 </div>
        //                             </div>
        //                         </div>
        //                     </div>
        
        //                 </div>
        //             </div>
        //         </div>
        //     </div>
        //     <div className="page-container-full alt-bg-module-panel-container relative">
        //         <div>
        //             <div className="page-container-responsive relative">
        //                 <div ng-controller="Tabsh" className="ng-scope">
        //                     <Tabs>
        //                         <TabList className="tabs">
        //                             <Tab className="tab-item text-secondary h4"> ({page_data.pending_count} {page_data.pending_count ? 'New' : ''}) Pending Requests and Inquiries</Tab>
        //                             <Tab className="tab-item text-secondary h5 mylists">Notifications</Tab>
        //                             <Tab className="tab-item text-secondary h5 mylists">Referrals</Tab>
        //                         </TabList>
        
        //                         <TabPanel className="tab-panel hdb-light-bg">
        //                             <div className="text-lead text-muted no-req-res-row text-center">
        //                                 <div className="panel space-4 pajinate">
        //                                     <ul className="list-layout pajinate-item-container">

        //                                     </ul>
                                             
        //                                 </div>
        //                             </div>
        //                         </TabPanel>
        //                         <TabPanel className="tab-panel hdb-light-bg">
        //                             <div className="text-lead text-muted no-req-res-row text-center">
        //                                 <div className="panel space-4 pajinate">
        //                                     <ul className="list-layout pajinate-item-container">
        //                                     </ul>
                                             
        //                                 </div>
        //                             </div>
        //                         </TabPanel>
        //                         <TabPanel className="tab-panel hdb-light-bg">
        //                             <div className="text-lead text-muted no-req-res-row text-center">
        //                                 <div className="panel space-4 pajinate">
        //                                     <ul className="list-layout pajinate-item-container">
        //                                     </ul>
                                             
        //                                 </div>
        //                             </div>
        //                         </TabPanel>
        //                     </Tabs>
        
        
        //                     <section className="hg_section bg-white p-4 referral-cta-container">
        //                         <div className="container">
        //                             <div className="row d-flex">
        //                                 <div className="col-sm-12 col-md-9 col-lg-9">
        //                                     {/* Title element */}
        //                                     <div className="kl-title-block">
        //                                         {/* Title with alternative font, custom size, theme color and bold style */}
        //                                         <h3 className="tbk__title kl-font-alt fs-l fw-bold tcolor">
        //                                             Get the word out!
        //                                         </h3>
        //                                         {/* Sub-title with custom size and thin style */}
        //                                         <h4 className="tbk__subtitle fs-s fw-thin">
        //                                             Invite other property owners and managers to list on Vacation.Rentals
        //                                         </h4>
        //                                     </div>
        //                                     {/*/ Title element */}
        //                                 </div>
        //                                 {/*/ col-sm-12 col-md-9 col-lg-9 mb-sm-35 */}
        //                                 <div className="col-sm-12 col-md-3 co-lg-3 d-flex flex-column align-self-center justify-content-center">
        //                                     {/* Button full color style */}
        //                                     <a href="javascript:alert('working now');" className="btn-element btn btn-fullcolor btn-md w-100" style={{margin: '0 10px 10px 0'}} title="Get Started!">
        //                                         <span>Get Started!</span>
        //                                     </a>
        //                                 </div>
        //                                 {/*/ col-sm-12 col-md-3 co-lg-3 d-flex align-self-center justify-content-center */}
        //                             </div>
        //                             {/*/ row */}
        //                         </div>
        //                         {/*/ container */}
        //                     </section>
        //                 </div>
        //             </div>
        //         </div>
        //     </div>
        // </div>
        )
    }
}
}
export default Dashboardmain