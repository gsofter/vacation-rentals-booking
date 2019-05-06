import React, { Component } from "react";
import axios from "axios";

class BAUpdate extends Component {
  constructor(props) {
    super(props);

    this.state = {
      is_ba_memeber: false,
      credentials: []
    };
  }

  onClickUpdate(event) {
    axios
      .get("/ba/api/update")
      .then(response => {
        var res = response.data;
        if (res.success == false) {
          alert("Not success");
        } else {
          alert("Success");
        }
      })
      .catch(error => {
        console.log(error);
      });
  }
  render() {
    return (
      <div className="col-md-8 col-sm-8 col-lg-8">
        <div className="card col-md-8 col-sm-8 p-5 mt-2">
          <p> Updated data from Booking Automation </p>
          <div className="clearfix" />
          <button className="btn btn-info" onClick={this.onClickUpdate}>
            Update
          </button>
        </div>
      </div>
    );
  }
}

export default BAUpdate;
