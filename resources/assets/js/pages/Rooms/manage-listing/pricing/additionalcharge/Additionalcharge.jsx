import React from 'react';
import axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import EditFormModal from 'react-responsive-modal';
import './additionalcharge.css'
class Additionalcharge extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            visible_modal: false,
            is_edit: false,
            additional_data: [],
            temp_data: {
                calc_type: "0",
                guest_opt: "0",
                label: "",
                price: "",
                price_type: "0",
            }
        }
        this.openEditModal = this.openEditModal.bind(this)
        this.closeEditModal = this.closeEditModal.bind(this)
        this.handleChangeTemp = this.handleChangeTemp.bind(this)
        this.handleAddData = this.handleAddData.bind(this)
        this.handleChangeAdditionalData = this.handleChangeAdditionalData.bind(this)
        this.handleRemoveAdditional = this.handleRemoveAdditional.bind(this)
    }

    componentDidMount() {
        axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/get_additional_charges`)
            .then(res => {
                if (res.data) {
                    this.setState({
                        additional_data: res.data
                    })
                }
            })

    }
    closeEditModal() {
        this.setState({
            visible_modal: false
        })
    }
    openEditModal() {
        this.setState({
            visible_modal: true
        })
    }
    handleChangeTemp(e) {
        let name = e.target.name
        let value = e.target.value
        let temp_data = this.state.temp_data
        temp_data[name] = value
        this.setState({
            temp_data: temp_data
        })
    }
    handleAddData() {
        let { temp_data, additional_data } = this.state
        // price_type price_type
        additional_data.push(temp_data)
        temp_data = {
            calc_type: "0",
            guest_opt: "0",
            label: "",
            price: "",
            price_type: "0",
        }
        this.setState({
            temp_data: temp_data,
            additional_data: additional_data
        })
        axios.post(`/ajax/rooms/manage-listing/update_additional_price`, { additional_charges: this.state.additional_data, id: this.props.roomId })
            .then(res => {
                if (res.data.success == 'true') {
                    toast.success('Success', {
                        position: toast.POSITION.TOP_RIGHT
                    })

                }
                else {
                    toast.error('Faild', {
                        position: toast.POSITION.TOP_RIGHT
                    });
                }
                this.setState({
                    visible_modal: false
                })
            })
    }
    handleChangeAdditionalData(e, index) {
        // console.log(e, index)
        let name = e.target.name
        let value = e.target.value
        let additional_data = this.state.additional_data
        additional_data[index][name] = value
        this.setState({
            additional_data: additional_data
        })
        axios.post(`/ajax/rooms/manage-listing/update_additional_price`, { additional_charges: this.state.additional_data, id: this.props.roomId })
            .then(res => {
                if (res.data.success == 'true') {
                    toast.success('Success', {
                        position: toast.POSITION.TOP_RIGHT
                    })

                }
                else {
                    toast.error('Faild', {
                        position: toast.POSITION.TOP_RIGHT
                    });
                }
                this.setState({
                    visible_modal: false
                })
            })
    }
    handleRemoveAdditional(e, index) {
        console.log(e, index)
        e.preventDefault()
        let name = e.target.name
        let value = e.target.value
        let additional_data = this.state.additional_data
        additional_data = additional_data.splice(index, 1)

        this.setState({
            additional_data: additional_data
        })
        axios.post(`/ajax/rooms/manage-listing/update_additional_price`, { additional_charges: this.state.additional_data, id: this.props.roomId })
            .then(res => {
                if (res.data.success == 'true') {
                    toast.success('Success', {
                        position: toast.POSITION.TOP_RIGHT
                    })

                }
                else {
                    toast.error('Faild', {
                        position: toast.POSITION.TOP_RIGHT
                    });
                }
                this.setState({
                    visible_modal: false
                })
            })
    }
    render() {
        console.log('Additional Charge COmponent', this.state)

        let additional_charges_list = this.state.additional_data.map((additional, index) => {
            return <div className="additional_charge_row input-group mb-sm-4" key={additional.label}>
                <hr className="d-md-none" />
                <div className="aditionalrj">
                    <div className="col-md-3 col-sm-5 col-xs-8">
                        <label className="h6">Enter charges name <i rel="tooltip" className="icon icon-question" title="The name of the charge as it will be displayed to your guests when making a reservation." /></label>
                        <div className="base_pric">
                            <input type="text" name="label" className="form-control" onChange={(event) => this.handleChangeAdditionalData(event, index)} value={additional.label} />
                        </div>
                    </div>
                    <div className="col-md-3 col-sm-5 col-xs-8">
                        <label className="h6">Enter charges amount <i rel="tooltip" className="icon icon-question" title="The amount of the additional charge.  You can set the amount to be applied as a flat dollar value or as a percentage of the subtotal before taxes." /></label>
                        <div className="base_pric">
                            <div className="input-group mb-3">
                                <div className="input-group-prepend">
                                    <span className="input-group-text">
                                        <select className=" bg-transparent border-0" name="price_type" onChange={(event) => this.handleChangeAdditionalData(event, index)} value={additional.price_type}>
                                            <option value={0} > % </option>
                                            <option value={1}>{this.props.code}</option>
                                        </select>
                                    </span>
                                </div>
                                <input type="number" className="form-control input-appended" name="price" min={0} onChange={(event) => this.handleChangeAdditionalData(event, index)} value={additional.price} />
                            </div>
                        </div>
                    </div>
                    <div className="col-md-3 col-sm-5 d-md-block d-none col-xs-8 extra-field">
                        <label className="h6">Fee calculation <i rel="tooltip" className="icon icon-question" title="Determines how the fee is calculated.  Single fee is applied one time to the total of the order, Per Night fee's are applied for each night of the stay & Per Guest fee's are applied once for each guest." /></label>
                        <div className="base_pric select">
                            <select className="form-control" name="calc_type" onChange={(event) => this.handleChangeAdditionalData(event, index)} value={additional.calc_type}>
                                <option value={0}> Single Fee </option>
                                <option value={1} > Per Night </option>
                                <option value={2}> Per Guest </option>
                            </select>
                        </div>
                    </div>
                    <div className="col-md-2 col-sm-5 d-md-block d-none col-xs-8 extra-field">
                        <label className="h6">Optional <i rel="tooltip" className="icon icon-question" title="Set to &quot;Yes&quot; if you'd like to allow guests the option to apply this fee.  Works best for things such as Pet fees or special usage fees" /></label>
                        <div className="base_pric select">
                            <select className="form-control" name="guest_opt" onChange={(event) => this.handleChangeAdditionalData(event, index)} value={additional.guest_opt}>
                                <option value={0} > Yes </option>
                                <option value={1}> No </option>
                            </select>
                        </div>
                    </div>
                    <button className="btn btn-danger remove-additional_charge" type="button" onClick={(event) => this.handleRemoveAdditional(event, index)}><i className="fa fa-trash-o" /></button>
                    <a className="view-more d-md-none" data-state="hiden"> + More </a>
                </div>
            </div>
        })
        console.log(this.state.temp_data)
        return (
            <div className="base_priceamt">
                <ToastContainer />
                <EditFormModal
                    open={this.state.visible_modal}
                   
                    onClose={() => this.closeEditModal() } styles={{ modal:{padding:'0px'} }}
                >
                    <div className="panel rjbedbathpanel" id="add_language_des">
                        <div className="panel-header">
                            <a data-behavior="modal-close" className="modal-close" href="javascript:;" />
                            <div className="h4 js-address-nav-heading">
                                {this.state.is_edit ? 'Edit Additional Charge' : 'Add Additional Charge'}
                            </div>
                        </div>
                        <div className="panel-body">

                            <div className="aditionalrj">
                                <div className='row'>
                                    <div className="col-md-12 col-sm-12 col-xs-12">
                                        <label className="h6">Enter charges name <i rel="tooltip" className="icon icon-question" title="The name of the charge as it will be displayed to your guests when making a reservation." /></label>
                                        <div className="base_pric">
                                            <input type="text" name="label" className="form-control" value={this.state.temp_data.label} onChange={this.handleChangeTemp} />
                                        </div>
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className="col-md-4 col-sm-12 col-xs-8">
                                        <label className="h6">Enter charges amount <i rel="tooltip" className="icon icon-question" title="The amount of the additional charge.  You can set the amount to be applied as a flat dollar value or as a percentage of the subtotal before taxes." /></label>
                                        <div className="base_pric">
                                            <div className="input-group mb-3">
                                                <div className="input-group-prepend">
                                                    <span className="input-group-text">
                                                        <select className=" bg-transparent border-0" name="price_type" value={this.state.temp_data.price_type} onChange={this.handleChangeTemp}>
                                                            <option value={0} > % </option>
                                                            <option value={1}>{this.props.code}</option>
                                                        </select>
                                                    </span>
                                                </div>
                                                <input type="number" className="form-control input-appended" name="price" min={0} value={this.state.temp_data.price} onChange={this.handleChangeTemp} />
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-md-4 col-sm-12    col-xs-12 ">
                                        <label className="h6">Fee calculation <i rel="tooltip" className="icon icon-question" title="Determines how the fee is calculated.  Single fee is applied one time to the total of the order, Per Night fee's are applied for each night of the stay & Per Guest fee's are applied once for each guest." /></label>
                                        <div className="base_pric select">
                                            <select className="form-control" name="calc_type" onChange={this.handleChangeTemp} value={this.state.temp_data.calc_type}>
                                                <option value={0}> Single Fee </option>
                                                <option value={1}> Per Night </option>
                                                <option value={2}> Per Guest </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-md-4 col-sm-12   col-xs-12 ">
                                        <label className="h6">Optional <i rel="tooltip" className="icon icon-question" title="Set to &quot;Yes&quot; if you'd like to allow guests the option to apply this fee.  Works best for things such as Pet fees or special usage fees" /></label>
                                        <div className="base_pric select">
                                            <select className="form-control" name="guest_opt" onChange={this.handleChangeTemp} value={this.state.temp_data.guest_opt}>
                                                <option value={0} > Yes </option>
                                                <option value={1}> No </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className='modal-footer'>
                                <div className="force-oneline">
                                    <button className="btn js-secondary-btn">Cancel</button>
                                    <button id="bedroom_submit" type="submit" className="btn btn-primary" onClick={this.handleAddData}>Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </EditFormModal>
                <div className="input-group control-group after-add-more-additional_charge">
                    <p data-error="additional_charge" className="ml-error hide">There is a empty charge name or charge fee.</p>
                    {additional_charges_list}
                </div>

                <div className="input-group-btn rjaddcharge">
                    <button id="save_additional_charge" className="btn btn-success add-more-additional_charge1" type="button" onClick={this.openEditModal}>+ Add additional charges</button>
                </div>
            </div>
        )
    }
}

export default Additionalcharge;    