import React from 'react';

import ListingSlideLarge from './listingslidelarge/ListingSlideLarge';
import ListingSlideSmall from './listingslidesmall/ListingSlideSmall';
import CitiesSlider from '../components/swipeslider/CitiesSlider'
import Masks from '../components/ui_elements/Masks';
import './listing.css'
class Listing extends React.PureComponent {
    constructor(props){
        super(props)
    }
    render(){
        
        const slides = this.props.tags.map((tag) => {
            return {
                key : tag.id,
                id : tag.id,
                altText: tag.name,
                caption: tag.description,
                src : tag.image_url
              }
        })
        return(
            <section className="discovery-section white_bg hg_section pt-60 pb-100" id="discover-recommendations">
                <div className="page-container-responsive page-container-no-padding">
                    <div className="container">
                        <div className="row">
                            <div className="col-sm-12 col-md-12">


                                <div className="latest_posts default-style kl-style-2">
                                    <div className="row gutter-sm">
                                        
                                        <div className="col-sm-12 col-md-4 col-lg-4">
                                            <div className="tag-swipe swiper-container hsize-400">
                                                    <CitiesSlider slides={slides} />
                                            </div>
                                        
                                        </div>
                                        
                                        <div className="col-sm-12 col-md-8 col-lg-8">
                                                <ListingSlideLarge slide_data = {this.props.tags}/>
                                        </div>
                                        <div className="col-sm-12 col-md-12 col-lg-12 mt-5">
                                            <div className="listing-swipe swiper-container max-h-200">
                                                {/* <div className="swiper-wrapper"> */}
                                                    <ListingSlideSmall slide_data = {this.props.small_slide_data}/>
                                                {/* </div> */}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <Masks style={1}/>
            </section>
        );
    }
}

export default Listing;