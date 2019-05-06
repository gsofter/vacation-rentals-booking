import React from "react";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import { connect } from "react-redux";
import { rerenderSidebarAction } from "../../../../actions/managelisting/renderSidebarAction";
// import { stopAction} from '../../../../actions/stopAction'
import "./sidebar.css";
import Axios from "axios";

class Sidebar extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      page_data: {},
      room_step: this.props.room_step,
      rooms_step_status: {}
    };
    this.activeMenu = this.activeMenu.bind(this);
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
  }
  componentWillReceiveProps(nextprops) {
    Axios.post(
      "/ajax/rooms/manage-listing/" + this.props.roomId + "/rooms_steps_status"
    ).then(result => {
      this.setState({
        rooms_step_status: result.data
      });
    });
  }
  activeMenu(room_step) {
    this.setState({
      room_step: room_step
    });
  }

  render() {
    console.log(this.props.re_render);
    console.log("side_bar_render");
    return (
      <div
        className="col-lg-2 lang-pos col-md-3 listing-nav-sm nopad"
        id="js-manage-listing-nav h-100"
      >
        <div className="nav-sections height_adj">
          <ul className="list-unstyled margin-bot-5 list-nav-link">
            <li
              id="basics"
              className={
                this.state.room_step == "basics"
                  ? "nav-item nav-basics pre-listed nav-active"
                  : "nav-item nav-basics pre-listed"
              }
            >
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
                      <i className="fas fa-plus" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.basics == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="fas fa-check text-success" />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "description"
                  ? "nav-item nav-description pre-listed nav-active"
                  : "nav-item nav-description pre-listed"
              }
            >
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
                      <i className="fas fa-plus" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.description == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="fas fa-check text-success" />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "location"
                  ? "nav-item nav-location pre-listed nav-active"
                  : "nav-item nav-location pre-listed"
              }
            >
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
                      <i className="fas fa-plus" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.location == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="fas fa-check text-success" />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "amenities"
                  ? "nav-item nav-amenities pre-listed nav-active"
                  : "nav-item nav-amenities pre-listed"
              }
            >
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
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "photos"
                  ? "nav-item nav-photos pre-listed nav-active"
                  : "nav-item nav-photos pre-listed"
              }
            >
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
                      <i className="fas fa-plus" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.photos == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="fas fa-check text-success" />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "video"
                  ? "nav-item nav-video pre-listed nav-active"
                  : "nav-item nav-video pre-listed"
              }
            >
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
              </Link>
            </li>
          </ul>
          <ul className="list-unstyled margin-bot-5 list-nav-link">
            <li className="nav-item nav-guidebook post-listed">
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
              </Link>
            </li>
          </ul>
          <ul className="list-unstyled margin-bot-5 list-nav-link list-nav-link">
            <li
              className={
                this.state.room_step == "pricing"
                  ? "nav-item nav-pricing pre-listed nav-active"
                  : "nav-item nav-pricing pre-listed"
              }
            >
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
                      <i className="fas fa-plus" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.pricing == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="fas fa-check text-success" />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "calendar"
                  ? "nav-item nav-calendar pre-listed nav-active"
                  : "nav-item nav-calendar pre-listed"
              }
            >
              <Link
                to={`${this.props.base_url}/calendar`}
                onClick={() => this.activeMenu("calendar")}
              >
                <div className="row nav-item">
                  <div className="col-sm-12 va-container">
                    <span className="va-middle">Calendar</span>
                  </div>
                </div>
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "terms"
                  ? "nav-item nav-terms pre-listed nav-active"
                  : "nav-item nav-terms pre-listed"
              }
            >
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
                      <i className="fas fa-plus" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.terms == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="fas fa-check text-success" />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            </li>
            <li
              className={
                this.state.room_step == "plans"
                  ? "nav-item nav-plans pre-listed nav-active"
                  : "nav-item nav-plans pre-listed"
              }
            >
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
                      <i className="fas fa-plus" />
                    </div>
                    <div
                      className={
                        this.state.rooms_step_status.plans == "1"
                          ? "pull-right lang-left-change"
                          : "pull-right lang-left-change hide"
                      }
                    >
                      <i className="fas fa-check text-success" />
                      <i className="dot dot-success hide" />
                    </div>
                  </div>
                </div>
              </Link>
            </li>
          </ul>
        </div>
        <div className="publish-actions text-center">
          <div id="user-suspended" />
          <div id="availability-dropdown">
            <i className="dot row-space-top-2 col-top dot-danger" />
            &nbsp;
            <div className="select">
              <select className="room_status_dropdown" disabled>
                <option value="Listed">Listed</option>
                <option value="Unlisted">Unlisted</option>
                <option value="Draft">Draft</option>
              </select>
            </div>
          </div>
          <div id="js-publish-button" className="mt-2">
            <div className="not-post-listed text-center">
              <div
                className="animated text-lead text-muted steps-remaining js-steps-remaining show"
                style={{ opacity: 1 }}
              >
                Complete
                <strong className="text-highlight">
                  <span id="steps_count">6</span> steps
                </strong>{" "}
                to list your space.
              </div>

              {/* <a className="animated btn btn-large btn-host btn-primary list-your-space js-list-space-button" to="subscription">
                            Buy Subscription
                        </Link> */}
            </div>
          </div>
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
)(Sidebar);
// export default Sidebar;
