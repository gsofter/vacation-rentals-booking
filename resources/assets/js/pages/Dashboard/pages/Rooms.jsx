import React from 'react'
import { BrowserRouter as Router, Redirect, Link } from 'react-router-dom';
 

// import './room.css'
import Axios from 'axios';
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

class Rooms extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      page_data: []
    }
    this.handleChangeStatus = this.handleChangeStatus.bind(this)
    this.handlePublish = this.handlePublish.bind(this)
  }
  componentDidMount() {
    fetch('/ajax/dashboard/getlistings')
      .then(response => response.json())
      .then(data => {
        console.log(data)
        this.setState({
          page_data: data.page_data
        })
      });
  }
  
  handleChangeStatus(list_id, event) {
    event.preventDefault();
    console.log(list_id, event)
    let value = event.target.value
    let list_index = this.state.page_data.rooms_list.filter((list) => list.id === list_id)
    list_index = this.state.page_data.rooms_list.indexOf(list_index[0])
    let {page_data} = this.state;
    console.log(list_index)
    page_data.rooms_list[list_index].status = value
    page_data.rooms_list[list_index].published = 'unpublished'
    this.setState({
      page_data : page_data
    })

  }
  handlePublish(list_id, event){
    event.preventDefault();
    console.log(list_id, event)
    let value = event.target.value
    let list_index = this.state.page_data.rooms_list.filter((list) => list.id === list_id)
    let temp_room = list_index[0]
    list_index = this.state.page_data.rooms_list.indexOf(list_index[0])
    let {page_data} = this.state;
    console.log(list_index)
    // page_data.rooms_list[list_index].status = value
    Axios.post('/ajax/change_status_of_room',{room_id : list_id, status : temp_room.status} )
    .then(response => {
      console.log(response)
      if(response.data.status == 'success'){
        toast.success(response.data.message,{
          position: toast.POSITION.TOP_CENTER
        } )
        page_data.rooms_list[list_index].published = 'published'
        this.setState({
          page_data : page_data
        })
      }
      
    })
    .catch(err => {
      toast.error('Error!!!',{
        position: toast.POSITION.TOP_CENTER
      } )
    })
    
      
  }
  render() {
    let { page_data } = this.state;
    let listed_result_section = []
    let unlisted_result_section = []
    if(page_data.rooms_list && page_data.rooms_list.length){
      page_data.rooms_list.map((list) => {
        const room_list =  <li>
        <div className="row">
          <div className="col-lg-2 col-md-3">
          <a href={`/homes/${list.address_url}/${list.id}`}  target="_blank">
              <div className="media-cover text-center">
                <img src={list.featured_image} className="img-responsive" />
              </div>
            </a>
          </div>
          <div className="col-lg-7 col-md-5">
            <span className="list-ink">
            <a href={`/homes/${list.address_url}/${list.id}`}  target="_blank">{list.name}</a>
            </span>
            <div className="actions">
            <a className="listing-link-space" href={`/rooms/manage-listing/${list.id}/basics`} target="_blank">Manage Listing and
                Calendar</a>
            </div>
          </div>
          <div className="col-lg-3 col-md-4 text-right">
            <div className="listing-criteria-header">
              <div className="hide-sm show-md show-lg">
                <div className="field-wrapper">
                  <label htmlFor="state" className='show'>Listed</label>
                  <select name="State" placeholder="State" className="form-in "  data-room-id={list.id} value={list.status} onChange={(event) => this.handleChangeStatus(list.id, event)}>
                    <option value="Listed" selected="selected">Listed</option>
                    <option value="Unlisted">Unlisted</option>
                    <option value="Draft">Draft</option>
                  </select>
                </div>
              </div>
              
              { list.has_subscription == false && list.steps_count == 0 ? <a  className="list-noti" href={`/rooms/${list.id}/subscribe_property`} target='_blank'>Publish</a> : <span className="list-noti">Published</span>  }
              { list.published != 'unpublished' ? '' : <a href="javascript:void(0)" data-id={list.id} className="list-noti ml-1" onClick={(event)=>this.handlePublish(list.id, event)}> | Save Status</a>}
            </div>
          </div>
        </div></li>
     
        
        if(list.status == 'Listed'){
            listed_result_section.push(room_list)
        }
        else{
            unlisted_result_section.push(room_list)
        }
      })
    }
     return (
      <div className="col-md-9">
      <div className="aside-main-content">
        <div className="side-cnt">
          <div className="head-label">
            <h4>Listed</h4>
          </div>
          <div className="aside-main-cn">
            <div className="your-listing_">
              <ul className="list-unstyled listing-all">
              {
                listed_result_section
              }
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
     )
     
  }
}

export default Rooms