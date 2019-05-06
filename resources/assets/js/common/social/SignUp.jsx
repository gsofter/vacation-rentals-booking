import React from 'react'
import SignUpForm from './SignUpForm';
const metas = document.getElementsByTagName('meta');
export default class SignUp extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            'first_name' :  metas['newUser_first_name'] ? metas['newUser_first_name'].content : '',
            'last_name' : metas['newUser_last_name'] ?  metas['newUser_last_name'].content : '',
            'email' :  metas['newUser_email'] ? metas['newUser_email'].content : '',
            'linkedin_id' :  metas['newUser_linkedin_id'] ? metas['newUser_linkedin_id'].content : '',
            'google_id' :  metas['newUser_google_id'] ? metas['newUser_google_id'].content : '',
            'fb_id' :  metas['newUser_fb_id'] ? metas['newUser_fb_id'].content : '',
            'avatar_original' :  metas['newUser_avatar_original'] ? metas['newUser_avatar_original'].content : '',
            'avatar' :  metas['newUser_avatar'] ? metas['newUser_avatar'].content : ''
        }
    }
    render(){
        if(this.state.first_name && this.state.last_name && this.state.email){
            return <div className='container'>
            <SignUpForm userData = {this.state}/>
            </div>
        }
        else{
            document.location.href = '/login'
        }
        
    }
}