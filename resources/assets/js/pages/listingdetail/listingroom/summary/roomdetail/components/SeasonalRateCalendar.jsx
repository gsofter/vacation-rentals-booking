import React from 'react'
import ReactTable from "react-table";
import 'react-table/react-table.css'
import dateFns from "date-fns";
import Axios from 'axios';
import RoomFullCalendar from './ListingFullCalendar';


const dateFormat = "MM/DD/YYYY";
export default class SeasonalRateCalendar extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            seasonal_price_detail : [],
            calendar_data : []
        }
    }
    componentDidMount(){
        Axios.get(`/ajax/homes/seasonal_rate/${this.props.room_id}`)
        .then(Response =>{
            this.setState({
                seasonal_price_detail : Response.data.seasonal_price_detail
            })
        })
        Axios.get(`/ajax/homes/${this.props.room_id}/unavailable_calendar`)
        .then(Response =>{
            this.setState({
                calendar_data : Response.data
            })
        })
    }
    render(){
        const seasonal_columns = [
            {
                Header: 'Name',
                style: { width: '100%', textAlign: 'center' },
                accessor: 'seasonal_name', // String-based value accessors!,
                minWidth: 200,
                Cell: props => <div className="w-100">
                    <div className="row col-md-12">
                        <strong className="mx-auto">{props.value}</strong> </div>
                    <div className="row col-md-12"><span className="mx-auto">({dateFns.format(new Date(props.original.start_date), dateFormat)} - {dateFns.format(new Date(props.original.end_date), dateFormat)})</span></div>
                </div>
            }, {
                Header: 'Nightly',
                style: { width: '100%', textAlign: 'center' },
                accessor: 'price',
                Cell: props => <span className='text-center'><strong>{props.value}</strong></span> // Custom cell components!
            }, {
                Header: 'Weekly',
                style: { width: '100%', textAlign: 'center' },
                accessor: 'week',
                Cell: props => <span className='text-center'><strong>{props.value}</strong></span> // Custom cell components!
            
            }, {
                Header: 'Weekend',
                style: { width: '100%', textAlign: 'center' },
                accessor: 'weekend',
                Cell: props => <span className='text-center'><strong>{props.value}</strong></span> // Custom cell components!
            }, {
                Header: 'Monthly',
                style: { width: '100%', textAlign: 'center' },
                accessor: 'month',
                Cell: props => <span className='text-center'><strong>{props.value}</strong></span> // Custom cell components!
            }, {
                Header: 'Min. Stay',
                style: { width: '100%', textAlign: 'center' },
                accessor: 'minimum_stay',
                Cell: props => <span className='text-center'> <strong>{props.value}</strong>Nights</span> // Custom cell components!
            }
        ];
        return <div>
            <div className='mt-2'>
            
            <ReactTable
                                data={this.state.seasonal_price_detail}
                                columns={seasonal_columns}
                                defaultPageSize={5}
                                minRows={0}
                                noDataText='Empty Data'

                            />
        </div>
        <div className='mt-2'>
            
            <RoomFullCalendar room_id={this.props.room_id} calendar_data = {this.state.calendar_data}/>
        </div>
        </div>
    }
}