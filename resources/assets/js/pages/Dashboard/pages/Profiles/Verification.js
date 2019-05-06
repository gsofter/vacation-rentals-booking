import React from 'react'
import Axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
class Verification extends React.Component{
  constructor(props){
    super(props)
    this.state = {
      user_info : {},
      verification : {},
      phone_numbers : []
    }
    this.handleChangeVerifyCode = this.handleChangeVerifyCode.bind(this)
    this.handleProcessVerify = this.handleProcessVerify.bind(this)
    this.SendEmailVerifyLink = this.SendEmailVerifyLink.bind(this)
  }
  componentDidMount(){
    fetch('/ajax/dashboard/getverifycation')
      .then(response => response.json())
      .then(data => {
        console.log(data)
        this.setState({
          user_info : data.user_info,
          verification : data.verifycation,
          phone_numbers : data.phone_numbers
        })
      });
  }
  handleSendVerifyCode(e, index){
      e.preventDefault()
      Axios.post('/ajax/sendVerifyCode', { phone_number_id : this.state.phone_numbers[index].id})
      
  }
  SendEmailVerifyLink(){

  }
  handleChangeVerifyCode(e, index){
    let value = e.target.value
    let phone_numbers = this.state.phone_numbers
    phone_numbers[index].verification_code = value
    this.setState({
      phone_numbers : phone_numbers
    })
  }
  handleProcessVerify(e, index){
    e.preventDefault()
    Axios.post('/ajax/verifyPhoneNumber', { phone_number_id : this.state.phone_numbers[index].id, code : this.state.phone_numbers[index].verification_code})
    .then(response =>{
      if(response.data.status == 'success'){
        toast.success(response.data.message)
      }
      else{
        toast.error(response.data.message)
      }
      this.setState({
        phone_numbers : response.data.phone_numbers
      })
    })
  }
    render(){
        return(
            <div className="col-md-9">
 <ToastContainer />
        <div id="dashboard-content">
          <div className="panel verified-container">
            <div className="panel-header">
              Your Current Verifications
            </div>
            <div className="panel-body">
              <ul className="list-layout edit-verifications-list">
                <li className="edit-verifications-list-item clearfix email verified">
                  <h4>Email Address</h4>
                  {
                    this.state.verification.email == 'yes' ?  <p className="description">You have confirmed your email: <b>sales@vacarent.com</b>.  A confirmed email is important to allow us to securely communicate with you.
                    </p> : 
                    <div className='form-group  ml-auto mt-1' >
                             <div className="alert   alert-dismissible  show" role="alert">
                  <strong>Note!</strong>Your Email does not verified!
                  Please click <a onClick={this.SendEmailVerifyLink} className='font-weight-bold' style={{ cursor : 'pointer' }}><code>Here</code></a> to send verify link.
                  
                </div>  
                           
                    </div>
                  }
                 </li>
                <li className="edit-verifications-list-item clearfix email verified">
                  <h4>Phone Number</h4>
                  {this.state.phone_numbers.length == 0 ?
                  <div className="alert   alert-dismissible  show" role="alert">
                  <strong>Note!</strong> Please save your phone numbers in profile page. It is important for community of vacation.rentals.
                  <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                : null}
                  
                  
                  </li>
                  {
                      this.state.phone_numbers.map((phone_number, index) =>{
                        return  <div className=' ' key={index}>
                        <p></p>
                        {
                          phone_number.status != 'Confirmed' ? 
                          <form  className="form-inline">
                            <label className="mr-sm-2 mb-0">Phone Number</label>
                            <label className="mr-sm-2 mb-0">
                              <strong>{phone_number.phone_number_protected.replace(/ /g,'')}</strong> : 
                            </label>
                            
                            {/* <label className="mr-sm-2 mb-0" htmlFor="last_name">Last Name</label> */}
                            <input type="text" className="form-control mr-sm-2 mb-2 mb-sm-0" onChange={(event) => this.handleChangeVerifyCode(event, index)} id="last_name" name="last_name" placeholder='Verify Code' />
                            <div className='form-group  ml-auto mt-1'>
                            <button type="button" className="btn btn-primary mt-2 mt-sm-0" onClick={(event)=>this.handleSendVerifyCode(event, index)}>Send Code</button>
                            <button type="button" className="btn btn-primary mt-2 mt-sm-0" onClick={(event)=>this.handleProcessVerify(event, index)}>Verify</button>
                            </div>
                          </form>
                          : 
                          <p className="description">You have confirmed your phone number: <b>{phone_number.phone_number_protected.replace(/ /g,'')}</b>.
                  </p>
                        }
                      </div>
                      })
                    }
              </ul>
            </div>
          </div>
        </div>
      </div>
        )
    }
}

export default Verification