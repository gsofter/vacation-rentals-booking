import React from 'react';
 
import Masks from '../../components/ui_elements/Masks';


class Popular extends React.PureComponent {
    render(){
        return(
            <section className="hg_section--relative pt-0 pb-45 mb-0">
                <div className="page-container-responsive page-container-no-padding pt-0 pb-80">
                    <div className="container">
                        <div className="row">
                            <div className="col-12 col-sm-12">
                                <div className="section-intro text-center row-space-6 row-space-top-8">
                                    <h2 className="row-space-1 tcolor fw-bold">Vacation rentals in popular destinations</h2>
                                    <p>'Why stay in a cramped-up hotel room when you can stay in one of our vacation rental properties direct from a local homeowner? When you inquire about one of our listings, you are dealing directly with the actual homeowner or property manager. All contracts, directions, information, payments and assistance are handled by the person who knows it best – the homeowner! We just make the introductions and leave the rest to you.</p>
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-12 col-sm-12 col-md-12">
                                <div className="grid-ibx grid-ibx--cols-3 grid-ibx--style-lined-full grid-ibx--hover-shadow">
                                    <div className="grid-ibx__inner">
                                        <div className="grid-ibx__row clearfix d-flex flex-column flex-md-row">
                                            <div className="grid-ibx__item h-300">
                                                <div className="grid-ibx__item-inner">
                                                    <div className="grid-ibx__title-wrp">
                                                        <h4 className="grid-ibx__title kl-font-alt fs-m">
                                                            GREAT HOMES
                                                        </h4>
                                                    </div>
                                                    <div className="grid-ibx__icon-wrp">
                                                        <img className="popularone" src='https://res.cloudinary.com/vacation-rentals/image/upload/v1553978125/images/vc_rj_1.png' width="70" height="70" alt="" />
                                                    </div>
                                                    <div className="grid-ibx__desc-wrp">
                                                        <p className="grid-ibx__desc fs-16">
                                                            Find out what it's like to stay at the top of a mountain or right on the beach. <a href="{{ url('united-states') }}" title="Find a private home for rent for your next vacation">Find a private home for rent</a> that has everything you want and more.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="grid-ibx__item h-300">
                                                <div className="grid-ibx__item-inner">
                                                    <div className="grid-ibx__title-wrp">
                                                        <h4 className="grid-ibx__title kl-font-alt fs-m">
                                                            #1 SEARCH TERM
                                                        </h4>
                                                    </div>
                                                    <div className="grid-ibx__icon-wrp">
                                                        <img className="populartwo" src='https://res.cloudinary.com/vacation-rentals/image/upload/v1553978138/images/vc_rj_3.png' width="70" height="70" alt="" />
                                                    </div>
                                                    <div className="grid-ibx__desc-wrp">
                                                        <p className="grid-ibx__desc fs-16">
                                                            Travelers find homes for rent by searching for the number 1 search term in the world - "Vacation Rentals". Help travelers find yours by listing with us.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="grid-ibx__item h-300">
                                                <div className="grid-ibx__item-inner">
                                                    <div className="grid-ibx__title-wrp">
                                                        <h4 className="grid-ibx__title kl-font-alt fs-m">
                                                            INTERACT DIRECT
                                                        </h4>
                                                    </div>
                                                    <div className="grid-ibx__icon-wrp">
                                                        <img className="popularthree" src='https://res.cloudinary.com/vacation-rentals/image/upload/v1553978147/images/vc_rj_6.png' width="70" height="70" alt="" />
                                                    </div>
                                                    <div className="grid-ibx__desc-wrp">
                                                        <p className="grid-ibx__desc fs-16">
                                                            We filter nothing. Customers and homeowners are free to interact with each other instantly with no fear of their contact information being scrubbed.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div className="grid-ibx__row clearfix d-flex flex-column flex-md-row">
                                            <div className="grid-ibx__item h-300">
                                                <div className="grid-ibx__item-inner">
                                                    <div className="grid-ibx__title-wrp">
                                                        <h4 className="grid-ibx__title kl-font-alt fs-m">
                                                            VERIFIED LISTINGS</h4>
                                                    </div>
                                                    <div className="grid-ibx__icon-wrp">
                                                        <img className="popularfour" src='https://res.cloudinary.com/vacation-rentals/image/upload/v1553978159/images/vc_rj_2.png' width="70" height="70" alt="" />
                                                    </div>
                                                    <div className="grid-ibx__desc-wrp">
                                                        <p className="grid-ibx__desc fs-16">
                                                            Every home that is listed on our site is verified prior to activation by the site administrator. What you reserve is what you will get. We do not allow "bait and switch" tactics.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="grid-ibx__item h-300">
                                                <div className="grid-ibx__item-inner">
                                                    <div className="grid-ibx__title-wrp">
                                                        <h4 className="grid-ibx__title kl-font-alt fs-m">
                                                            NO COMMISSIONS
                                                        </h4>
                                                    </div>
                                                    <div className="grid-ibx__icon-wrp">
                                                        <img className="popularfive" src='https://res.cloudinary.com/vacation-rentals/image/upload/v1553978166/images/vc_rj_5.png' width="70" height="70" alt="" />
                                                    </div>
                                                    <div className="grid-ibx__desc-wrp">
                                                        <p className="grid-ibx__desc fs-16">
                                                            Homeowners and property managers never need to worry about commissions when listing with us. Ours is a straight forward annual membership and nothing more.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="grid-ibx__item h-300">
                                                <div className="grid-ibx__item-inner">
                                                    <div className="grid-ibx__title-wrp">
                                                        <h4 className="grid-ibx__title kl-font-alt fs-m">
                                                            NO TRAVELERS FEES
                                                        </h4>
                                                    </div>
                                                    <div className="grid-ibx__icon-wrp">
                                                        <img className="popularsix" src='https://res.cloudinary.com/vacation-rentals/image/upload/v1553978173/images/vc_rj_4.png' width="70" height="70" alt="" />
                                                    </div>
                                                    <div className="grid-ibx__desc-wrp">
                                                        <p className="grid-ibx__desc fs-16">
                                                            We never charge travelers for making a reservation through our site. All expenses are paid by the listing owner with nothing else due. <span className="d-block"><a href="{{ url('united-states') }}" title="Book with confidence and enjoy your vacation.">Book with confidence and enjoy your vacation.</a></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <Masks style={2}/>
            </section>
        );
    }
}

export default Popular;