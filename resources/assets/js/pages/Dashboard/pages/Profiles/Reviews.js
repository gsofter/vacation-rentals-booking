import React from 'react'
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';

class Reviews extends React.Component{
    render(){
        return(
            <div className="col-md-9">
             <Tabs> 
            <TabList  role="tablist" className="tabs">
            <Tab className="tab-item" >Reviews About You</Tab>
            <Tab className="tab-item" >Reviews By You</Tab>
            </TabList>

            <TabPanel>
            <div aria-hidden="false" id="received" role="tabpanel" className="tab-panel" >
                  <div className="panel">
                    <div className="panel-header">
                      Reviews
                    </div>
                    <div className="panel-body">
                      <p className="text-lead">
                        Reviews are written at the end of a reservation through Vacation.Rentals-----. Reviews you’ve received will be visible both here and on your public profile.
                      </p>
                      <ul className="list-layout reviews-list row-space-top-4">
                        <li className="reviews-list-item">
                          No one has reviewed you yet.
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
               
            </TabPanel>
            <TabPanel>
            <div id="sent" aria-hidden="true" role="tabpanel" >
                  <div className="panel">
                    <div className="panel-header">
                      Reviews to Write
                    </div>
                    <div className="panel-body">
                      <ul className="list-layout reviews-list">
                        <li className="reviews-list-item">
                          Nobody to review right now. Looks like it’s time for another trip!
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div className="panel row-space-top-4">
                    <div className="panel-header">
                      Past Reviews You’ve Written
                    </div>
                    <div className="panel-body">
                      No Reviews
                    </div>
                  </div>
                  <div className="panel row-space-top-4" id="expired-reviews">
                    <div className="panel-header">
                      Expired Reviews
                    </div>
                    <div className="panel-body">
                      <p className="text-lead">
                        Unfortunately, the deadline to submit a public review for this user has passed.
                      </p>
                      <ul className="list-layout reviews-list row-space-top-4">
                         <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10023">
                            <img width={68} height={68} title="Cheryl" src="https://www.vacation.rentals/images/users/10023/profile_pic_1523290913_225x225.JPG" alt="Cheryl" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10023">Cheryl Hillis</a> has expired.
                            <div>
                              <a href="https://www.vacation.rentals/reservation/itinerary?code=0CW4GC">View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10043">
                            <img width={68} height={68} title="Wendy" src="https://www.vacation.rentals/images/users/10043/profile_pic_1526594786_225x225.jpg" alt="Wendy" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10043">Wendy Sherrill</a> has expired.
                            <div>
                              <a href="https://www.vacation.rentals/reservation/itinerary?code=765AX7">View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10114">
                            <img width={68} height={68} title="Kyra" src="https://graph.facebook.com/10214051279133317/picture?type=large" alt="Kyra" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10114">Kyra Drennan</a> has expired.
                            <div>
                              <a>View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10051">
                            <img width={68} height={68} title="Test" src="https://www.vacation.rentals/images/users/10051/profile_pic_1529654739_225x225.jpg" alt="Test" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10051">Test Test</a> has expired.
                            <div>
                              <a href="https://www.vacation.rentals/reservation/itinerary?code=S2FH65">View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10062">
                            <img width={68} height={68} title="Eddie" src="https://www.vacation.rentals/images/users/10062/profile_pic_1529655118_225x225.jpg" alt="Eddie" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10062">Eddie Padin</a> has expired.
                            <div>
                              <a>View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10023">
                            <img width={68} height={68} title="Cheryl" src="https://www.vacation.rentals/images/users/10023/profile_pic_1523290913_225x225.JPG" alt="Cheryl" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10023">Cheryl Hillis</a> has expired.
                            <div>
                              <a>View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10016">
                            <img width={68} height={68} title="Terri" src="https://www.vacation.rentals/images/users/10016/profile_pic_1539722449_225x225.jpeg" alt="Terri" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10016">Terri Anderson</a> has expired.
                            <div>
                              <a href="https://www.vacation.rentals/reservation/itinerary?code=915K9X">View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" href="https://www.vacation.rentals/users/show/10016">
                            <img width={68} height={68} title="Terri" src="https://www.vacation.rentals/images/users/10016/profile_pic_1539722449_225x225.jpeg" alt="Terri" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a href="https://www.vacation.rentals/users/show/10016">Terri Anderson</a> has expired.
                            <div>
                              <a href="https://www.vacation.rentals/reservation/itinerary?code=I4I5P5">View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                        <li className="media reviews-list-item row-space-top-2">
                          <a className="pull-left media-photo media-round" >
                            <img width={68} height={68} title="Vincent" src="https://www.vacation.rentals/images/user_pic-225x225.png" alt="Vincent" />
                          </a>
                          <div className="media-body response">
                            Your time to write a review for <a >Vincent Idaspe</a> has expired.
                            <div>
                              <a>View Itinerary</a>
                            </div>
                          </div>
                          <div className="clearfix" />
                          <hr className="col-12" />
                        </li>
                         </ul>
                    </div>
                  </div>
                </div>
              
            </TabPanel>
            </Tabs>
            </div>
        )
    }
}

export default Reviews