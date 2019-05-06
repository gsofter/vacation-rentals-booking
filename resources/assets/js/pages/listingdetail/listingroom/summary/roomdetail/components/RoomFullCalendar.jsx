import React from 'react'

import DateRangePicker from 'react-daterange-picker'
import 'react-daterange-picker/dist/css/react-calendar.css' // For some basic styling. (OPTIONAL)
// import moment from 'moment-range';
import Moment from 'moment';
import { extendMoment } from 'moment-range';
import './fullcalendar.css'
const moment = extendMoment(Moment);
export default class RoomFullCalendar extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            full_mode : false
        }
        this.onToggle = this.onToggle.bind(this)
    }
    onToggle(){
        this.setState({
            full_mode : !this.state.full_mode
        })
    }
    render(){
        console.log(this.props.calendar_data, 'year calendar tracking')
        const stateDefinitions = {
            available: {
                color: null,
                label: 'Available',
              },
              enquire: {
                color: '#ffd200',
                label: 'Enquire',
              },
              unavailable: {
                selectable: false,
                color: '#34ed38',
                label: 'Unavailable',
              },
          };
          const dateRanges = [
           
          ];
          this.props.calendar_data.map((_range, index) =>{
              dateRanges.push(
                {
                  state: 'unavailable',
                  range: moment.range(
                    moment(_range.start_date, 'YYYY-MM-DD'),
                    moment(_range.end_date, 'YYYY-MM-DD')
                  ),
                },)
          })
          
        return <div>
            <div className='row text-center mt-2'><span onClick={this.onToggle} className='mx-auto'>{this.state.full_mode ? 'View optimize calendar' : 'View Full Calendar'}</span></div>
             <DateRangePicker
                disableNavigation={true}
             
                minimumDate={new Date()}
                stateDefinitions={stateDefinitions}
                dateStates={dateRanges}
                defaultState="available"
                numberOfCalendars = {this.state.full_mode ? 12 : 4}
        />
        </div>
    }
}