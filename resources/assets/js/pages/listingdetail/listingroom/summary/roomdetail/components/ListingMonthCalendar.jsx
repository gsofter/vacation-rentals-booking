import React from "react";
import dateFns from "date-fns";
import Axios from "axios";
const dateFormat_1  = "YYYY-MM-DD"
class ListingMonthCalendar extends React.Component {
  constructor(props){
      super(props)
      this.state = {
        
        selectedDate: null
      };
  }
  componentDidMount(){
      
  }
  
  renderHeader() {
    const dateFormat = "MMMM YYYY";

    return (
      <div className="header row flex-middle">
        
        <div className="col col-center text-center">
          <span>{dateFns.format(this.props.current_month, dateFormat)}</span>
        </div>
      
      </div>
    );
  }

  renderDays() {
    const dateFormat = "dd";
    const days = [];

    let startDate = dateFns.startOfWeek(this.props.current_month);

    for (let i = 0; i < 7; i++) {
      days.push(
        <th className="" key={i}>
          {dateFns.format(dateFns.addDays(startDate, i), dateFormat)}
        </th>
      );
    }

    return <tr className="">{days}</tr>;
  }

  renderCells() {
    const {  selectedDate } = this.state;
    const monthStart = dateFns.startOfMonth(this.props.current_month);
    const monthEnd = dateFns.endOfMonth(monthStart);
    const startDate = dateFns.startOfWeek(monthStart);
    const endDate = dateFns.endOfWeek(monthEnd);

    const dateFormat = "D";
    const rows = [];

    let days = [];
    let day = startDate;
    let formattedDate = "";

    while (day <= endDate) {
      for (let i = 0; i < 7; i++) {
        formattedDate = dateFns.format(day, dateFormat);
        const cloneDay = day;
        days.push(
          <td
            className={`  ${
              !dateFns.isSameMonth(day, monthStart)
                ? "disabled"
                : dateFns.isSameDay(day, selectedDate) ? "" : ""
            }
            
                ${
                this.props.calendar_data &&
                    this.props.calendar_data.unavailable_dates &&
                    this.props.calendar_data.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1)) != -1 ?
                    'booked ' +
                    this.props.calendar_data.day_types[this.props.calendar_data.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1))] + ' ' +
                    this.props.calendar_data.day_position[this.props.calendar_data.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1))] + ' ' +
                    (
                        this.props.calendar_data.day_position[this.props.calendar_data.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1))] == 'checkin' ? (
                            this.props.calendar_data.day_position[this.props.calendar_data.unavailable_dates.indexOf(dateFns.format(dateFns.subDays(day, 1), dateFormat_1))] == 'checkin' ? 'checkout' : ''
                        ) : ''
                    )

                    : 'editable '
                }
            
            `}
            key={day}
            onClick={() => this.onDateClick(dateFns.parse(cloneDay))}
          >
            <span className="">{formattedDate}</span>
            {/* <span className="bg">{formattedDate}</span> */}
          </td>
        );
        day = dateFns.addDays(day, 1);
      }
      rows.push(
        <tr className="" key={day}>
          {days}
        </tr>
      );
      days = [];
    }
    return <tbody className="">{rows}</tbody>;
  }

  onDateClick(day) {
    this.setState({
      selectedDate: day
    });
  };

  nextMonth(){
    this.setState({
      
    });
  };

  prevMonth(){
    this.setState({
      
    });
  };

  render() {
    return (
      <div className="calendar col-md-6">
        {this.renderHeader()}
        <table className='table'>
            <thead>
        {this.renderDays()}
        </thead>
        
        {this.renderCells()}
      
        </table>
      </div>
    );
  }
}

export default ListingMonthCalendar;