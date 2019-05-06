import React from 'react'
import axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
class Login extends React.PureComponent {

  constructor(props){
    super(props)
    this.state = {
      user_email : '',
      user_pass : ''
    }
    this.handleChange = this.handleChange.bind(this)
    this.onLoginSubmit = this.onLoginSubmit.bind(this)
    }
    handleChange(e){
      e.preventDefault();
      let target = e.target;
      let name = target.name;
      let value = target.value;
      this.setState({
        [name] : value
      })
    }
    onLoginSubmit(e){
      e.preventDefault();
      // console.log(this.state)
      let {user_email, user_pass} = this.state
      // this.props.onLogin(user_email, user_pass)
      const credential = {
        email: user_email,
        password: user_pass
      }
      console.log('------------Login--------------')
      axios.post('/ajax/login', credential)
          .then(response => {
            console.log(response, 'After login')
              if (response.data.success == true) {
                 
                  toast.success("Login Success", {
                      position: toast.POSITION.TOP_CENTER
                  });
                  // this.setState({
                  //     isLogedIn: 'true',
                  //     userName: response.data.userinfo.first_name
                  // })
                  location.href='/'
              }
              else {
                  toast.error("Login Failed", {
                      position: toast.POSITION.TOP_RIGHT
                  });
              }

          })
          .catch(error => {
              console.log(error)
          })
    }
  render() {
    return (


      <main id="site-content" role="main">
        <div className="page-container-responsive page-container-auth margintop" style={{ marginTop: 40, marginBottom: 40 }}>
          <div className="row">
            <div className="log_pop col-center">
            <div className="panel top-home">
        <div className="panel-body bor-none  ">
          <a href="/login/facebook" className="btn icon-btn btn-block btn-large row-space-1 btn-facebook font-normal pad-top mr1">
            <span><i className="icon icon-facebook" /></span>
            <span>Log in with Facebook</span>
          </a>  
          <a href="/login/google" className="btn btn-danger icon-btn btn-block btn-large row-space-1 btn-google font-normal pad-top mr1">
            <span><i className="icon icon-google-plus" /></span>
            <span>Log in with Google</span>
          </a>
          {/* <a href="/login/linkedin" className="li-button li-blue btn icon-btn btn-block btn-large row-space-1 btn-linkedin mr1">
            <span><i className="icon icon-linkedin" /></span>
            <span>Log in with LinkedIn</span>
          </a>  */}
          <div className="signup-or-separator">
            <span className="h6 signup-or-separator--text">or</span>  <hr />
          </div>
          <div className="clearfix" />
          <form method="POST" onSubmit={this.onLoginSubmit} acceptCharset="UTF-8" className="vr_form signup-form login-form ng-pristine ng-valid" id="login_form_modal" data-action="Signin" noValidate="novalidate">
            <input name="_token" id="token_modal" type="hidden" className="tooltipstered" />
            <input id="login_from_modal" name="from" type="hidden" defaultValue="email_login" className="tooltipstered" />
            <div className="control-group row-space-2 field_ico">
              <div className="pos_rel">
                <i className="icon-envelope" />
                <input className="decorative-input inspectletIgnore name-icon signin_email tooltipstered" placeholder="Email address" id="signin_email_modal" name="user_email" onChange={this.handleChange} type="email"  />
              </div>
            </div>
            <div className="control-group row-space-3 field_ico">
              <div className="pos_rel">
                <i className="icon-lock" />
                <input className="decorative-input inspectletIgnore name-icon signin_password tooltipstered" placeholder="Password" id="signin_password_modal" data-hook="signin_password" name="user_pass" onChange={this.handleChange} type="password"  />
              </div>
            </div>
            <div className="clearfix row-space-3">
              <label htmlFor="remember_me2" className="checkbox remember-me">
                <input id="remember_me2_modal" className="remember_me" name="remember_me" type="checkbox" defaultValue={1} /> Remember me
              </label>
              <a href="javascript:void(0);" className="forgot-password forgot-password-popup link_color pull-right h5">Forgot password?</a>
            </div>
            <input className="btn btn-primary btn-block btn-large pad-top btn_new user-login-btn tooltipstered" id="user-login-btn_modal" type="submit" defaultValue="Log In" />
          </form>
        </div>
      </div></div>
          </div>
        </div>
      </main>
   
     
        )

  }
}

export default Login