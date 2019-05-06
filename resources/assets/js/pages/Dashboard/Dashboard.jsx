import React from "react";
import { Route, Link } from "react-router-dom";
import Dashboardmain from "./pages/Dashboardmain";
import Rooms from "./pages/Rooms";
import Reservation from "./pages/Reservation";
import Profiles from "./pages/Profiles";
import CurrentTrips from "./pages/trips/CurrentTrips";
import OldTrips from "./pages/trips/OldTrips";
import Security from "./pages/Security";
import ManageList from "./manage-listing/Manage_listing";
import Editprofile from "./pages/Profiles/Editprofile";
import Photos from "./pages/Profiles/Photos";
import Verification from "./pages/Profiles/Verification";
import BAaccount from "./pages/ba/BAaccount";
import BAupdate from "./pages/ba/BAupdate";
import BAmanageroomid from "./pages/ba/BAmanage_roomid";
class Dashboard extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      sidebarOpen: false,
      menuList: [
        {
          url: "/dashboard",
          icon: "far fa-sun",
          text: "Dashboard",
          is_sub_menu: false
        },
        {
          url: "/dashboard",
          icon: "fas fa-list-ol",
          text: "Listing",
          is_sub_menu: true,
          sub_menu: [
            {
              url: "/dashboard/rooms",
              text: "Your Listing",
              is_sub_menu: false
            },
            {
              url: "/dashboard/reservation",
              text: "Your Reservation",
              is_sub_menu: false
            }
          ]
        },
        {
          url: "/dashboard",
          icon: "fab fa-tripadvisor",
          text: "Trips",
          is_sub_menu: true,
          sub_menu: [
            {
              url: "/dashboard/mytrips",
              text: "Your Trips",
              is_sub_menu: false
            },
            {
              url: "/dashboard/oldtrips",
              text: "Your Previous Trips",
              is_sub_menu: false
            }
          ]
        },
        {
          url: "/dashboard",
          icon: "far fa-user",
          text: "Profile",
          is_sub_menu: true,
          sub_menu: [
            {
              url: "/dashboard/myprofile",
              text: "Edit Profile",
              is_sub_menu: false
            },
            { url: "/dashboard/photo", text: "Photo", is_sub_menu: false },
            {
              url: "/dashboard/edit_verification",
              text: "Verification",
              is_sub_menu: false
            },
            {
              url: "/dashboard/account_ba",
              text: "Booking Automation Account",
              is_sub_menu: false
            }
          ]
        },
        {
          url: "/dashboard/myaccount",
          icon: "far fa-sun",
          text: "Account",
          is_sub_menu: false
        },
        {
          url: "/dashboard/account_ba",
          icon: "far fa-user",
          text: "Booking Automation",
          is_sub_menu: true,
          sub_menu: [
            {
              url: "/dashboard/account_ba",
              text: "Manage api keys",
              is_sub_menu: false
            },
            {
              url: "/dashboard/ba_manage_roomid",
              text: "Manage room ids",
              is_sub_menu: false
            },
            {
              url: "/dashboard/ba_update",
              text: "Update page",
              is_sub_menu: false
            }
          ]
        }
      ]
    };
    this.onSetSidebarOpen = this.onSetSidebarOpen.bind(this);
    this.handleMenuClick = this.handleMenuClick.bind(this);
  }
  onSetSidebarOpen(open) {
    this.setState({
      sidebarOpen: open
    });
  }
  handleMenuClick(event, index) {
    event.preventDefault();
    let menuItems = this.state.menuList;
    menuItems[index].active = !menuItems[index].active;
    this.setState(
      {
        menuList: menuItems
      },
      () => {
        console.log(event, index, "Menu Item Clicked!!!", this.state.menuList);
      }
    );
  }
  render() {
    console.log(
      this.props.location.pathname === `${this.props.match.url}/inbox`
    );
    return (
      <main>
        <div className="head-title">
          <div className="container">
            <div className="head-wrap">
              <div className="head-main">
                <nav aria-label="breadcrumb">
                  <ol className="breadcrumb">
                    <li className="breadcrumb-item">
                      <a href="#">
                        <i className="fa fa-home" />
                      </a>
                    </li>
                    <li className="breadcrumb-item active" aria-current="page">
                      Dashboard
                    </li>
                  </ol>
                </nav>
              </div>
              <div className="head-inbox">
                <a href="/inbox" className="btn btn-outline-light">
                  Inbox
                  <i className="fas fa-comment-alt" />
                </a>
              </div>
            </div>
          </div>
        </div>
        <section className="dashboard_">
          <div className="container">
            <div className="row">
              <div className="col-md-3">
                <div className="sidebar">
                  <div className="list-group">
                    <ul>
                      {this.state.menuList.map((menuItem, index) => {
                        return (
                          <li
                            key={index}
                            className={
                              menuItem.active == true
                                ? "open-sub"
                                : "parent-drop"
                            }
                          >
                            {menuItem.is_sub_menu ? (
                              <a
                                href="javascript:void(0)"
                                className="list-group-item list-group-item-action"
                                onClick={event =>
                                  this.handleMenuClick(event, index)
                                }
                              >
                                <i className={menuItem.icon} /> {menuItem.text}{" "}
                                {menuItem.is_sub_menu ? (
                                  <i className="fas fa-angle-right" />
                                ) : null}
                              </a>
                            ) : (
                              <a
                                href={menuItem.url}
                                className="list-group-item list-group-item-action"
                              >
                                <i className={menuItem.icon} /> {menuItem.text}{" "}
                                {menuItem.is_sub_menu ? (
                                  <i className="fas fa-angle-right" />
                                ) : null}
                              </a>
                            )}
                            {menuItem.is_sub_menu && (
                              <ul
                                className={`sub-menus ${
                                  menuItem.active == true ? "active" : ""
                                }`}
                              >
                                {menuItem.sub_menu.map(
                                  (sub_menu, sub_index) => {
                                    return (
                                      <li key={sub_index}>
                                        <a href={sub_menu.url}>
                                          {sub_menu.text}
                                        </a>
                                      </li>
                                    );
                                  }
                                )}
                              </ul>
                            )}
                          </li>
                        );
                      })}
                    </ul>
                  </div>
                </div>
              </div>
              <Route exact path="/dashboard" component={Dashboardmain} />
              <Route path="/dashboard/rooms" component={Rooms} />
              <Route path="/dashboard/reservation" component={Reservation} />
              <Route exact path="/dashboard/mytrips" component={CurrentTrips} />
              <Route path="/dashboard/oldtrips" component={OldTrips} />
              <Route path={`/dashboard/myprofile`} component={Editprofile} />
              <Route path={`/dashboard/photo`} component={Photos} />
              <Route path={`/dashboard/editprofile`} component={Profiles} />
              <Route path={`/dashboard/reviews`} component={Profiles} />
              <Route
                path={`/dashboard/edit_verification`}
                component={Verification}
              />
              <Route path={`/dashboard/photos`} component={Profiles} />
              <Route path={`/dashboard/security`} component={Security} />
              <Route path={`/dashboard/myaccount`} component={Security} />
              <Route path={`/dashboard/managelist`} component={ManageList} />
              <Route path={`/dashboard/account_ba`} component={BAaccount} />
              <Route path={`/dashboard/ba_update`} component={BAupdate} />
              <Route
                path={`/dashboard/ba_manage_roomid`}
                component={BAmanageroomid}
              />
            </div>
          </div>
        </section>
        {/* main-content ends here */}
      </main>
    );
  }
}
export default Dashboard;
