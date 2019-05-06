import React from 'react';
import StarRatings from 'react-star-ratings';
import Axios from 'axios';
class RoomFeedback extends React.PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            reviews : []
        }
    }
    componentDidMount(){
        Axios.get(`/ajax/homes/review/${this.props.room_id}`)
        .then(Response =>{
            this.setState({
                reviews : Response.data.reviews
            })
        })
    }
    arrAvg(arr) {

        return arr.reduce((a, b) => a + b, 0) / arr.length
    }
    render() {
        return (
            <div className="row">
                <div className="col-lg-12 lang-chang-label col-sm-12">
                    <div className="row-space-4 row-space-top-4 summary-component">
                        <div className="room_admin row">
                            <div className="col-md-3  space-sm-4 text-center space-sm-2 lang-chang-label">
                                <div className="media-photo-badge">
                                    
                                        <img alt="User Profile Image" className="host-profile-image img-responsive rounded-circle"   src={this.props.user_details.user_profile_pic ? this.props.user_details.user_profile_pic : null} title="Stefanie"  />
                                    
                                    <a href="javascript:void(0);" className="link-reset text-wrap">{this.props.user_details.full_name ? this.props.user_details.full_name : ''}</a>
                                </div>
                            </div>
                            <div className="col-md-9 ">
                                <h1 itemProp="name" className="overflow h3 row-space-1 text-center-sm" id="listing_name">
                                    {this.props.room_name}
                                </h1>
                                <div id="display-address" className="row-space-2 text-muted text-center-sm" itemProp="aggregateRating" itemScope>
                                    <a href="javascript:void(0);" className="link-reset">
                                        <span className="lang-chang-label"> {this.props.address != null ? (this.props.address.city ? this.props.address.city + ',' : '') : ''} </span>
                                        <span className="lang-chang-label"> {this.props.address != null ? (this.props.address.state ? this.props.address.state + ',' : '') : ''} </span>
                                        <span className="lang-chang-label">{this.props.address != null ? (this.props.address.country_name ? this.props.address.country_name + ',' : '') : ''}</span></a>
                                    &nbsp;
                                <a href="#reviews" className="link-reset hide-sm">
                                        <div className="star-rating-wrapper">
                                            <div className="star-rating">
                                                {
                                                    this.state.reviews.length ?
                                                        <StarRatings
                                                            rating={this.arrAvg(this.state.reviews.map((review) => {
                                                                return review.rating
                                                            }))}
                                                            starRatedColor="blue"
                                                            numberOfStars={5}
                                                            starDimension='30px'
                                                            name='rating'
                                                        />

                                                        : <StarRatings
                                                            rating={0}
                                                            starRatedColor="blue"
                                                            numberOfStars={5}
                                                            starDimension='30px'
                                                            name='rating'
                                                        />
                                                }
                                            </div>
                                            <span> </span>
                                            <span>
                                                <small>
                                                    <span>(</span>
                                                    <span> {this.state.reviews.length}</span>
                                                    <span>)</span>
                                                </small>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                </div>
            </div>
        );
    }
}

export default RoomFeedback;