import React from 'react'
import banner_image from './banner.jpg'
import Masks from '../../components/ui_elements/Masks'
class HelpBanner extends React.PureComponent {
    constructor(props) {
        super(props)
    }
    render() {
        return <div className="hero shift-with-hiw js-hero" id="help_banner" >
            <div className="hero__background" data-native-currency="ZAR" aria-hidden="true" style={{ background : `url(${banner_image})`, backgroundSize : 'cover', backgroundPosition : 'center' }}>
               
            </div>
            <div className="hero__content page-container page-container-full text-center"  >
                <div className="va-container va-container-v va-container-h">
                  
                    <div className="va-middle">
                        <div className="back-black">
                            <div className="show-sm hide-md sm-search">
                                <div className="input-addon js-p1-search-cta" id="sm-search-field">
                                <input className="checkout input-large text-truncate input-contrast " value={this.props.value} placeholder="Please Input Keyword." onChange={this.props.onChange}   />
                            {this.props.searchResult}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="hero__content-footer hide-sm d-md-flex justify-content-center" >
                    <div className="col-sm-8">
                        <div id="searchbar">
                            <div className="searchbar rjsearchbar" data-reactid=".1">
                                <form className="simple-search clearfix" method="get" id="help-searchbar-form" name="simple-search">
                                    <div className="saved-search-wrapper searchbar__input-wrapper">
                                        <label className="input-placeholder-group ">
                                            <input className="checkout input-large text-truncate input-contrast " value={this.props.value} placeholder="Please Input Keyword." onChange={this.props.onChange}   />
                            {this.props.searchResult}

                                        </label>
                                    </div>
                                    {/* <button id="submit_location" type="submit" className="searchbar__submit btn btn-primary btn-large">Search</button> */}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Masks style={4}/>
        </div>
    }
}
export default HelpBanner