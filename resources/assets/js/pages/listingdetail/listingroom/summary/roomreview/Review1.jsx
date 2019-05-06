import React from 'react'
import StarRating from './StarRating'
import { RadioGroup, RadioButton } from 'react-radio-buttons'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import axios from 'axios'
const metas = document.getElementsByTagName('meta');
class Review1 extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            accuracy : 0,
            cleanliness : 0,
            checkin : 0,
            communication : 0,
            amenities : 0,
            location : 0,
            value : 0,
            rating : 0,
            recommend : 0,
            comments : '',
            isLogedIn : metas['isLogedin'].content,
            is_agree : false
        }
        this.handleRating = this.handleRating.bind(this)
        this.handleChangeRecommend = this.handleChangeRecommend.bind(this)
        this.handleSubmitReview = this.handleSubmitReview.bind(this)
        this.handleAgree = this.handleAgree.bind(this)
        this.handleChange = this.handleChange.bind(this)
    }
    handleAgree(e){        
      
        let value = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
        this.setState({
            is_agree : value
        })
    }
    handleChange(e){
        let name = e.target.name
        let value = e.target.value
        this.setState({
            [name] : value
        })
    }
    handleSubmitReview(){
        console.log('---------Submit---------')
        console.log('State Variable', this.state)
        if(this.state.isLogedIn != 'false'){
            let login_user_id = metas['LogedUserId'].content
            if(this.state.is_agree){
                if(this.state.comments =='' || this.state.accuracy == 0 || this.state.amenities == 0 || this.state.cleanliness == 0 || this.state.checkin == 0 || this.state.communication == 0 || this.state.location == 0 ||this.state.value == 0 || this.state.rating == 0){
                    toast.warn('You did not rate all items!');
                }
                else{
                    // alert('Submitting-----')
                    axios.post('/ajax/users/reviews', {
                        'accuracy'   : this.state.accuracy,
                        'amenities'   : this.state.amenities,
                        'checkin'   : this.state.checkin,
                        'cleanliness'   : this.state.cleanliness,
                        'comments'   : this.state.comments,
                        'communication'   : this.state.communication,
                        'location'   : this.state.location,
                        'rating'   : this.state.rating,
                        'recommend'   : this.state.recommend,
                        'respect_house_rules'   : this.state.amenities,
                        'room_id'   : this.props.room_detail.id,
                        'user_from'   : login_user_id,
                        'user_to'   : this.props.user_details.id,
                        'value'   : this.state.value,
                    }).then(result => {
                        console.log(result)
                        if(result.data.status == 'success'){
                            toast.success(result.data.message)
                        }
                    })
                }
            }
            else{
                toast.warn('Please agree terms of services!')
            }
        }
        else{
            alert('Please Login First to submit review!');
        }
    }
    handleChangeRecommend(recommend){
        console.log(recommend)
        this.setState({
            recommend : recommend
        })
    }
    handleRating(name, value){
        console.log(name, value)
        this.setState({
            [name] : value
        })
    }
    render(){
        let user_first_name = ''
        let user_last_name = ''
        let user_email = ''
        if(this.state.isLogedIn != 'false'){
            user_first_name = metas['userFirstName'].content
            user_last_name = metas['userLastName'].content
            user_email = metas['userEmail'].content
        }
        return <div>
            <ToastContainer/>
            <h3 className="main_question wizard-header">{this.props.step == 1 || this.props.step == 2 ? 'Rate & Review' : ''} { this.props.step == 3 ? 'Describe Your Experience' : ''} {this.props.step == 4 ? 'Your Details' : ''}</h3>
                <div className="row">
                    {
                    this.props.step == 1 ?  <div className="col-md-12">
                        <StarRating starCount = {5}  labelName="Accuracy" name="accuracy" onChange={(value) => this.handleRating('accuracy', value)} rating={this.state.accuracy} description="How accurately did the photos &amp; description represent the actual space?"/>    
                        <StarRating starCount = {5}  labelName="Cleanliness" name="cleanliness" onChange={(value) => this.handleRating('cleanliness', value)} rating={this.state.cleanliness} description="Was the space as clean as you expect a listing to be?"/>    
                        <StarRating starCount = {5}  labelName="Arrival" name="checkin" onChange={(value) => this.handleRating('checkin', value)} rating={this.state.checkin} description="Did the host do everything within their control to provide you with a smooth arrival process?"/>    
                        <StarRating starCount = {5}  labelName="Amenities" name="amenities" onChange={(value) => this.handleRating('amenities', value)} rating={this.state.amenities} description="Did your host provide everything they promised in their listing description?"/>    
                    </div>
                    : null
                    }
                    {
                    this.props.step == 2 ?  <div className="col-md-12">
                        <StarRating starCount = {5}  labelName="Communication" name="communication" onChange={(value) => this.handleRating('communication', value)} rating={this.state.communication} description="How accurately did the photos &amp; description represent the actual space?"/>    
                        <StarRating starCount = {5}  labelName="Location" name="location" onChange={(value) => this.handleRating('location', value)} rating={this.state.location} description="Was the space as clean as you expect a listing to be?"/>    
                        <StarRating starCount = {5}  labelName="Value" name="value" onChange={(value) => this.handleRating('value', value)} rating={this.state.value} description="Did the host do everything within their control to provide you with a smooth arrival process?"/>    
                        <StarRating starCount = {5}  labelName="Overall Experience" name="rating" onChange={(value) => this.handleRating('rating', value)} rating={this.state.rating} description="Did your host provide everything they promised in their listing description?"/>    
                    </div>
                    : null
                    }
                    {
                        this.props.step == 3 ? <div className="col-md-12">
                            <p className="text-muted fs-small">Your review will be public on your profile and your host’s listing page. If you have additional feedback that you don’t want to make public, you can share it with :site_name on the next page.</p>
                            <div className="form-group">
							    <textarea name="comments" className="form-control required" onChange={this.handleChange} style={{height:"140px"}} placeholder="Write your review here!" value={this.state.comments}></textarea>

						    </div>
                            <div className="h3 row-space-1">
                                Would you recommend staying here?
                            </div>
                            <p className="text-muted fs-small">
                                Your answer will not be posted on your profile or your host’s listing.
                            </p>
                            <div className="form-group">
                            <RadioGroup onChange={ this.handleChangeRecommend } horizontal>
                                <RadioButton value="0">
                                    No
                                </RadioButton>
                                <RadioButton value="1">
                                    Yes
                                </RadioButton>
                              
                            </RadioGroup>
                            </div>
                        </div> : null
                    }
                    {
                        this.props.step == 4 ? <div className="col-md-12">
                        <p className="gray">The following information was loaded from your user profile.  If you'd like to update this info, please <a href="#">edit your profile</a>.</p>
                        {
                            this.state.isLogedIn != 'false' ? <div className="row"><div className="col-md-6">
                            <div className="form-group">
                                <input type="text" name="first_name" className="form-control required" placeholder="First name" value={user_first_name} readOnly={true}/>
                            </div>
                            </div>
                            <div className="col-md-6">
                            <div className="form-group">
                                <input type="text" name="last_name" className="form-control required" placeholder="Last name" value={user_last_name} readOnly={true}/>
                                </div>
                            </div>
                            <div className="col-md-12">
                            <div className="form-group">
                                <input type="email" name="email" className="form-control required" placeholder="Your Email" value={user_email} readOnly={true}/>
                                </div>
                            </div>
                            <div className="col-md-12">
                            <div className="form-group terms">
                                <div className="icheckbox_square-blue " >
                                <input name="terms" type="checkbox" checked={this.state.is_agree} className=" required" onChange={this.handleAgree} />
                                </div>
                                <span>Please accept <a href="#">terms and conditions</a> ?</span>
                            </div>
                        </div>
                        </div> : <div className="col-md-12">You must login to subit your review!</div>
                        }
                        <div className="col-md-12">
                            <button className="btn btn-primary" onClick={this.handleSubmitReview}>{this.state.isLogedIn != 'false' ? 'Submit' : 'Login'}</button>
                        </div>

                        </div>
                        :
                        null
                    }

                </div>
                
            </div>
    }
}

export default Review1