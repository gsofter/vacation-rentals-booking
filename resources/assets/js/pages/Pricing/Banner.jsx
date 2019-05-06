import React from 'react'
import banner_image from './banner.jpg'
import Masks from '../../components/ui_elements/Masks'
class Banner extends React.Component {
    constructor(props) {
        super(props)
    }
    render() {
        return <div className="hero shift-with-hiw js-hero" id="help_banner" >
            <div className="hero__background" data-native-currency="ZAR" aria-hidden="true">
                <ul className="rslides" id="home_slider">
                    <li className="slider-image">
                        <img src={banner_image} width={1519}    />
                    </li>
                </ul>
            </div>
            <div className="hero__content page-container page-container-full text-center">
                <div className="va-container va-container-v va-container-h">
                    <div className="rjbanercont">
                        <h3>
                            <span className="left_cls white">Listing Plan Comparison
</span>
                            {/* <div className="hero-sub-text mt-15 white shadow-text d-flex justify-content-center">
                                <div className="text-container">
                                    <div className="animated fadeIn mr-20 d-inline-block delay-4s slower">.</div>
                                    <div className="animated zoomIn slower d-inline-block">No Commissions.</div>
                                    <div className="animated fadeIn ml-20 d-inline-block delay-4s slower">100% Verified.</div>
                                </div>
                            </div> */}
                        </h3>
                    </div>
                    <div className="va-middle">
                        <div className="back-black">
                            <div className="show-sm hide-md sm-search">
                                <div className="input-addon js-p1-search-cta" id="sm-search-field">
                                    <span className="input-stem input-large fake-search-field">Listing Plan Comparison
</span>
                                    <i className="input-suffix btn btn-primary icon icon-full icon-search" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <Masks style={4}/>
        </div>
    }
}
export default Banner