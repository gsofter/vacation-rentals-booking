import React, { Component } from 'react';
import Banner from '../../common/banner/Banner';
import How from '../../common/how/How';
import Popular from '../../common/popular/Popular';
import Hostsection from '../../common/host/Hostsection';
import Communicate from '../../common/communicate/Communicate';
import Listing from '../../listing/Listing';

const index_page_data = JSON.parse(document.getElementById('page_json_data').innerHTML);;
export class Home extends Component {
  constructor(props){
    super(props)
    this.state = {
      home_page_sliders : index_page_data.home_page_sliders,
      home_page_media : 'Slider',
      tags : index_page_data.tags,
      small_slide_data : index_page_data.small_slide_data
    }
  }
  componentDidMount(){
    // axios.get('/ajax/home/index')
    // .then( res => {
    //   this.setState({
    //     home_page_sliders : res.data.home_page_sliders,
    //     home_page_media : res.data.home_page_media,
    //     tags : res.data.tags,
    //     small_slide_data : res.data.small_slide_data,
    //   })
    // })
  }
    render() {
       
        return (
           
                <main id="site-content" role="main">
                <div className=" shift-with-hiw js-hero">
                <Banner home_page_media = {this.state.home_page_media} home_page_sliders = {this.state.home_page_sliders}/>
                <How/>
                <Communicate/>
                <Listing tags={this.state.tags} small_slide_data = {this.state.small_slide_data}/>
                <Popular/>
                      <div className="action_box style1 mb-80" data-arrowpos="center">
                        <div className="action_box_inner container ">
                          <div className="page-container-no-padding action_box_content row d-flex-lg align-content-center">
                            {/* Content */}
                            <div className="ac-content-text col-sm-12 col-md-12 col-lg-9 mb-md-20">
                              {/* Title */}
                              <h4 className="text text-center text-md-left ">
                                Ready to join the hundreds of homeowners and property managers listing on <span className="fw-bold">Vacation.Rentals?</span>
                              </h4>
                            </div>
                            {/*/ Content col-sm-12 col-md-12 col-lg-7 mb-md-20 */}
                            {/* Call to Action buttons */}
                            <div className="ac-buttons col-sm-12 col-md-12 col-lg-3 d-flex align-self-center justify-content-center justify-content-lg-end">
                              <a href="/rooms/new" className="btn-lined btn-lg ac-btn w-100 text-center" title="List your property with Vacation.Rentals">
                                Get Started!
                              </a>
                            </div>
                            {/*/ Call to Action buttons */}
                          </div>
                          {/*/ .action_box_content */}
                        </div>
                        {/*/ .action_box_inner */}
                      </div>
                <Hostsection/>
                </div>
                </main>
           
        )
    }
}

export default Home;
