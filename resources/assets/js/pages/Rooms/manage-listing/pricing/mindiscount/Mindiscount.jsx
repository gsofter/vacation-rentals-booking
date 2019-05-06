import React from 'react';
import EditFormModal from 'react-responsive-modal';
import axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
class Mindiscount extends React.Component {
    constructor(props){
        super(props)
        this.state = {
            visible_modal : false,
            last_min_rules : [],
            temp_data : {
                period : 0,
                discount : 0
             },
            post_data : []
        }
        this.openEditModal = this.openEditModal.bind(this)
        this.closeEditModal = this.closeEditModal.bind(this)
        this.handleAddData = this.handleAddData.bind(this)
        this.handleChangeTempData = this.handleChangeTempData.bind(this)
        this.handleChangeLastmin = this.handleChangeLastmin.bind(this)
    }
    componentDidMount(){
        axios.post(`/ajax/rooms/manage-listing/get_last_min_rules`, {id : this.props.roomId})
        .then( res => {
           if(res.data){
            this.setState({
                last_min_rules : res.data
            })
           } 
        })

   }
    closeEditModal(){
        this.setState({
            visible_modal : false
        })
    }
    openEditModal(){
        this.setState({
            visible_modal : true
        })
    }
    handleChangeLastmin(event, id){
        let name =event.target.name
        let value = event.target.value
        let last_min_rules = this.state.last_min_rules
        let rule_index = last_min_rules.findIndex((rule) =>
        {
            return rule.id == id
        })
        last_min_rules[rule_index][name] = value
        this.setState({
            last_min_rules : last_min_rules
        })
        axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/update_price_rules/last_min`, { data : last_min_rules[rule_index]})
        .then( res => {
            if(res.data.success == 'true'){
                toast.success('Success', {
                    position: toast.POSITION.TOP_RIGHT
                })
            }
            else{
                toast.error('Faild', {
                    position: toast.POSITION.TOP_RIGHT
                  });
            }
            
        })
    }
    handleAddData(){
        let {temp_data, last_min_rules} = this.state
        // price_type price_type
       
        axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/update_price_rules/last_min`, { data : this.state.temp_data})
        .then( res => {
            if(res.data.success == 'true'){
                toast.success('Success', {
                    position: toast.POSITION.TOP_RIGHT
                })
                temp_data.id=res.data.id
                last_min_rules.push(temp_data)
                temp_data = {
                    period : 0,
                    discount : 0
                }
                this.setState({
                    visible_modal : false,
                    temp_data : temp_data,
                    last_min_rules : last_min_rules
                })
            }
            else{
                toast.error('Faild', {
                    position: toast.POSITION.TOP_RIGHT
                  });
            }
            this.setState({
                visible_modal : false
            })
        })
    }
    handleChangeTempData(e){
        let name = e.target.name
        let value = e.target.value
        let temp_data = this.state.temp_data
        temp_data[name] = value
        this.setState({
            temp_data : temp_data
        })
    }
    render(){
        let last_min_list = this.state.last_min_rules.map((rule) => {
            return  <div className="early_discount" key={rule.id}>
            <ToastContainer />
            <div className="base_decs">
              <h4>Discount applied to reservation dates within "X" amount of days from today's date.</h4>
            </div>
             
            <div className="col-5 col-md-2">
                <div className="input-group">
                    <input type="text" className="form-control" aria-label="Perioud" value={rule.period} onChange={(event) => this.handleChangeLastmin(event, rule.id)} name='period' />
                    <div className="input-group-append">
                    <span className="input-group-text">Days</span>
                    </div>
                </div>
            </div>
            <div className="col-5 col-md-2">
                <div className="input-group">
                    <input type="text" className="form-control" aria-label="Price" value={rule.discount} onChange={(event) => this.handleChangeLastmin(event, rule.id)} name='discount' />
                    <div className="input-group-append">
                    <span className="input-group-text">%</span>
                    
                    </div>
                </div>
            </div>
            <div className="col-2 col-md-1">
              <div className="delete_list">
                <button href="javascript:void(0)" className="btn btn-xs" id="js-last_min-rm-btn-0" ng-click="remove_price_rule('last_min', $index)"> <span className="fa fa-trash"> </span> </button>
              </div>
            </div>
          </div>
        })
        return(
            <div className="add_early mb-3">
             <EditFormModal
                    open={this.state.visible_modal}
                    // width="600"
                    // effect="fadeInUp"
                    onClose={() => this.closeEditModal()}
                    styles={{ modal:{padding:'0px'} }}
                    >
                    <div className="panel rjbedbathpanel" id="add_language_des">
                         <div className="panel-header">
                         <a data-behavior="modal-close" className="modal-close" href="javascript:;" />
                            <div className="h4 js-address-nav-heading">
                                { this.state.is_edit ? 'Edit Last min discount' : 'Add Last min discount'}
                            </div>
                         </div>
                         <div className="panel-body">

                            <div className="aditionalrj">
                                <div className="col-md-12 col-sm-12 col-xs-12">
                                <h5 className="text-center">Discount applied to reservation dates within "X" amount of days from today's date.
                                </h5>
                              </div>
                              <div className="col-md-12 col-sm-12 col-xs-12">
                              <div className="col-6 col-md-6">
                                    <div className="input-group">
                                        <input type="text" className="form-control" aria-label="Perioud" value={this.state.post_data.period} onChange={this.handleChangeTempData} name='period' />
                                        <div className="input-group-append">
                                        <span className="input-group-text">Days</span>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-6 col-md-6">
                                    <div className="input-group">
                                        <input type="text" className="form-control" aria-label="Price" value={this.state.post_data.discount} onChange={this.handleChangeTempData} name='discount' />
                                        <div className="input-group-append">
                                        <span className="input-group-text">%</span>
                                        
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div className='panel-footer'>
                        <div className="force-oneline">
                                <button className="btn js-secondary-btn">Cancel</button>
                                <button id="bedroom_submit" type="submit" className="btn btn-primary" onClick={this.handleAddData}>Save</button>
                            </div>
                        </div>
                    </div>

                    </EditFormModal>
            <div className="row">
            <div style={{display: 'none'}} className="js-saving-progress saving-progress price_rules-last_min-saving">
                <h5>Saving... </h5>
            </div>
            <div>
            {last_min_list}
                <div className="add_early_bird">
                    <a href="javascript:void(0)" className="btn btn-success" onClick={this.openEditModal}> + Add Last min discounts </a>
                </div>
            </div>
            </div>
        </div>
        )
    }
}

export default Mindiscount;
