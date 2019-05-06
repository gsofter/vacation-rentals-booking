import React from 'react'
import {CardElement, injectStripe} from 'react-stripe-elements';
import  { Redirect } from 'react-router-dom'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { ClipLoader } from 'react-spinners';
import { css } from 'react-emotion';
import './stripeform.css'
import axios from 'axios'
class StripeForm extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {complete: false, username : '', is_processing : false, subscribe_success:false};
        this.submit = this.submit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }
    handleChange(e){
        let name = e.target.name
        let value = e.target.value
        this.setState({
            [name] : value
        })
    }
    async submit(ev) {
        ev.preventDefault();
        let {token} = await this.props.stripe.createToken({name: "Name"});
        let formData = new FormData();
        formData.append('stripe_token', token.id);
        formData.append('username', this.state.username);
        formData.append('planId', this.props.planId);
        let response = await fetch("/ajax/membership/stripe", {
          method: "POST",
          body: formData,
        });
        if (response.ok ){
            toast.success('Success')
             this.setState({
                subscribe_success : true
             })
        }
      }
    render(){
        const override = css`
                        display: block;
                        margin: 0 auto;
                        border-color: red;
                    `;
        if(this.state.subscribe_success){
            return <Redirect to='/pricing'  />
        }
        
        if(this.state.is_processing){
            return <div className='sweet-loading'>
            <ClipLoader
              className={override}
              sizeUnit={"px"}
              size={150}
              color={'#123abc'}
              loading={this.state.loading}
            />
          </div> 
        }
        else{
            return <form role="form" onSubmit={this.submit}>
        <ToastContainer/>

        {/* <div className="form-group">
          <label htmlFor="username">Full Name(on the card)</label>
          <input type="text" className="form-control" name="username" required value={this.state.username} onChange={this.handleChange} />
        </div>   */}
        <CardElement />
         
        <button className="subscribe btn btn-primary btn-block mt-5" type="submit"> Confirm</button>
      </form>
        }
        
    }
}
export default injectStripe(StripeForm)