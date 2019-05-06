import React from "react";
import axios from "axios";

class Baroom extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      ba_roomid: ""
    };
  }
  componentDidMount() {
    let active_lists = document.getElementsByClassName("nav-active");
    for (let i = 0; i < active_lists.length; i++) {
      active_lists[i].classList.remove("nav-active");
    }
    let room_step = "baroom";
    let current_lists = document.getElementsByClassName(`nav-${room_step}`);
    for (let i = 0; i < current_lists.length; i++) {
      current_lists[i].classList.add("nav-active");
      // active_lists[i].classList.remove("nav-active");
    }

    axios
      .get("/ba/api/get_baroomid?roomid=" + this.props.match.params.roomId)
      .then(response => {
        var res = response.data;

        if (res.success == false) {
          this.setState({
            ba_roomid: ""
          });
        } else {
          this.setState({
            ba_roomid: response.data.ba_roomid
          });
        }
      })
      .catch(error => {
        alert(error);
        console.log(error);
      });
  }

  handleChange(event) {
    this.setState({ ba_room_id: event.target.value });
    alert(this.ba_room_id);
  }

  handleClick(event) {}
  render() {
    return (
      <div className="manage-listing-content-wrapper clearfix p-5">
        <div className="card p-5">
          <form action="/ba/api/set_baroomid/" method="get">
            <h2>BookingAutomation connection</h2>
            <div className="col-md-6 col-sm-6">
              <div className="form-group">
                <label>V.R Room id:</label>
                <input
                  type="text"
                  name="roomid"
                  defaultValue={this.props.match.params.roomId}
                  readOnly="readonly"
                />
              </div>
              <div className="form-group mt-2">
                <label>B.A Room id: </label>
                <input
                  type="text"
                  placeholder="ba_roomid"
                  name="ba_roomid"
                  defaultValue={this.state.ba_roomid || ""}
                />
              </div>
              <button className="btn btn-info mt-2" type="submit">
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    );
  }
}

export default Baroom;
