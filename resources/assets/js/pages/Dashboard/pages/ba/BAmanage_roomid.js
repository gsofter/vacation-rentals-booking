import React, { Component } from "react";
import axios from "axios";

class BAmanage_roomid extends Component {
  constructor(props) {
    super(props);
    this.state = {
      page_data: []
    };
    this.handleChangeStatus = this.handleChangeStatus.bind(this);
    this.handlePublish = this.handlePublish.bind(this);
  }
  componentDidMount() {
    fetch("/ajax/dashboard/getlistings")
      .then(response => response.json())
      .then(data => {
        console.log(data);
        this.setState({
          page_data: data.page_data
        });
      });
  }

  handleChangeStatus(list_id, event) {
    event.preventDefault();
    console.log(list_id, event);
    let value = event.target.value;
    let list_index = this.state.page_data.rooms_list.filter(
      list => list.id === list_id
    );
    list_index = this.state.page_data.rooms_list.indexOf(list_index[0]);
    let { page_data } = this.state;
    console.log(list_index);
    page_data.rooms_list[list_index].status = value;
    page_data.rooms_list[list_index].published = "unpublished";
    this.setState({
      page_data: page_data
    });
  }
  handlePublish(list_id, event) {
    event.preventDefault();
    console.log(list_id, event);
    let value = event.target.value;
    let list_index = this.state.page_data.rooms_list.filter(
      list => list.id === list_id
    );
    let temp_room = list_index[0];
    list_index = this.state.page_data.rooms_list.indexOf(list_index[0]);
    let { page_data } = this.state;
    console.log(list_index);
    // page_data.rooms_list[list_index].status = value
    Axios.post("/ajax/change_status_of_room", {
      room_id: list_id,
      status: temp_room.status
    })
      .then(response => {
        console.log(response);
        if (response.data.status == "success") {
          toast.success(response.data.message, {
            position: toast.POSITION.TOP_CENTER
          });
          page_data.rooms_list[list_index].published = "published";
          this.setState({
            page_data: page_data
          });
        }
      })
      .catch(err => {
        toast.error("Error!!!", {
          position: toast.POSITION.TOP_CENTER
        });
      });
  }

  addBaId(index, e) {
    let { page_data } = this.state;
    axios
      .get(
        "/ba/api/set_baroomid?roomid=" +
          page_data.rooms_list[index].id +
          "&&ba_roomid=" +
          page_data.rooms_list[index].ba_roomid
      )
      .then(response => {
        console.log(response.data);
        if (response.data.success == true) {
          alert(response.data.message);
        } else {
          alert(response.data.message);
        }
      });
  }

  onChangeInput(index, evt) {
    let { page_data } = this.state;
    console.log(index);
    page_data.rooms_list[index].ba_roomid = evt.target.value;
  }
  render() {
    let { page_data } = this.state;
    let listed_result_section = [];
    let unlisted_result_section = [];
    if (page_data.rooms_list && page_data.rooms_list.length) {
      page_data.rooms_list.map((list, index) => {
        const room_list = (
          <li>
            <div className="row" key={index}>
              <div className="col-lg-2 col-md-3">
                <a
                  href={`/homes/${list.address_url}/${list.id}`}
                  target="_blank"
                >
                  <div className="media-cover text-center">
                    <img src={list.featured_image} className="img-responsive" />
                  </div>
                </a>
              </div>
              <div className="col-lg-7 col-md-5">
                <span className="list-ink">
                  <a
                    href={`/homes/${list.address_url}/${list.id}`}
                    target="_blank"
                  >
                    {list.name}
                  </a>
                </span>

                {list.ba_roomid == null || list.ba_roomid == "" ? (
                  <div className="form-group">
                    <div className="form-group">
                      <input
                        name={`${list.id}`}
                        defaultValue=""
                        onChange={e => this.onChangeInput(index, e)}
                      />
                    </div>
                    <button
                      className="btn btn-info"
                      onClick={e => this.addBaId(index, e)}
                    >
                      Add {list.ba_roomid}
                    </button>
                  </div>
                ) : (
                  <div className="form-group">
                    <div className="form-group">
                      <input
                        name={`${list.id}`}
                        defaultValue={`${list.ba_roomid}`}
                        disabled
                      />
                    </div>
                    <span className="alert alert-success strong">Linked</span>
                  </div>
                )}
              </div>
            </div>
          </li>
        );

        listed_result_section.push(room_list);
      });
    }
    return (
      <div className="col-md-9">
        <div className="aside-main-content">
          <div className="side-cnt">
            <div className="head-label">
              <h4>Add Booking Automation room id for each room</h4>
            </div>
            <div className="aside-main-cn">
              <div className="your-listing_">
                <ul className="list-unstyled listing-all">
                  {listed_result_section}
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div className="aside-main-content">
          <div className="head-label">
            <h4>Unlisted</h4>
          </div>
          <div className="aside-main-cn">
            <div className="your-listing_">
              <ul className="list-unstyled listing-all">
                {unlisted_result_section}
              </ul>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default BAmanage_roomid;
