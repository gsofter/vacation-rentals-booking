import React from 'react';

class ListingReview extends React.PureComponent {
    constructor(props){
        super(props);
    }

    render(){
        return(
            <div id="reviews" className="room-section webkit-render-fix mt-5">
                <div className="page-container-responsive p-0">
                    <div className="clearfix">
                        <div className="col-lg-8 lang-chang-label p-0 col-sm-12">
                            <div className="panel row-space-top-3 review-content">
                                <div className="panel-body">
                                    <div className="row d-lg-flex align-items-center mb-3">
                                        <div className="col-12 col-md-8">
                                        <h4 className="text-center-sm">
                                            No Reviews Yet
                                        </h4>
                                        </div>
                                        <div className="col-12 col-md-4 align-items-center">
                                        <button type="button" id="review-listing-btn" className="btn btn-block btn-primary btn-md">
                                            <span><i className="glyphicon-bullhorn" />
                                            Leave a Review
                                            </span>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default ListingReview;