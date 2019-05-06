import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

import Modal from 'react-responsive-modal';
import BathModal from 'react-responsive-modal';
import axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
  import 'react-toastify/dist/ReactToastify.css';
  import SweetAlert from 'sweetalert-react';
  import {connect} from 'react-redux'
import { renderSidebarAction, renderStopSidebarAction} from '../../../../actions/managelisting/renderSidebarAction'
class Basic extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            removeModalShow : false,
            visible : false,
            visible_bathmodal : false,
            page_data : {},
            post_data : {
                bedroom_data : {
                    bedroom_id : null,
                    babycrib: 0,
                    bedroom_name: "",
                    bunkbed: 0,
                    murphy: 0,
                    nochildbed: 0,
                    noof_king: 0,
                    noofdouble: 0,
                    nooqueen: 0,
                    nosleepsofa: 0,
                    twinsingle: 0,
                },
                bathroom_data : {
                    bathroom_name : '',
                    bathroom_type : '',
                    bathfeature : []
                }
            },
            is_add_bedroom : true,
            is_add_bathroom : true

        }
        this.handleInputBedroomDetail = this.handleInputBedroomDetail.bind(this)
        this.handleBedroomSubmit = this.handleBedroomSubmit.bind(this)
        this.handleEditBedroomShow = this.handleEditBedroomShow.bind(this)
        this.handleRemoveBedroom = this.handleRemoveBedroom.bind(this)
        this.HandleBathroomInputDetails = this.HandleBathroomInputDetails.bind(this)
        this.handleBathroomSubmit = this.handleBathroomSubmit.bind(this)
        this.handleEditBathroomShow = this.handleEditBathroomShow.bind(this)
        this.handleRemoveBathroom = this.handleRemoveBathroom.bind(this)
    
    }
    componentDidMount(){
        axios.get(`/ajax/rooms/manage_listing/${this.props.match.params.roomId}/basics`)
         .then(res => {

            let result = res.data;
            this.setState({
                page_data : result
            }, () => {
                let active_lists = document.getElementsByClassName('nav-active')
                for(let i = 0 ; i < active_lists.length ; i++){
                    active_lists[i].classList.remove("nav-active");
                }
                let room_step = this.state.page_data.room_step
                let current_lists = document.getElementsByClassName(`nav-${room_step}`)
                for(let i = 0 ; i < current_lists.length ; i++){
                    current_lists[i].classList.add('nav-active')
                    // active_lists[i].classList.remove("nav-active");
                }
                
              
                // console.log(active_lists)
            });
         })

         console.log('Hello', this.props)
    }


    handleInputBedroomDetail(e){
        e.preventDefault();
        let target = e.target;
        let name = target.name;
        let value = target.value;
        let post_data = this.state.post_data
        post_data.bedroom_data[name] = value
        this.setState({
            post_data : post_data
        })
        // this.props.renderSidebarAction()
    }
    HandleBathroomInputDetails(e){
        // e.preventDefault();
        let target = e.target;
        let name = target.name;
        let value = target.value;
        let post_data = this.state.post_data
        if(target.type === 'checkbox'){
            let temp_array =  post_data.bathroom_data.bathfeature
            if(temp_array &&   temp_array.indexOf(value) != -1){
                temp_array.splice(temp_array.indexOf(value), 1)
            }
            else{
                temp_array.push(value)
            }
            post_data.bathroom_data[name] = temp_array;
        }
        else{
            post_data.bathroom_data[name] = value
        }
        // let value =  ? target.checked : target.value;
        
      
        this.setState({
            post_data : post_data
        })
    }
    handleBedroomSubmit(e){
        e.preventDefault();
        let bedroom_data = this.state.post_data.bedroom_data
        if(this.state.post_data.bedroom_data.bedroom_name){
            if(bedroom_data.babycrib || bedroom_data.bunkbed || bedroom_data.murphy || bedroom_data.nochildbed || bedroom_data.noof_king || bedroom_data.noofdouble || bedroom_data.nooqueen || bedroom_data.nosleepsofa || bedroom_data.twinsingle){
                    let _self = this
                    let post_data = _self.state.post_data.bedroom_data
                    post_data.room_id  = this.props.match.params.roomId

                    if(this.state.is_add_bedroom == true){
                    axios.post('/ajax/rooms/saveOrUpdate_bedroom', post_data)
                    .then(res =>{
                        
                        if (res.data.status == 'success') {
                     
                            toast.success("New Room Created Successfully", {
                               position: toast.POSITION.TOP_RIGHT
                             });
                             let page_data = this.state.page_data
                             page_data.bedrooms.push(res.data.result)
                             this.setState({
                                visible : false,
                                page_data : page_data
                             }, ()=>{
                                !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
                             })
                            //  this.props.history.push(res.data.redirect_url);
                               // history.push(res.data.redirect_url)
                         }
                         else{
                            toast.error(res.data.message, {
                               position: toast.POSITION.TOP_RIGHT
                             });
                         }
                    })
                }
                else{
                    post_data.id = _self.state.post_data.bedroom_data.bedroom_id
                    axios.post('/ajax/rooms/saveOrUpdate_bedroom', post_data)
                    .then(res =>{
                        
                        if (res.data.status == 'success') {
                            toast.success(res.data.message, {
                               position: toast.POSITION.TOP_RIGHT
                             });
                             let page_data = this.state.page_data
                            let bed_room_index = page_data.bedrooms.findIndex((bedroom, index) =>{
                                return bedroom.id == res.data.result.id
                            })
                            console.log(bed_room_index)
                            page_data.bedrooms[bed_room_index] = res.data.result
                             this.setState({
                                visible : false,
                                page_data : page_data
                             }, ()=>{
                                !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
                             })
                         }
                         else{
                            toast.error(res.data.message, {
                               position: toast.POSITION.TOP_RIGHT
                             });
                         }
                    })
                }
            }
            else{
                toast.error('At least one of above fields must be selected!.', {
                    position: toast.POSITION.TOP_RIGHT
                  }); 
            }
            
        }
        else{
            toast.error('Please Input Bedroom Name', {
                position: toast.POSITION.TOP_RIGHT
              }); 
        }
        
    }
    handleBathroomSubmit(e){
        e.preventDefault();
        let bathroom_data = this.state.post_data.bathroom_data
        if(bathroom_data.bathroom_name){
            if(bathroom_data.bathroom_type){
                 
                    let post_data = this.state.post_data.bathroom_data
                    post_data.room_id  = this.props.match.params.roomId
                    // console.log('before',post_data.bathfeature)
                    // post_data.bathfeature = JSON.stringify(post_data.bathfeature)
                    // console.log('after',post_data.bathfeature)
                    if(this.state.is_add_bathroom == true){
                        axios.post('/ajax/rooms/saveOrUpdate_bathroom', post_data)
                        .then(res =>{
                            
                            if (res.data.status == 'success') {
                                let page_data = this.state.page_data
                                page_data.bathrooms.push(res.data.result)
                               
                                toast.success("New Bathroom Created Successfully", {
                                position: toast.POSITION.TOP_RIGHT
                                });
                                this.setState({
                                    visible_bathmodal : false,
                                    page_data : page_data,
                                    is_add_bathroom : true
                                 }, ()=>{
                                    !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
                                 })
                            }
                            else{
                                toast.error(res.data.message, {
                                position: toast.POSITION.TOP_RIGHT
                                });
                            }
                        })
                    }
                    else{
                        post_data.id = this.state.post_data.bathroom_data.bathroom_id
                        axios.post('/ajax/rooms/saveOrUpdate_bathroom', post_data)
                        .then(res =>{
                            
                            if (res.data.status == 'success') {
                                let page_data = this.state.page_data
                                let bath_room_index = page_data.bathrooms.findIndex((bathroom, index) =>{
                                    return bathroom.id == res.data.result.id
                                })
                                console.log(bath_room_index)
                                page_data.bathrooms[bath_room_index] = res.data.result
                                 this.setState({
                                    visible_bathmodal : false,
                                    page_data : page_data,
                                    is_add_bathroom : false
                                 }, ()=>{
                                     !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
                                 })

                                // let page_data = this.state.page_data
                                // page_data.bathrooms.push(res.data.result)
                               
                                toast.success("Bathroom Updated Successfully", {
                                position: toast.POSITION.TOP_RIGHT
                                });
                                // this.setState({
                                //     visible_bathmodal : false,
                                //     page_data : page_data
                                //  })
                            }
                            else{
                                toast.error(res.data.message, {
                                position: toast.POSITION.TOP_RIGHT
                                });
                            }
                        })
                    }
                
            }
            else{
                toast.error('Please Choose Bathroom Type', {
                    position: toast.POSITION.TOP_RIGHT
                  }); 
            }
        }
        else{
            toast.error('Please Input Bathroom Name', {
                position: toast.POSITION.TOP_RIGHT
              }); 
        }
    }
    handleEditBedroomShow(bedroom_id, room_id,bedroom){
        // console.log(bedroom_id, room_id)
        let post_data = this.state.post_data
        let bedroom_detail = JSON.parse(bedroom.bedroom_details)
        // "{"king":"1","queen":0,"double":0,"single":0,"bunk":0,"child":0,"sleepsofa":0,"murphy":0,"babycrib":0}"
        post_data.bedroom_data = 
        {   babycrib: bedroom_detail.babycrib,
            bedroom_name: bedroom.bedroom_name,
            bunkbed: bedroom_detail.bunk,
            murphy: bedroom_detail.murphy,
            nochildbed: bedroom_detail.child,
            noof_king: bedroom_detail.king,
            noofdouble: bedroom_detail.double,
            nooqueen: bedroom_detail.queen,
            nosleepsofa: bedroom_detail.sleepsofa,
            twinsingle: bedroom_detail.single,
            bedroom_id : bedroom_id
        }
        this.setState({
            is_add_bedroom : false,
            post_data : post_data,
            visible : true
        })
    }
    handleEditBathroomShow(bathroom_id, room_id,bathroom){
        let post_data = this.state.post_data
        post_data.bathroom_data = {
            bathroom_id : bathroom_id,
            bathroom_name : bathroom.bathroom_name,
            bathroom_type : bathroom.bathroom_type,
            bathfeature :  bathroom.bathfeature ? bathroom.bathfeature.split(',') : []
        }
        this.setState({
            is_add_bathroom : false,
            post_data : post_data,
            visible_bathmodal : true
        })
        let checlbox_array = document.getElementsByClassName('checkbox_check');
        for(let i = 0 ; i < checlbox_array.length ;  i ++ ){
            console.log(checlbox_array)
            checlbox_array[i].checked = false
        }
        this.state.post_data.bathroom_data.bathfeature.map((item) =>{
            document.getElementById(item).checked = true
            console.log(document.getElementById(item).checked);
        })
    }
    handleRemoveBedroom(bedroom_id, room_id){
        console.log(bedroom_id, room_id)
        axios.post('/ajax/rooms/delete_bedroom', {bedid : bedroom_id, room_id : room_id})
        .then(res => {
            if (res.data.status == 'success') {
                     
                toast.success("New Room Created Successfully", {
                   position: toast.POSITION.TOP_RIGHT
                 });
                 let page_data = this.state.page_data
                 page_data.bedrooms = res.data.bedrooms
                 this.setState({
                    visible : false,
                    page_data : page_data
                 })
                //  this.props.history.push(res.data.redirect_url);
                   // history.push(res.data.redirect_url)
             }
             else{
                toast.error(res.data.message, {
                   position: toast.POSITION.TOP_RIGHT
                 });
             }
        })
    }
    handleRemoveBathroom(bathroom_id, room_id){
        axios.post('/ajax/rooms/delete_bathroom', {bathid : bathroom_id, room_id : room_id})
        .then(res => {
            if (res.data.status == 'success') {
                     
                toast.success("Bathroom Removed Successfully", {
                   position: toast.POSITION.TOP_RIGHT
                 });
                 let page_data = this.state.page_data
                 page_data.bathrooms = res.data.bathrooms
                 this.setState({
                    visible : false,
                    page_data : page_data
                 })
                //  this.props.history.push(res.data.redirect_url);
                   // history.push(res.data.redirect_url)
             }
             else{
                toast.error(res.data.message, {
                   position: toast.POSITION.TOP_RIGHT
                 });
             }
        })
    }
    openModal() {
        let post_data = this.state.post_data
        post_data.bedroom_data = 
        {   babycrib: 0,
            bedroom_name: '',
            bunkbed: 0,
            murphy: 0,
            nochildbed: 0,
            noof_king: 0,
            noofdouble: 0,
            nooqueen: 0,
            nosleepsofa: 0,
            twinsingle: 0,
            bedroom_id : null
        }
        this.setState({
            visible : true,
            is_add_bedroom : true
        });
    }
    openBathModal() {
        let post_data = this.state.post_data
        post_data.bathroom_data = {
            bathroom_id : null,
            bathroom_name :'',
            bathroom_type : '',
            bathfeature :   []
        }
        let checlbox_array = document.getElementsByClassName('checkbox_check');
        for(let i = 0 ; i < checlbox_array.length ;  i ++ ){
            console.log(checlbox_array)
            checlbox_array[i].checked = false
        }
        this.setState({
            is_add_bathroom : true,
            post_data : post_data,
            visible_bathmodal : true
        })
        this.setState({
            visible_bathmodal : true,
        });
    }
    
    closeModal() {
        this.setState({
            visible : false
        });
    }
    closeBathModal() {
        this.setState({
            visible_bathmodal : false
        });
    }

    render(){
      
        let bedroom_list = <span className='mr-4'>No Bedrooms Yet!</span>
        if(this.state.page_data.bedrooms) {
            bedroom_list = this.state.page_data.bedrooms.map((bedroom)=>{
                let bedroom_detail = JSON.parse(bedroom.bedroom_details)
                return  <div className="bedroom_rj" key={bedroom.id}>
                <h5>{bedroom.bedroom_name}</h5>
                <p><b>Beds:</b>
                  <span style={{textTransform: 'capitalize'}}>king ({bedroom_detail.king}), </span>
                  <span style={{textTransform: 'capitalize'}}>queen ({bedroom_detail.queen}), </span>
                  <span style={{textTransform: 'capitalize'}}>double ({bedroom_detail.double}), </span>
                  <span style={{textTransform: 'capitalize'}}>single ({bedroom_detail.single}), </span>
                  <span style={{textTransform: 'capitalize'}}>bunk ({bedroom_detail.bunk}), </span>
                  <span style={{textTransform: 'capitalize'}}>child ({bedroom_detail.child}), </span>
                  <span style={{textTransform: 'capitalize'}}>sleepsofa ({bedroom_detail.sleepsofa}), </span>
                  <span style={{textTransform: 'capitalize'}}>murphy ({bedroom_detail.murphy}), </span>
                  <span style={{textTransform: 'capitalize'}}>babycrib ({bedroom_detail.babycrib}), </span>
                  ; <a href="javascript:void(0)" className="editbedrooms" id="js-edit-bedrooms"  onClick={() => this.handleEditBedroomShow(bedroom.id, bedroom.room_id, bedroom)}><i className="fa fa-pencil" /></a> 
                  <a href="javascript:void(0)" className="deletebedrooms"  onClick={()=>this.handleRemoveBedroom(bedroom.id, bedroom.room_id)}><i className="fa fa-trash" /></a>
                </p></div>
            })
        }
        let bathroom_list = <span className='mr-4'>No Bathroom Yet!</span>
        if(this.state.page_data.bathrooms){
            bathroom_list = this.state.page_data.bathrooms.map((bathroom) => {
               return  <div className="bedroom_rj" key={bathroom.id}>
                <h5>{bathroom.bathroom_name}</h5>
                <p><b>BathRoom type:</b> <span>{bathroom.bathroom_type}</span></p>
                <p><b>Included Feature:</b> {bathroom.bathfeature}</p>
                <a href="javascript:void(0)" className="editbedrooms"  onClick={() => this.handleEditBathroomShow(bathroom.id, bathroom.room_id, bathroom)}><i className="fa fa-pencil" /></a> 
                <a href="javascript:void(0)" className="deletebathrooms" onClick={()=>this.handleRemoveBathroom(bathroom.id, bathroom.room_id)} ><i className="fa fa-trash" /></a>
              </div>
            })
        }
        console.log(this.props.re_render,'--------------------')
        return(
            
            <div className="manage-listing-content-wrapper clearfix">
             <Modal open={this.state.visible} onClose={() => this.closeModal()} center styles={{ modal:{padding:'0px'} }}>
             <div className="panel rjbedbathpanel ng-scope">
                                        <div className="panel-header">
                                         
                                            <div className="h4 js-address-nav-heading">Add Bedroom</div>
                                        </div>
                                        <form id="editbedroomsForm" name="editbedroomsForm" method="post" onSubmit={this.handleBedroomSubmit} style={{  overFolwY : 'scroll' }}>
                                        <div className="panel-body">
                                      
                                            <div className="col-md-12" >                       
                                                <label>Bedroom Name</label>
                                                <input type="text" name="bedroom_name" value={this.state.post_data.bedroom_data.bedroom_name} className="form-control rjcontrol" placeholder="Bedroom Name" required="" onChange={this.handleInputBedroomDetail}/>            
                                            </div>
                                                    
                                            <div className="col-6 col-md-4">
                                                <label>King</label>
                                                <select name="noof_king" value={this.state.post_data.bedroom_data.noof_king} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                        <option defaultValue="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Queen</label>
                                                <select name="nooqueen" value={this.state.post_data.bedroom_data.nooqueen} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Double</label>
                                                <select name="noofdouble" value={this.state.post_data.bedroom_data.noofdouble} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Twin / single</label>
                                                <select name="twinsingle" value={this.state.post_data.bedroom_data.twinsingle} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Bunk bed</label>
                                                <select name="bunkbed" value={this.state.post_data.bedroom_data.bunkbed} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Child bed</label>
                                                <select name="nochildbed" value={this.state.post_data.bedroom_data.nochildbed} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Sleep sofa / futon</label>
                                                <select name="nosleepsofa" value={this.state.post_data.bedroom_data.nosleepsofa} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Murphy bed</label>
                                                <select name="murphy" value={this.state.post_data.bedroom_data.murphy} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div>
                                            <div className="col-6 col-md-4">
                                                <label>Baby crib</label>
                                                <select name="babycrib" value={this.state.post_data.bedroom_data.babycrib} className="form-control rjcontrol" onChange={this.handleInputBedroomDetail}>
                                                                        <option defaultValue="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                </select>
                                            </div> 
                                            {/* <div className="col-12 col-md-12">               
                                                <span className="has-error ng-hide" >                
                                                    <span style={{opacity: 1}} className="help-block help-block-error">
                                                        At least one of above fields must be selected!.
                                                    </span>
                                                </span>
                                            </div> */}

                                            <div className="col-12 col-md-12 has-error ng-hide" ng-show="bedroom_validation_failed">
                                                
                                            </div>

                                        
                                        </div>
                                        <div className="panel-footer">
                                            {/* <a href="javascript:void(0);" onClick={() => this.closeModal()}>Close</a> */}
                                            <div className="force-oneline">
                                                <button onClick={() => this.closeModal()} className="btn js-secondary-btn">Cancel</button>
                                                <button id="bedroom_submit" type="submit" className="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
        </Modal>
            
           <ToastContainer />
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                
                    <div className="common_listpage">
                        <div className="content_show">
                        <div className="content_showhead">
                            <h1>Help Travelers Find the Right Fit</h1>
                            <p>People searching on Vacation.Rentals----- can filter by listing basics to find a space that matches their needs.</p>
                        </div>
                        <div className="content_right">
                            <div className="content_buttons">
                            
                            <a href={`/rooms/manage-listing/${this.props.match.params.roomId}/description`} className="right_save_continue">Next</a>
                            </div>
                        </div>
                        </div>
                        <hr className="row-space-top-6 row-space-5 post-listed" />
                        <div className="js-section list_hover col-sm-12 bathbedrj">
                        
                        <div className="base_decs">
                            <h4>Bedrooms <span className="requiredRJ">*</span></h4>
                        </div>
                        <div className="base_text">
                            <div className="rj_list_property" id="alloverbedroomsList">
                                {bedroom_list}
                                {/* <button onClick={() => this.openModal() }className="rj_add_bedroom_btn" id="js-add-bedrooms" style={{border:'#d2950c'}}>Add a bedroom</button> */}
                                <button type="button" className="rj_add_bedroom_btn" id="js-add-bedrooms" style={{border:'#d2950c'}} value="Open" onClick={() => this.openModal()} >Add a bedroom</button>
                               
                            </div>
                        </div>
                        </div>
                        <div className="js-section list_hover col-sm-12 bathbedrj" ng-init="bedrooms='';beds='';bathrooms='';bed_type='';">
                        
                        <div className="base_decs">
                            <h4>Bathroom (Optional)</h4>
                        </div>
                        <div className="base_text">
                            <div className="rj_list_property" id="alloverbedroomsList">
                            {bathroom_list}
                                <button to="add_bathroom" className="popup-trigger rj_add_bedroom_btn" id="js-add-bathrooms" style={{border: '#d2950c'}} onClick={this.openBathModal.bind(this)}>Add a bathroom</button>

                            </div>
                            <BathModal
                             open={this.state.visible_bathmodal} onClose={() => this.closeBathModal()} center styles={{ modal:{padding:'0px'} }}>
                           
                              <div id="js-bedroom-bathroom-container" className="enter_address"><div className="panel rjbedbathpanel ng-scope">
                                <div className="panel-header">
                                    <a data-behavior="modal-close" className="modal-close" href="javascript:;" />
                                    <div className="h4 js-address-nav-heading">Add Bathroom</div>
                                </div>
                                <form  acceptCharset="UTF-8" id="editbathroomsForm" name="editbathroomsForm" onSubmit={this.handleBathroomSubmit}>
                                 
                                <div className="panel-body">
                                    <div className="col-6">
                                        <label>Bathroom Name</label>
                                        <input type="text" onChange={this.HandleBathroomInputDetails} value={this.state.post_data.bathroom_data.bathroom_name} name="bathroom_name"  className="form-control rjcontrol" placeholder="Bathroom Name" required />
                                        <span className="has-error">
                                        <span style={{opacity: 0}} className="help-block help-block-error">
                                            This field is required!
                                        </span>
                                        </span> 
                                  
                                    </div>
                                    <div className="col-6" ng-init="bathroom_type=''">
                                        <label>Bathroom Type</label>
                                        <select name="bathroom_type"onChange={this.HandleBathroomInputDetails} value={this.state.post_data.bathroom_data.bathroom_type}  className="form-control rjcontrol" required>
                                        <option value>Select bathroom type</option>
                                        <option value="Full">Full</option>
                                        <option value="Half">Half</option>
                                        <option value="Shower">Shower</option>
                                        </select>
                                        <span className="has-error">
                                        <span style={{opacity: 0}} className="help-block help-block-error">
                                            This field is required!
                                        </span>
                                        </span> 
                                    </div>
                                    <h3 className="bathfeaturerj">Bathroom Feature</h3>
                                    <div className="col-6">
                                        <div className="rjlabelroom">
                                        <label className="rj_container">Toilet							  
                                            <input type="checkbox" className="checkbox_check" name="bathfeature" defaultChecked={this.state.post_data.bathroom_data.bathfeature.indexOf("Toilet") != -1} id = "Toilet" value="Toilet" onChange={this.HandleBathroomInputDetails}/>
                                            <span className="checkmark" />
                                        </label>
                                        </div>
                                        <div className="rjlabelroom">
                                        <label className="rj_container">Tub							  
                                            <input type="checkbox" className="checkbox_check" name="bathfeature" defaultChecked={this.state.post_data.bathroom_data.bathfeature.indexOf("Tub") != -1} id = "Tub" value="Tub" onChange={this.HandleBathroomInputDetails} />
                                            <span className="checkmark" />
                                        </label>
                                        </div>
                                        <div className="rjlabelroom">
                                        <label className="rj_container">Bidet							  
                                            <input type="checkbox" className="checkbox_check" name="bathfeature" defaultChecked={this.state.post_data.bathroom_data.bathfeature.indexOf("Bidet") != -1} id = "Bidet" value="Bidet" onChange={this.HandleBathroomInputDetails}/>
                                            <span className="checkmark" />
                                        </label>
                                        </div>
                                    </div>
                                    <div className="col-6">
                                        <div className="rjlabelroom">
                                        <label className="rj_container">Jetted tub							  
                                            <input type="checkbox" className="checkbox_check" name="bathfeature" defaultChecked={this.state.post_data.bathroom_data.bathfeature.indexOf("Jetted tub") != -1} id = "Jetted tub" defaultValue="Jetted tub" onChange={this.HandleBathroomInputDetails}/>
                                            <span className="checkmark" />
                                        </label>
                                        </div>
                                        <div className="rjlabelroom">
                                        <label className="rj_container">Shower							  
                                            <input type="checkbox" className="checkbox_check" name="bathfeature" defaultChecked={this.state.post_data.bathroom_data.bathfeature.indexOf("Shower") != -1} id = "Shower" defaultValue="Shower" onChange={this.HandleBathroomInputDetails} />
                                            <span className="checkmark" />
                                        </label>
                                        </div>
                                        <div className="rjlabelroom">
                                        <label className="rj_container">Outdoor shower							  
                                            <input type="checkbox" className="checkbox_check" name="bathfeature" defaultChecked={this.state.post_data.bathroom_data.bathfeature.indexOf("Outdoor Shower") != -1} id = "Outdoor Shower" defaultValue="Outdoor Shower" onChange={this.HandleBathroomInputDetails} />
                                            <span className="checkmark" />
                                        </label>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-12">               
                                        <span className="has-error ng-hide" ng-show="none_checked">	                
                                        <span style={{opacity: 0}} className="help-block help-block-error">
                                            At least one of Bathroom Features musted be selected!.
                                        </span>
                                        </span>
                                    </div>
                                    <div className="col-12 col-md-12 has-error ng-hide" ng-show="bathroom_validation_failed">
                                        {/* ngRepeat: error in bathroom_validation_errors */}
                                    </div>
                                   
                                </div>
                                <div className="panel-footer">
                                    <div className="force-oneline">
                                    <button data-behavior="modal-close" className="btn js-secondary-btn">Cancel</button>
                                    <button id="bathroomsubmit" className="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                </form>
                                </div></div>
                                </BathModal>
                        </div>
                        </div>
                        <div id="address-flow-view" />
                        <div className="calendar_savebuttons">
                        
                        <a href={`/rooms/manage-listing/${this.props.match.params.roomId}/description`} className="right_save_continue">Next</a>
                        </div>
                        <hr />
                    </div>
                    </div>
                    <div className="col-md-4 col-sm-12 listing_desc location_desc">
                        <div className="manage_listing_left">
                            <img src="https://www.vacation.rentals/images/property-help.png" className="col-center" width={75} height={75} />
                            <div className="amenities_about">
                            <h4>Bedroom/Bathroom</h4>
                            <p>Tell your guests how many bedrooms and bathrooms your property has. If you have multiple beds in the same bedroom, you can state that as well. For sleeper sofas in the living room, simply name the bedroom "Living Room" and select the number of sleeper sofas you have. </p>
                            </div>
                        </div>
                    </div>
                </div>

        );
    }
}

const mapStateToProps = state =>({
    ...state
  })
  const mapDispatchToProps = dispatch =>({
    renderSidebarAction : () => dispatch(renderSidebarAction) ,
    renderStopSidebarAction : () => dispatch(renderStopSidebarAction) 
  })

  export default connect(mapStateToProps, mapDispatchToProps)(Basic)