import React from 'react'
import Modal from 'react-responsive-modal';
import StepZilla from "react-stepzilla"
import './wizard.css'
import Review1 from './Review1'
import Review from './Review'
import StarRatings from 'react-star-ratings';
class RoomReview extends React.PureComponent {
    constructor(props) {
        super(props)
        this.state = {
            is_open_modal: false,

        }
        this.onOpenModal = this.onOpenModal.bind(this)
        this.onCloseModal = this.onCloseModal.bind(this)
    }
    onOpenModal() {
        this.setState({ is_open_modal: true });
    }

    onCloseModal() {
        this.setState({ is_open_modal: false });
    }
    arrAvg(arr) {

        return arr.reduce((a, b) => a + b, 0) / arr.length
    }

    render() {
        const steps =
            [
                { name: '1/4', component: <Review1 user_details={this.props.user_details} room_detail={this.props.room_detail} step={1} /> },
                { name: '2/4', component: <Review1 user_details={this.props.user_details} room_detail={this.props.room_detail} step={2} /> },
                { name: '3/4', component: <Review1 user_details={this.props.user_details} room_detail={this.props.room_detail} step={3} /> },
                { name: '4/4', component: <Review1 user_details={this.props.user_details} room_detail={this.props.room_detail} step={4} /> },
            ]
        return <div className='mt-3   col-lg-12'>
            <div className="col-md-12 lang-chang-label p-0 ">
                <div className="panel row-space-top-3 review-content">
                    <div className="panel-body">
                        <div className="row d-lg-flex align-items-center mb-3">
                            <div className="col-12 col-md-8">
                                {
                                    this.props.reviews.length ?
                                        <h4 className="text-center-sm col-middle">
                                            {this.props.reviews.length} Reviews  <StarRatings
                                                rating={this.arrAvg(this.props.reviews.map((review) => {
                                                    return review.rating
                                                }))}
                                                starRatedColor="blue"
                                                numberOfStars={5}
                                                starDimension='30px'
                                                name='rating'
                                            />
                                        </h4>
                                        : <h4 className="text-center-sm">No Reviews Yet</h4>
                                }

                            </div>
                            <div className="col-12 col-md-4 align-items-center">
                                <button type="button" id="review-listing-btn" className="btn btn-block btn-primary btn-md" onClick={this.onOpenModal}>
                                    <span>
                                        <i className="glyphicon-bullhorn" />Leave a Review</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <hr />
                        </div>
                        {
                            this.props.reviews.length ? <div className="review-main">
                                <div className="review-inner space-top-2 space-2">
                                    <div className="row">
                                        <div className="col-lg-3 show-lg lang-chang-label">
                                            <div className="text-muted">
                                                <span>Type your property summary</span>
                                            </div>
                                        </div>
                                        <div className="col-lg-9">
                                            <div className="row">
                                                <div className="col-lg-6 lang-chang-label">
                                                    <div>
                                                        <div className="pull-right">
                                                            <StarRatings
                                                                rating={this.arrAvg(this.props.reviews.map((review) => {
                                                                    return review.accuracy
                                                                }))}
                                                                starRatedColor="blue"
                                                                numberOfStars={5}
                                                                starDimension='15px'
                                                                starSpacing="5px"
                                                                name='rating'
                                                            />
                                                        </div>
                                                        <strong className="col-md-6">Accuracy</strong>
                                                    </div>
                                                    <div>
                                                        <div className="pull-right">
                                                            <StarRatings
                                                                rating={this.arrAvg(this.props.reviews.map((review) => {
                                                                    return review.communication
                                                                }))}
                                                                starRatedColor="blue"
                                                                numberOfStars={5}
                                                                starDimension='15px'
                                                                starSpacing="5px"
                                                                name='rating'
                                                            />
                                                        </div>
                                                        <strong className="col-md-6">Communication</strong>
                                                    </div>
                                                    <div>
                                                        <div className="pull-right">
                                                            <StarRatings
                                                                rating={this.arrAvg(this.props.reviews.map((review) => {
                                                                    return review.cleanliness
                                                                }))}
                                                                starRatedColor="blue"
                                                                numberOfStars={5}
                                                                starDimension='15px'
                                                                starSpacing="5px"
                                                                name='rating'
                                                            />
                                                        </div>
                                                        <strong className="col-md-6">Cleanliness</strong>
                                                    </div>
                                                </div>
                                                <div className="col-lg-6 lang-chang-label">
                                                    <div>
                                                        <div className="pull-right">
                                                            <StarRatings
                                                                rating={this.arrAvg(this.props.reviews.map((review) => {
                                                                    return review.location
                                                                }))}
                                                                starRatedColor="blue"
                                                                numberOfStars={5}
                                                                starDimension='15px'
                                                                starSpacing="5px"
                                                                name='rating'
                                                            />
                                                        </div>
                                                        <strong className="col-md-6">Location</strong>
                                                    </div>
                                                    <div>
                                                        <div className="pull-right">
                                                            <StarRatings
                                                                rating={this.arrAvg(this.props.reviews.map((review) => {
                                                                    return review.checkin
                                                                }))}
                                                                starRatedColor="blue"
                                                                numberOfStars={5}
                                                                starDimension='15px'
                                                                starSpacing="5px"
                                                                name='rating'
                                                            />
                                                        </div>
                                                        <strong className="col-md-6">Check In</strong>
                                                    </div>
                                                    <div>
                                                        <div className="pull-right">
                                                            <StarRatings
                                                                rating={this.arrAvg(this.props.reviews.map((review) => {
                                                                    return review.value
                                                                }))}
                                                                starRatedColor="blue"
                                                                numberOfStars={5}
                                                                starDimension='15px'
                                                                starSpacing="5px"
                                                                name='rating'
                                                            />
                                                        </div>
                                                        <strong className="col-md-6">Value</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="review-content">
                                    <div className="panel-body">
                                        {this.props.reviews.map((review, index) => {
                                            return  <div key={index}>
                                            <div className="row review">
                                              <div className="col-md-3 col-sm-12 text-center space-2 lang-chang-label">
                                                <div className="media-photo-badge">
                                                  <a className="media-photo media-round" href="#">
                                                    <img width={67} height={67} title="Michael" src={review.user_avatar} data-pin-nopin="true" alt="shared.user_profile_image" />
                                                  </a>
                                                </div>
                                                <div className="name">
                                                  <a target="_blank" className="text-muted link-reset" href="#">
                                                  {review.user_full_name}
                                                  </a>
                                                </div>
                                              </div>
                                              <div className="col-md-9 col-sm-12">
                                                <div className="space-2">
                                                  <div className="review-text" data-review-id={2}>
                                                    <div className="react-expandable expanded text-center-sm">
                                                      <div className="expandable-content" tabIndex={-1} style={{}}>
                                                        <p>{review.comments}</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="text-muted review-subtext">
                                                    <div className="review-translation-language">
                                                    </div>
                                                    <div>
                                                      <div className="text-center-sm">
                                                        <span className="date" style={{display: 'inline-block'}}>
                                                          {review.date_fy}
                                                        </span>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <span>
                                                </span>
                                              </div>
                                              <div className="row space-2">
                                                <div className="col-md-9 col-md-push-3">
                                                  <hr />
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        })}
                                    </div>
                                </div>
                            </div>
                                :
                                <div></div>
                        }
                    </div>
                </div>
            </div>
            <Modal open={this.state.is_open_modal} onClose={this.onCloseModal} closeIconSize={20} center styles={{ modal: { padding: '0px' } }}>
                <div className="row d-lg-flex flex-md-column flex-lg-row">
                    <div className="col-lg-5 d-flex flex-basis-40 p-0">
                        <div id="review_form_wizard_left_form" className="left_form">
                            <figure><img src="https://www.vacation.rentals/images/icons/review_bg.svg" /></figure>
                            <h2>Write a Review</h2>
                            <p>An honest review will help your host provide a better experience, and it will help travelers when they’re selecting a place to stay.</p>
                            <a href="https://www.vacation.rentals/united-states" id="more_info"><i className="icon icon3-house" /></a>
                        </div>
                    </div>
                    <div className="col-lg-7 d-flex justify-content-center p-4">
                        <div className='step-progress'>
                            <StepZilla steps={steps} prevBtnOnLastStep={false} />
                        </div>
                    </div>
                </div>{/* /Row */}
            </Modal>
        </div>
    }
}
export default RoomReview