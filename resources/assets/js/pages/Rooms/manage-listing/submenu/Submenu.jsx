import React from "react";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import SideNav from "react-simple-sidenav";
import Axios from "axios";
import { connect } from "react-redux";
import { rerenderSidebarAction } from "../../../../actions/managelisting/renderSidebarAction";

class Submenu extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      page_data: {},
      sidebarOpen: false,
      room_step: this.props.room_step,
      rooms_step_status: {},
      room_details: {}
    };
    this.onSetSidebarOpen = this.onSetSidebarOpen.bind(this);
  }
  componentDidMount() {
    // console.log('manage-listings')
    Axios.post(
      "/ajax/rooms/manage-listing/" + this.props.roomId + "/rooms_steps_status"
    ).then(result => {
      this.setState({
        rooms_step_status: result.data
      });
    });
    Axios.get(`/ajax/rooms/manage_listing/${this.props.roomId}/basics`).then(
      res => {
        let result = res.data.result;
        this.setState({
          page_data: result
        });
      }
    );
  }
  componentWillReceiveProps(nextprops) {
    Axios.get(`/ajax/rooms/manage_listing/${this.props.roomId}/basics`).then(
      res => {
        let result = res.data.result;
        this.setState({
          page_data: result
        });
      }
    );
  }
  activeMenu(room_step) {
    this.setState(
      {
        room_step: room_step
      },
      () => {
        this.setState({
          sidebarOpen: false
        });
      }
    );
  }
  onSetSidebarOpen(open) {
    this.setState({
      sidebarOpen: open
    });
  }

  render() {
    return (
      <div>
        <div className="subnav ml-header-subnav">
          <ul className="subnav-list ">
            <li className="show-if-collapsed-nav hide" id="collapsed-nav">
              <Link
                to="/pricing_listing_details1"
                className="subnav-item show-collapsed-nav-link"
                id="price-id"
              >
                <i className="icon icon-reorder show-collapsed-nav-link--icon" />
                <span className="show-collapsed-nav-link--text">
                  Pricing, listing details…
                </span>
              </Link>
            </li>
            <li className="subnav-text">
              <span id="listing-name"> {this.state.page_data.name} </span>
            </li>
          </ul>
          <ul className="subnav-list has-collapsed-nav hide-md tespri">
            <li className="show-if-collapsed-nav" id="collapsed-nav">
              <a
                onClick={() => this.onSetSidebarOpen(true)}
                href="javascript:;"
                className="subnav-item show-collapsed-nav-link"
              >
                <i className="icon icon-reorder show-collapsed-nav-link--icon" />
                <span className="show-collapsed-nav-link--text">
                  Pricing, listing details…
                </span>
              </a>
            </li>
          </ul>
        </div>

        <div
          className="manage-listing-header fixed-top"
          id="js-manage-listing-header"
        >
          <SideNav
            showNav={this.state.sidebarOpen}
            onHideNav={() => this.setState({ sidebarOpen: false })}
            title={<div>Manage Listings</div>}
            titleStyle={{
              backgroundColor: "#2196F3",
              lineHeight: "unset",
              fontSize: "14pt"
            }}
            itemStyle={{
              fontSize: "12pt",
              paddingTop: "10px",
              paddingBottom: "10px"
            }}
            items={[
              <Link
                to={`${this.props.base_url}/basics`}
                onClick={() => this.activeMenu("basics")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Basics</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.basics == "1"
                          ? "js-new-section-icon not-post-listed pull-right transition hide"
                          : "js-new-section-icon not-post-listed pull-right transition"
                      }
                    >
                      <i className="nav-icon icon icon-add icon-grey" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.basics == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed " />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/description`}
                onClick={() => this.activeMenu("description")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Description</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.description == "1"
                          ? "js-new-section-icon not-post-listed pull-right transition hide"
                          : "js-new-section-icon not-post-listed pull-right transition"
                      }
                    >
                      <i className="nav-icon icon icon-add icon-grey" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.description == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed " />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/location`}
                onClick={() => this.activeMenu("location")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Location</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.location == "1"
                          ? "js-new-section-icon not-post-listed pull-right transition hide"
                          : "js-new-section-icon not-post-listed pull-right transition "
                      }
                    >
                      <i className="nav-icon icon icon-add icon-grey" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.location == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed " />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/amenities`}
                onClick={() => this.activeMenu("amenities")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Amenities</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/photos`}
                onClick={() => this.activeMenu("photos")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Photos</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.photos == "1"
                          ? "js-new-section-icon not-post-listed pull-right transition hide"
                          : "js-new-section-icon not-post-listed pull-right transition"
                      }
                    >
                      <i className="nav-icon icon icon-add icon-grey" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.photos == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed " />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/video`}
                onClick={() => this.activeMenu("video")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Video</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                  </div>
                </div>
              </Link>,
              <Link to="/guidebook">
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Guidebook</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/pricing`}
                onClick={() => this.activeMenu("pricing")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Pricing</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.pricing == "1"
                          ? "js-new-section-icon not-post-listed pull-right transition hide"
                          : "js-new-section-icon not-post-listed pull-right transition"
                      }
                    >
                      <i className="nav-icon icon icon-add icon-grey" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.pricing == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed " />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/calendar`}
                onClick={() => this.activeMenu("calendar")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Calendar</span>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/terms`}
                onClick={() => this.activeMenu("terms")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Terms</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.terms == "1"
                          ? "js-new-section-icon not-post-listed pull-right transition hide"
                          : "js-new-section-icon not-post-listed pull-right transition"
                      }
                    >
                      <i className="nav-icon icon icon-add icon-grey" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.terms == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed " />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>,
              <Link
                to={`${this.props.base_url}/plans`}
                onClick={() => this.activeMenu("plans")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Publish</span>
                    <div className="instant-book-status pull-right">
                      <div className="instant-book-status__on hide">
                        <i className="icon icon-bolt icon-beach h3" />
                      </div>
                      <div className="instant-book-status__off hide">
                        <i className="icon icon-bolt icon-light-gray h3" />
                      </div>
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.plans == "1"
                          ? "js-new-section-icon not-post-listed pull-right transition hide"
                          : "js-new-section-icon not-post-listed pull-right transition"
                      }
                    >
                      <i className="nav-icon icon icon-add icon-grey" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.plans == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed " />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            ]}
          />
        </div>
      </div>
    );
  }
}
const mapStateToProps = state => ({
  ...state
});
const mapDispatchToProps = dispatch => ({
  rerenderSidebarAction: () => dispatch(rerenderSidebarAction)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Submenu);

// export default Submenu;
