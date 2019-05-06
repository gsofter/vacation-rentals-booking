import React from 'react'
import dateFns from "date-fns";
import './calendar.css'
class BookingCalendar extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            currentMonth: new Date(),
            selectedDate: new Date(),
            start_date: null,
            end_date: null,
            hover_able: false,

        }
        this.onDateClick = this.onDateClick.bind(this)
        this.onHoverDate = this.onHoverDate.bind(this)
        this.nextMonth = this.nextMonth.bind(this)
        this.prevMonth = this.prevMonth.bind(this)
        this.reseetDateRange = this.reseetDateRange.bind(this)
    }
    componentDidMount() {
        this.props.reseetDateRange(this.reseetDateRange)
    }
    reseetDateRange() {
        // alert('Hello')
        this.setState({
            start_date: null,
            end_date: null,
            selectedDate: new Date()
        })
    }
    renderHeader() {
        const dateFormat = "MMMM YYYY";
        const dateFormat1 = "DD/MM/YYYY";
        return (
            <div className="wtbcaption">
                <div className="row">
                    <div className="mr-auto">
                        <div className="legend">
                            <div className="legend_item">Season<span className="seasonal_price_highlight legend_key" /></div>
                            <div className="legend_item"> Reservation <span className="reserved_highlight legend_key" /></div>
                            <div className="legend_item">Blocked <span className="unavailable_highlight legend_key" /></div>
                        </div>

                    </div>
                    <div className="ml-auto">
                        <button onClick={this.prevMonth}>Prev</button>
                        <button onClick={this.nextMonth}>Next</button>
                    </div>
                </div>

                <div className="row">
                    <div className="col col-center">
                        <span>
                            {dateFns.format(this.state.currentMonth, dateFormat)}
                        </span>
                    </div>
                </div>

            </div>
        );
    }
    onHoverDate(day) {
        const dateFormat_1 = 'YYYY-MM-DD';
        if (this.state.start_date && this.state.hover_able && (
            !this.props.unavailable_dates
            || !this.props.unavailable_dates.unavailable_dates
            || this.props.unavailable_dates.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1)) == -1)) {
            this.setState({
                selectedDate: day,
                end_date: day
            });
        }
    }
    renderDays() {
        const dateFormat = "ddd";
        const days = [];
        let startDate = dateFns.startOfWeek(this.state.currentMonth);
        for (let i = 0; i < 7; i++) {
            days.push(
                <div className="wtbhead" key={i}>
                    {dateFns.format(dateFns.addDays(startDate, i), dateFormat)}
                </div>
            );
        }
        return <div className="wtbheading"><div className="wtbrow">{days}</div></div>;
    }
    renderCells() {
        const dateFormat_1 = 'YYYY-MM-DD';

        const { currentMonth, selectedDate } = this.state;
        const monthStart = dateFns.startOfMonth(currentMonth);
        const monthEnd = dateFns.endOfMonth(monthStart);
        const startDate = dateFns.startOfWeek(monthStart);
        const endDate = dateFns.endOfWeek(monthEnd);
        const dateFormat = "D";
        const rows = [];
        let days = [];
        let day = startDate;
        let formattedDate = "";
        let date_count = 0;
        while (day <= endDate) {
            for (let i = 0; i < 7; i++) {
                formattedDate = dateFns.format(day, dateFormat);
                const cloneDay = day;
                days.push(

                    <div
                        className={`wtbcell caldt  align-items-center ${
                            !dateFns.isSameMonth(day, monthStart)
                                ? "disabled"
                                : dateFns.isSameDay(day, selectedDate) ? "selected" : ""
                            } 
                    
                            ${
                            this.props.unavailable_dates &&
                                this.props.unavailable_dates.unavailable_dates &&
                                this.props.unavailable_dates.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1)) != -1 ?
                                'booked ' +
                                this.props.unavailable_dates.day_types[this.props.unavailable_dates.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1))] + ' ' +
                                this.props.unavailable_dates.day_position[this.props.unavailable_dates.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1))] + ' ' +
                                (
                                    this.props.unavailable_dates.day_position[this.props.unavailable_dates.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1))] == 'checkin' ? (
                                        this.props.unavailable_dates.day_position[this.props.unavailable_dates.unavailable_dates.indexOf(dateFns.format(dateFns.subDays(day, 1), dateFormat_1))] == 'checkin' ? 'checkout' : ''
                                    ) : ''
                                )

                                : 'editable '
                            }
                            ${this.state.start_date && this.state.end_date && ((dateFns.isAfter(day, this.state.start_date) && dateFns.isBefore(day, this.state.end_date) || dateFns.isSameDay(day, this.state.start_date) || dateFns.isSameDay(day, this.state.end_date))) ? 'range_selected' : ''}
                            `
                        }
                        key={day}
                        onClick={() => this.onDateClick(dateFns.parse(cloneDay))}
                        onMouseEnter={() => this.onHoverDate(dateFns.parse(cloneDay))}
                    >
                        {/* {this.props.seasonal_calendar && this.props.seasonal_calendar.seasonal_days && this.props.seasonal_calendar.seasonal_days.indexOf(dateFns.format(day, dateFormat_1)) != -1 ?  */}
                        <span className={`seasonal ${this.props.seasonal_calendar && this.props.seasonal_calendar.seasonal_days && this.props.seasonal_calendar.seasonal_days.indexOf(dateFns.format(day, dateFormat_1)) != -1 ? 'active' : ''}`}>
                            {this.props.calendarData && this.props.calendarData.calendar_data && this.props.calendarData.calendar_data[date_count] ? <strong><span dangerouslySetInnerHTML={{ __html: this.props.calendarData.calendar_data[date_count].price_symbol }}></span>{this.props.calendarData.calendar_data[date_count].price}</strong> : ''}
                        </span>
                        {/* {: ''} */}
                        <span className="number ">{formattedDate}</span>
                        {/* <span className="bg">{formattedDate}</span> */}
                    </div>

                );
                day = dateFns.addDays(day, 1);
                date_count++;
            }
            rows.push(
                <div className="wtbrow " key={day}>
                    {days}
                </div>
            );
            days = [];

        }
        return <div className="wtbbody">{rows}</div>;
    }
    onDateClick(day) {
        const dateFormat_1 = 'YYYY-MM-DD';
        if (this.props.unavailable_dates && this.props.unavailable_dates.unavailable_dates && this.props.unavailable_dates.unavailable_dates.indexOf(dateFns.format(day, dateFormat_1)) != -1) {

        }
        else {

        }

        if (!this.state.start_date || !this.state.hover_able) {
            this.setState({
                selectedDate: day,
                end_date: null,
                start_date: day,
                hover_able: true
            });
        }
        else {
            if (dateFns.isAfter(day, this.state.start_date)) {
                this.setState({
                    selectedDate: day,
                    end_date: day,
                    hover_able: false
                });
                this.props.onSelectedRange(this.state.start_date, this.state.end_date)
            }
            else {
                this.setState({
                    selectedDate: day,
                    end_date: null,
                    start_date: day,
                    hover_able: true
                });
            }

        }
    }
    nextMonth() {
        this.setState({
            currentMonth: dateFns.addMonths(this.state.currentMonth, 1)
        }, () => { this.props.updateCurrentMonth(this.state.currentMonth) });

    }
    prevMonth() {
        this.setState({
            currentMonth: dateFns.subMonths(this.state.currentMonth, 1)
        }, () => { this.props.updateCurrentMonth(this.state.currentMonth) });
    }
    render() {

        return <div className="month-container"><div className="calendar-wrap-sm"><div className="wtb-sm">
            {this.renderHeader()}
            {this.renderDays()}

            {this.renderCells()}
        </div></div></div>
    }
}
export default BookingCalendar