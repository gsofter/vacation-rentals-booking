import React, { Component } from "react";
import axios from "axios";

class BAaccount extends Component {
  constructor(props) {
    super(props);

    this.state = {
      is_ba_memeber: false,
      credentials: []
    };
  }

  componentWillMount() {
    axios
      .get("/ba/acccounts/getba_credential")
      .then(response => {
        var res = response.data;
        console.log(res);
        if (res.success == false) {
          this.setState({
            is_ba_memeber: false,
            credentials: []
          });
        } else {
          this.setState({
            is_ba_memeber: true,
            credentials: response.data.data
          });
        }

        console.log();
      })
      .catch(error => {
        console.log(error);
      });
  }

  onClickUpdate(event) {
    axios.get("/ba/api/update").then(response => {
      var res = response.data;
      if (res.success == false) {
        alert("Not success");
      } else {
        alert("Success");
      }
    });
  }
  render() {
    return (
      <div className="col-md-8 col-sm-8 col-lg-8">
        <div className="panel">
          <div className="panel panel-header">
            <h1>Booking Automation Credential Info</h1>
          </div>
          <div className="panel panel-body">
            <div>
              <form action="/ba/account/register" method="post">
                <div className="form-group">
                  <label className="col-sm-4">PropID</label>
                  <input
                    type="text"
                    placeholder="propid"
                    name="propid"
                    defaultValue={this.state.credentials.prop_id || ""}
                  />
                </div>

                <div className="form-group">
                  <label className="col-sm-4">OTA Password</label>
                  <input
                    type="text"
                    placeholder="OTA password"
                    name="otapassword"
                    defaultValue={this.state.credentials.ota_password || ""}
                  />
                </div>

                <div className="form-group">
                  <label className="col-sm-4">APIKey</label>
                  <input
                    type="text"
                    placeholder="apikey"
                    name="apikey"
                    defaultValue={this.state.credentials.api_key || ""}
                  />
                </div>

                <div className="form-group">
                  <label className="col-sm-4">PropKey</label>
                  <input
                    type="text"
                    placeholder="propkey"
                    name="propkey"
                    defaultValue={this.state.credentials.prop_key || ""}
                  />
                </div>

                <div className="form-group">
                  <button className="btn btn-success" type="submit">
                    Save
                  </button>
                  <button className="btn btn-danger" type="reset">
                    Cancel
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
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

export default BAaccount;
