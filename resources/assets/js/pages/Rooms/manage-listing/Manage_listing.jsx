import React from "react";
import { Route } from "react-router-dom";
import "./manage_listing.css";
import Submenu from "./submenu/Submenu";
import Sidebar from "./sidebar/Sidebar";
import Basic from "./basic/Basic";
import Description from "./description/Description";
import Pricing from "./pricing/Pricing";
import Calendar from "./calendar/Calendar";
import Location from "./location/Location";
import Amenities from "./amenities/Amenities";
import Photos from "./photos/Photos";
import Videopage from "./video/Video";
import Plan from "./publish/Publish";
import Baroom from "./baroom/Baroom";
import "react-tabs/style/react-tabs.css";
class Manage_listing extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      render_count: 0
    };
    this.rerender = this.rerender.bind(this);
  }
  rerender() {
    this.setState({
      render_count: this.state.render_count + 1
    });
  }
  render() {
    return (
      <main id="site-content">
        <Submenu
          base_url={this.props.match.url}
          roomId={this.props.match.params.roomId}
        />
        <div className="manage-listing-row-container row">
          <Sidebar
            base_url={this.props.match.url}
            roomId={this.props.match.params.roomId}
          />
          <div id="ajax_container" className="col-lg-10 col-md-9">
            {/* <Route exact  base_url={this.props.match.url} component = {Basic}/> */}
            <Route
              path={`/rooms/manage-listing/:roomId/basics`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Basic}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/description`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Description}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/pricing`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Pricing}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/calendar`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Calendar}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/location`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Location}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/amenities`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Amenities}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/photos`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Photos}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/video`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Videopage}
            />
            <Route
              path={`/rooms/manage-listing/:roomId/plans`}
              base_url={this.props.match.url}
              rerender={this.rerender}
              component={Plan}
            />
          </div>
        </div>
        {/* <Subfooter/> */}
      </main>
    );
  }
}

export default Manage_listing;
