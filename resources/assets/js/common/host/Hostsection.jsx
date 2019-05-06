import React from 'react'
// import booking_1 from './img/booking_1.jpg';
// import booking_2 from './img/booking_2.jpeg';
// import list_vacation1 from './img/list_vacation1.jpg';

class Hostsection extends React.PureComponent{

render(){
      return (
  
        <section className="host-section">
        <div className="page-container-responsive page-container-no-padding">
          <div className="row flex-container">
            <div className="col-md-4">
              <a href="#">
                <div className="host-area cenralize">
                  <div className="host-container h-260">
                    <img src="https://res.cloudinary.com/vacation-rentals/image/upload/c_fill,fl_lossy,q_auto:low,w_auto/v1555703148/images/booking_1.png"   alt="" />
                    <div className="image-shadow" />
                  </div>
                  <h4 className="stat-text">Deal direct with your host</h4>
                  <ul className="host-list">
                    <li>Open, unfiltered communication</li>
                    <li>Phone - email - even Live Chat</li>
                    <li>Build trust before you book</li>
                  </ul>
                </div>
              </a>
            </div>
            <div className="col-md-4">
              <a href="#">
                <div className="host-area cenralize">
                  <div className="host-container h-260">
                    <img src="https://res.cloudinary.com/vacation-rentals/image/upload/c_fill,fl_lossy,q_auto:low,w_auto/v1555703149/images/booking_2.png"  alt="" />
                    <div className="image-shadow" />
                  </div>
                  <h4 className="stat-text">Why list your home with us?</h4>
                  <ul className="host-list">
                    <li>Advertising and exposure</li>
                    <li>A simple annual membership and nothing more</li>
                    <li>Reach more prospective clients</li>
                  </ul>
                </div>
              </a>
            </div>
            <div className="col-md-4">
              <a href="#" className="login_popup_open">
                <div className="host-area cenralize">
                  <div className="host-container h-260">
                    <img src="https://res.cloudinary.com/vacation-rentals/image/upload/c_fill,fl_lossy,q_auto:low,w_auto/v1555703148/images/list-vacation1.png"  alt="" />
                    <div className="image-shadow" />
                  </div>
                  <h4 className="stat-text">List your vacation rental</h4>
                  <ul className="host-list">
                    <li>It only takes minutes</li>
                    <li>Easy calendar, rates, and gallery</li>
                    <li>Immediate exposure</li>
                  </ul>
                </div>
              </a>
            </div>
          </div>
        </div>
      </section>

      );
    }
  };

  export default Hostsection;