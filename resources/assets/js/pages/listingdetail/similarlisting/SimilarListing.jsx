import React from 'react';
import Slider from "react-slick";
import './similarlisting.css'
class SimilarListing extends React.PureComponent {
    constructor(props){
        super(props);
    }

    render(){
        let slider_list = this.props.listings ? this.props.listings : []
          let slide_list = slider_list.map((listing) => {
              return  <div className="listing list_view " key={listing.id}>
              <div className="panel-image listing-img">
                
                <a href={`/homes/${listing.address_url}/${listing.id}`} target="_blank" className="media-photo media-cover">
                  <div className="listing-img-container media-cover text-center">
                    <img id="rooms_image_10968" src={listing.slide_image_name} className="img-responsive-height" />
                  </div>
                </a>

              </div>
              <div className="panel-body panel-card-section">
                <div className="media">
                  <div className="category_city hm_cate">
                    <span >{listing.sub_name}
                    </span>
                  </div>
                 
                
                  <div itemProp="description" className="pull-left text-muted listing-location text-truncate nt_star">
                    <a href="#" className="text-normal link-reset pull-left">
                      <span className="pull-left">
                        <span className="pull-left"><div className="star-rating"> <div className="foreground"> </div> <div className="background mb_blck"><i className="icon icon-star icon-light-gray" /> <i className="icon icon-star icon-light-gray" /> <i className="icon icon-star icon-light-gray" /> <i className="icon icon-star icon-light-gray" /> <i className="icon icon-star icon-light-gray" /> </div> </div>
                        </span>
                      </span>
                    </a>
                  </div>
                </div>
                <a href={`/homes/${listing.address_url}/${listing.id}`} target="_blank" className="text-normal">
                    <h3 title={listing.name} itemProp="name" className="h5 listing-name text-truncate row-space-top-1">
                     {listing.name}
                    </h3>
                  </a>
                <div className="exp_price">
                    <strong>{listing.rooms_price.currency_code == 'USD' ? '$' : listing.rooms_price.currency_code}{listing.rooms_price.night} 
                    </strong>
                   
                    <span> This fee is charged per night of your reservation.</span>
                  </div>
              </div>
            </div>
          })
          const settings = {
            lazyLoad: true,
            arrows: false,
            dots : false,
            centerPadding: "60px",
            infinite: false,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 4,
            initialSlide: 0,
            className: "center",
            centerPadding : '50px',
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3,
                  infinite: true,
                  dots: true
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                  initialSlide: 2
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          };
        return(
            <div id="similar-listings">
                <div className="page-container-responsive row-space-top-5 row-space-5">
                    <div className="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <h4 className="row-space-4 text-center-sm">
                        Similar Listings
                        </h4>
                        <div className="slider1 owl-carousel slide1 owl-loaded owl-drag">
                        <div>
                        {slide_list.length ? 
                          <Slider {...settings}>
                        {slide_list}
                        </Slider>
                        : <div></div>}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
export default SimilarListing;