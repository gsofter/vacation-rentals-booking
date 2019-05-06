import React from 'react';
import './communicate.css';
import Masks from '../../components/ui_elements/Masks'
class Communicate extends React.PureComponent {
    render(){
        return(
            <section className="hg_section--relative py-0 ">
            <div className="full_width ">
              <div className="row">
                <div className="col-md-12 col-sm-12">
                  {/* media-container */}
                  <div className="media-container style2 hsize-400 d-flex align-items-start align-items-lg-center justify-content-center">
                    {/* bg source */}
                    <div className="kl-bg-source">
                      <div className="kl-bg-source__bgimage" style={{backgroundImage: `url(https://res.cloudinary.com/vacation-rentals/image/upload/w_${document.body.clientWidth},c_fill,fl_lossy,q_auto:low/v1553978188/images/vacation_2.jpg)`, backgroundRepeat: 'no-repeat', backgroundAttachment: 'scroll', backgroundPositionX: 'center', backgroundPositionY: '75%', backgroundSize: 'cover'}} />
                      <div className="kl-bg-source__overlay" style={{backgroundColor: 'rgba(0,0,0,0.25)'}} />
                      <div className="kl-bg-source__overlay-gloss" />
                    </div>
                    {/*/ bg-source */}
                    {/* media-container button */}
                    <div className="media-container__link media-container__link--btn media-container__link--style-borderanim2 py-2 d-flex flex-column justify-content-center">
                      <div className="row">
                        <div className="borderanim2-svg text-center mx-auto">
                          <svg height={140} width={140} xmlns="http://www.w3.org/2000/svg">
                            <rect className="borderanim2-svg__shape" x={0} y={0} height={140} width={140} />
                          </svg>
                          <span className="media-container__text"><a href="javascript:void(0)" className="signup_popup_head2" title="Register"><img src="https://res.cloudinary.com/vacation-rentals/image/upload/v1553980443/images/vr-icon-white.png" className="img-fluid media-container-icon" alt="Vacation Rentals" /> </a></span>
                        </div>
                      </div>
                      <div className="row">
                        <div className="col-10 col-md-12 float-none mx-auto">
                          <div className="text-center pt-1 pt-md-4">
                            <h2 className="tbk__title kl-font-alt fs-xs-xl fs-l fw-bold white shadow-text ">
                              Communicate directly with each other <span className="tcolor-ext">BEFORE</span> the reservation is made.
                            </h2>
                            <p className="white mt-2">
                              <span className="d-block fs-xs-md fs-22">We think of ourselves as "The Vacation Matchmaker!"</span>
                              <span className="d-block mt-1 fs-xs-small fs-18">We just make the introductions and leave the rest to you - the homeowner and  traveler.</span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    {/*/ media-container button */}
                  </div>
                  {/*/ media-container */}
                </div>
                {/*/ col-md-12 col-sm-12  */}
              </div>
              {/*/ row */}
            </div>
            {/* Bottom mask style 3 */}
            <Masks style='3' svg_class='svgmask-left'/>
            {/*/ Bottom mask style 3 */}
          </section>
        );
    }
}

export default Communicate;
