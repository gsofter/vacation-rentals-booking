import React from 'react';

class HostProfile extends React.PureComponent {
    constructor(props){
        super(props);
    }

    render(){
        return(
            <div id="host-profile" className="room-section webkit-render-fix">
                <div className="page-container-responsive p-0 space-8">
                    <div className="col-lg-8 panel lang-chang-label col-sm-12">
                        <div className="panel-body">
                        <h4 className="row-space-4 text-center-sm">
                            About the Host, Irene
                        </h4>
                        <div className="flex_cnt clearfix">
                            <div className="col-md-4 text-center lang-chang-label col-sm-12">
                            <a href="https://www.vacation.rentals/users/show/10022" className="media-photo media-round"><img alt="Irene" data-pin-nopin="true" height={90} src="https://www.vacation.rentals/images/users/10022/profile_pic_1526643960_225x225.jpg" title="Irene" width={90} /></a>
                            <div>
                                North Wales, United Kingdom
                            </div>
                            <div>
                                Member since 2018
                            </div>
                            </div>
                            <div className="col-md-8 col-sm-12">
                            <div className="row row-condensed">
                                <div className="col-md-12 lang-chang-label col-sm-12">
                                <p className="text-left">
                                    Brits Irene and Christopher Proudlove fell in love with Bradenton Beach on Anna Maria Island more than 30 years ago and have happy memories of family holidays there with their two children. In 2015, their long-held pipe dream of one day owning their own holiday home in Bradenton Beach was finally realised. One day they’ll get to spend longer there but in the meantime, they are happy to share their home from home with others.
                                </p>
                                </div>
                                <div className="col-12 text-center">
                                <a id="host-profile-website-btn" className="btn custom_btn btn-primary" href="https://www.rb162.com" target="_blank">
                                    Website
                                </a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <hr className="space-4 space-top-4" />
                        <div className="flex_cnt clearfix">
                            <div className="col-md-3 lang-chang-label col-sm-12">
                            <div className="text-muted text-center">
                                <a className="link-reset" rel="nofollow" href="https://www.vacation.rentals/users/show/10022#reviews">
                                <div className="text-center text-wrap hrt">
                                    <div className="badge-pill h3">
                                    <span className="badge-pill-count">0</span>
                                    </div>
                                    <div className="row-space-top-1">Reviews</div>
                                </div>
                                </a>
                            </div>
                            </div>
                            <div className="col-md-9 col-sm-12">
                            <div className="row row-condensed">
                                <div id="contact_wrapper" className="js-book-it-btn-container row-space-top-2">
                                <button type="button" id="host-profile-contact-btn" className="js-book-it-btn btn btn-large btn-block btn-primary">
                                    <span ><i className="icon icon-bell text-beach h4 book-it__instant-book-icon" />
                                    Contact Host
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

export default HostProfile;