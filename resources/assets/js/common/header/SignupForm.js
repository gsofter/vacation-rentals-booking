import React from 'react'
import SignupwithEmail from './SignupwithEmail'
import SignupSocialModal from './SignupSocialModal'
class SignupForm extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
          is_email_form : false,
          is_signup_success : false
        }
        this.changeFormHandler = this.changeFormHandler.bind(this)
        this.onSignupSuccess = this.onSignupSuccess.bind(this)
    } 
    changeFormHandler(){
      console.log('Hello')
      this.setState({
        is_email_form : !this.state.is_email_form
      })
    }
    componentDidMount(){
      this.onSignupSuccess()
    }
    onSignupSuccess(){
      this.setState({
        is_signup_success : true
      })
    }
    render(){
      
        if(this.props.visible == true){
          if(this.state.is_email_form == true){
            return (
                <SignupwithEmail  onChangeForm={this.changeFormHandler}  onSuccess={this.props.onSignupSuccess}/>
            )
          }
          else{
            return(
              <SignupSocialModal onChangeForm={this.changeFormHandler}/>
            )
                
          }
        }  
        else{
           return(
            <div></div>
        )
        }
       
    }
}

export default SignupForm