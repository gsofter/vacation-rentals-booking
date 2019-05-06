import React from "react";
import Pricingtitle from "./pricingtitle/Pricingtitle";
import property_help from "../img/property-help.png";
import Currency from "./currency/Currency";
import Nightly from "./nightly/Nightly";
import Monthly from "./monthly/Monthly";
import Weekend from "./weekend/Weekend";
import Minnights from "./minnights/Minnights";
import Cleanfee from "./cleanfee/Cleanfee";
import Additionalcharge from "./additionalcharge/Additionalcharge";
import Tax from "./tax/Tax";
import Refundable from "./refundable/Refundable";
import Occupancy from "./occupancy/Occupancy";
import Mindiscount from "./mindiscount/Mindiscount";
import Editprice from "./editprice/Editprice";
import Seasonalbutton from "./seasonalbutton/Seasonalbutton";
import Pricingbutton from "./pricingbutton/Pricingbutton";
import axios from "axios";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { connect } from "react-redux";
import {
  renderSidebarAction,
  renderStopSidebarAction
} from "../../../../actions/managelisting/renderSidebarAction";

class Pricing extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      page_data: {}
    };
    this.currencyChange = this.currencyChange.bind(this);
    this.nightChange = this.nightChange.bind(this);
    this.monthlyChange = this.monthlyChange.bind(this);
    this.mininightChange = this.mininightChange.bind(this);
    this.cleaningChange = this.cleaningChange.bind(this);
    this.weekendChange = this.weekendChange.bind(this);
    this.handleChangeRoomsPrice = this.handleChangeRoomsPrice.bind(this);
    this.handleRoomChange = this.handleRoomChange.bind(this);
  }
  componentDidMount() {
    axios
      .get(
        `/ajax/rooms/manage_listing/${this.props.match.params.roomId}/basics`
      )
      .then(res => {
        let result = res.data;
        this.setState(
          {
            page_data: result
          },
          () => {
            let active_lists = document.getElementsByClassName("nav-active");
            for (let i = 0; i < active_lists.length; i++) {
              active_lists[i].classList.remove("nav-active");
            }
            let room_step = "pricing";
            let current_lists = document.getElementsByClassName(
              `nav-${room_step}`
            );
            for (let i = 0; i < current_lists.length; i++) {
              current_lists[i].classList.add("nav-active");
              // active_lists[i].classList.remove("nav-active");
            }

            console.log(active_lists);
          }
        );
      });
  }
  cleaningChange(e) {
    let name = e.target.name;
    let value = e.target.value;
    let page_data = this.state.page_data;
    page_data.rooms_price[name] = value;
    this.setState({
      page_data: page_data
    });
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_price`,
        {
          data: JSON.stringify({
            currency_code: this.state.page_data.rooms_price.currency_code,
            [name]: value
          })
        }
      )
      .then(res => {
        if (res.data.success != "false") {
          // toast.success("Saved default Currency!", {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
          this.setState(
            {
              page_data: page_data
            },
            () => {
              !this.props.re_render
                ? this.props.renderSidebarAction()
                : this.props.renderStopSidebarAction();
            }
          );
        } else {
          // toast.error(res.data.msg, {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        }
      });
  }
  mininightChange(e) {
    let value = e.target.value;
    let page_data = this.state.page_data;
    page_data.rooms_price.minimum_stay = value;
    this.setState({
      page_data: page_data
    });
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_price`,
        {
          data: JSON.stringify({
            minimum_stay: value,
            currency_code: this.state.page_data.rooms_price.currency_code
          })
        }
      )
      .then(res => {
        if (res.data.success != "false") {
          // toast.success("Saved!", {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        } else {
          // toast.error(res.data.msg, {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        }
        !this.props.re_render
          ? this.props.renderSidebarAction()
          : this.props.renderStopSidebarAction();
      });
  }
  weekendChange(e) {
    let value = e.target.value;
    let page_data = this.state.page_data;
    page_data.rooms_price.weekend = value;
    page_data.rooms_price.original_weekend = value;
    this.setState({
      page_data: page_data
    });
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_price`,
        {
          data: JSON.stringify({
            weekend: value,
            currency_code: this.state.page_data.rooms_price.currency_code
          })
        }
      )
      .then(res => {
        if (res.data.success != "false") {
          // toast.success("Saved default Currency!", {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        } else {
          // toast.error(res.data.msg, {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        }
        !this.props.re_render
          ? this.props.renderSidebarAction()
          : this.props.renderStopSidebarAction();
      });
  }
  nightChange(e) {
    let value = e.target.value;
    let page_data = this.state.page_data;
    page_data.rooms_price.night = value;
    page_data.rooms_price.original_night = value;
    this.setState({
      page_data: page_data
    });
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_price`,
        {
          data: JSON.stringify({
            night: value,
            currency_code: this.state.page_data.rooms_price.currency_code
          })
        }
      )
      .then(res => {
        console.log(res);
        if (res.data.success != "false") {
          // toast.success("Saved default Currency!", {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        } else {
          // toast.error(res.data.msg, {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        }
        !this.props.re_render
          ? this.props.renderSidebarAction()
          : this.props.renderStopSidebarAction();
      });
  }
  handleChangeRoomsPrice(e) {
    e.preventDefault();
    let value = e.target.value;
    let name = e.target.name;
    let page_data = this.state.page_data;
    page_data.rooms_price[name] = value;
    this.setState({
      page_data: page_data
    });
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_price`,
        {
          data: JSON.stringify({
            [name]: value,
            currency_code: this.state.page_data.rooms_price.currency_code
          })
        }
      )
      .then(res => {
        if (res.data.success != "false") {
          // toast.success("Saved "+ name +" Currency!", {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        } else {
          // toast.error(res.data.msg, {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        }
        !this.props.re_render
          ? this.props.renderSidebarAction()
          : this.props.renderStopSidebarAction();
      });
  }
  monthlyChange(e) {
    let name = e.target.name;
    let value = e.target.value;
    let page_data = this.state.page_data;
    page_data.rooms_price[name] = value;
    page_data.rooms_price["original_" + name] = value;
    // original_week
    this.setState({
      page_data: page_data
    });
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_price`,
        {
          data: JSON.stringify({
            currency_code: this.state.page_data.rooms_price.currency_code,
            [name]: value
          })
        }
      )
      .then(res => {
        if (res.data.success != "false") {
          // toast.success("Saved default Currency!", {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
          this.setState(
            {
              page_data: page_data
            },
            () => {
              !this.props.re_render
                ? this.props.renderSidebarAction()
                : this.props.renderStopSidebarAction();
            }
          );
        } else {
          // toast.error(res.data.msg, {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        }
      });
  }
  currencyChange(e) {
    let value = e.target.value;
    let page_data = this.state.page_data;
    page_data.rooms_price.currency_code = value;
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_price`,
        {
          data: JSON.stringify({
            currency_code: value,
            night: this.state.page_data.rooms_price.night
          })
        }
      )
      .then(res => {
        if (res.data.success != "false") {
          toast.success("Saved default Currency!", {
            position: toast.POSITION.TOP_RIGHT
          });
        } else {
          // toast.error(res.data.msg, {
          //     position: toast.POSITION.TOP_RIGHT
          //   });
        }
        this.setState(
          {
            page_data: page_data
          },
          () => {
            !this.props.re_render
              ? this.props.renderSidebarAction()
              : this.props.renderStopSidebarAction();
          }
        );
      });
  }
  handleRoomChange(e) {
    e.preventDefault();
    let page_data = this.state.page_data;
    page_data.result.accommodates = e.target.value;
    this.setState({
      page_data: page_data
    });
    axios
      .post(
        `/ajax/rooms/manage-listing/${
          this.props.match.params.roomId
        }/update_rooms`,
        {
          current_tab: this.state.current_lang,
          data: JSON.stringify({ accommodates: e.target.value })
        }
      )
      .then(res => {
        !this.props.re_render
          ? this.props.renderSidebarAction()
          : this.props.renderStopSidebarAction();
        toast.success("Saved !", {
          position: toast.POSITION.TOP_RIGHT
        });
      });
  }
  render() {
    console.log("Parent", this.state.page_data.rooms_price);
    return (
      <div className="manage-listing-content-wrapper clearfix">
        <ToastContainer />
        <div className="listing_whole col-md-8" id="js-manage-listing-content">
          <div className="common_listpage">
            <Pricingtitle roomId={this.props.match.params.roomId} />
            <Currency
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              onChange={this.currencyChange}
              data={
                this.state.page_data.currencies
                  ? this.state.page_data.currencies
                  : []
              }
              value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : ""
              }
            />
            <Nightly
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.original_night
                  : 0
              }
              onChange={this.nightChange}
            />
            <Monthly
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              onChange={this.monthlyChange}
              week_value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.original_week
                  : 0
              }
              month_value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.original_month
                  : 0
              }
            />
            <Weekend
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              onChange={this.weekendChange}
              value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.original_weekend
                  : 0
              }
            />
            <Minnights
              value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.minimum_stay
                  : 1
              }
              onChange={this.mininightChange}
            />
            <h2 className="h-two-raja">Additional Charges:</h2>
            <Cleanfee
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              type_value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.cleaning_fee_type
                  : 0
              }
              fee_value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.cleaning
                  : 0
              }
              onChange={this.cleaningChange}
            />
            <Additionalcharge
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              roomId={this.props.match.params.roomId}
              data={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.additional_charge
                  : "[]"
              }
            />
            <Tax
              value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.tax
                  : ""
              }
              onChange={this.handleChangeRoomsPrice}
            />
            <Refundable
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              value={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.security
                  : ""
              }
              onChange={this.handleChangeRoomsPrice}
            />
            <Occupancy
              handleRoomChange={this.handleRoomChange}
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              max_guests={
                this.state.page_data.result
                  ? this.state.page_data.result.accommodates
                  : 0
              }
              guests={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.guests
                  : 0
              }
              additional_guest={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.additional_guest
                  : 0
              }
              onChange={this.handleChangeRoomsPrice}
            />
            <h2 className="h-two-raja">Last min discounts</h2>
            <Mindiscount roomId={this.props.match.params.roomId} />
            <Editprice
              code={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price.currency_code
                  : "USD"
              }
              data={
                this.state.page_data.rooms_price
                  ? this.state.page_data.rooms_price
                  : {}
              }
            />
            <Seasonalbutton />
            <Pricingbutton roomId={this.props.match.params.roomId} />
          </div>
        </div>
        <div className="col-md-4 col-sm-12 listing_desc">
          <div className="manage_listing_left">
            <img
              src={property_help}
              alt="property-help"
              className="col-center"
              width="75"
              height="75"
            />
            <div className="amenities_about">
              <h4>Charges per night</h4>
              <p>
                You may want attract your first few guests by offering a great
                deal. You can always increase your price after you’ve received
                some great reviews.
              </p>
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
  renderSidebarAction: () => dispatch(renderSidebarAction),
  renderStopSidebarAction: () => dispatch(renderStopSidebarAction)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Pricing);
