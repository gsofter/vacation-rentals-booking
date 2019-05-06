import React from 'react'

class OldTrips extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      page_data: {
        previous_trips: []
      }
    }
  }
  componentDidMount() {
    fetch('/ajax/dashboard/getOldTripsList')
      .then(response => response.json())
      .then(data => {
        console.log(data)
        this.setState({
          page_data: data.page_data
        })
      })
  }
  render() {
    let page_content = [];


    let trips_list = this.state.page_data.previous_trips.map((trip) => {
      return trip.rooms ? <tr key={trip.id}>
        <td className="status">
          <span className="label label-orange label-info">
            <span className={"label label-" + trip.status_color}>
              {trip.status}
            </span>
          </span>
          <br />
        </td>
        <td className="location">
          <a   >
            {trip.rooms ? trip.rooms.name : 'No rooms'}
          </a>
          <br />

          {trip.room_address_city_or_state}
        </td>
        <td className="host">
          <a >{trip.host}
          </a>
        </td>
        <td className="dates">{trip.dates_subject}
        </td>
        <td>
          <ul className="unstyled button-list list-unstyled">
            <li className="row-space-1">
              <a className="button-steel"  >Message History
                  </a>
              <br />
              <a className="button-steel"  >Cancel Request
                  </a>
            </li>
          </ul>
        </td>
      </tr>
        : null

    })


    page_content.push(
      <div className="panel row-space-4" key='pending_trips'>
        <div className="panel-header">
          Previous Trips
                </div>
        <div className="table-responsive">
          <table className="table panel-body panel-light">
            <tbody>
              <tr>
                <th>Status
                        </th>
                <th>Location
                        </th>
                <th>Host
                        </th>
                <th>Dates
                        </th>
                <th>Options
                        </th>
              </tr>
              {trips_list.length ? trips_list : <tr><td colSpan='100%' className='text-center'>You have no previous trips!</td></tr>}
            </tbody>
          </table>
        </div>
      </div>
    )
    let page_data = page_content ? page_content : '<div>No Data</div>'
    return (<div class="col-md-9">
      <div class="aside-main-content">
        <div class="side-cnt">
          <div class="head-label">
            <h4>Previous Trips</h4>
          </div>
          <div class="aside-main-cn">
            <div class="your-prev-trips_">
              <div class="table-responsive">
                <table class="table panel-body panel-light">
                  <tbody>
                    <tr>
                      <th>Status</th>
                      <th>Location</th>
                      <th>Host</th>
                      <th>Dates</th>
                      <th>Options</th>
                    </tr>
                    {trips_list.length ? trips_list : <tr><td colSpan='100%' className='text-center'>You have no previous trips!</td></tr>}
                    </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>)
  }
}

export default OldTrips