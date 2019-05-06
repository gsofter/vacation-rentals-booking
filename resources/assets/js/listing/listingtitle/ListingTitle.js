import React from 'react';

class ListingTitle extends React.PureComponent {
    render(){
        return(
            <div className="swiper-slide">
                <div className="city-wrapper lp-title no-bg p-0 h-auto">
                    <div className="kl-bg-source__overlay"></div>
                    <h3 className="m_title position-absolute shadow-text">
                        Florida
                    </h3>
                    <a href="" className="btn-lined btn-lg ac-btn w-70 text-center">View More...</a>
                </div>
            </div>
        );
    }
}

export default ListingTitle;