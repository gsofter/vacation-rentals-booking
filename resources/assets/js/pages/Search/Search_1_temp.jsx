import React from 'react'

class Search extends React.Component{
    render(){
        return <section className="listingsearch_">
        <div className="container-fluid">
          {/* listing-searchbar start */}
          <div className="listing-searchbar">
            <div className="row">
              <div className="col-md-6 col-sm-9">
                <div className="row">
                  <div className="col-md-3  col-sm-6">
                    <div className="field-wrapper">
                      <img src="img/where.svg" alt /> 
                      <label className="form-label" htmlFor="where">Where</label>
                      <input id="where" type="text" className="form-in" placeholder="Where" required />
                    </div>
                  </div>
                  <div className="col-md-3  col-sm-6">
                    <div className="field-wrapper">
                      <img src="img/calendar.svg" alt />
                      <label className="form-label" htmlFor="checkin">Check In</label>
                      <input id="checkin" type="text" className="form-in" placeholder="Check In" required />
                    </div>
                  </div>
                  <div className="col-md-3  col-sm-6">
                    <div className="field-wrapper">
                      <img src="img/calendar.svg" alt />
                      <label className="form-label" htmlFor="checkout">Check Out</label>
                      <input id="checkout" type="text" className="form-in" placeholder="Checkout" required />
                    </div>
                  </div>
                  <div className="col-md-3  col-sm-6">
                    <div className="field-wrapper">
                      <img src="img/avatar.svg" alt />
                      <label className="form-label" htmlFor="guests">Guests</label>
                      <select name="State" className="form-in">
                        <option selected>Select Guests</option>
                        <option value={1}>1</option>
                        <option value={2}>2</option>
                        <option value={3}>3</option>
                        <option value={4}>4</option>
                      </select>
                    </div>    
                  </div>
                </div>
              </div>
              <div className="col-md-6 col-sm-3">
                <div className="listing-more-filter">
                  <button><img src="img/filter.svg" alt /> More Filters</button>
                </div>
              </div>
            </div>
          </div>
          {/* listing-searchbar end */}
          {/*=== list & map button====*/}
          <div className="listing-maplist-button">
            <button className="search-listing-button button-active"><i className="fas fa-list-ol" /> List</button>
            <button className="search-map-button"><i className="fa fa-map" /> Map</button>
          </div>
          {/*=== list & map button====*/}
          {/* More filter section */}
          <div className="listing-morefilter">
            <div className="mobilefilter-close"><button><img src="img/close.svg" alt /></button></div>
            <div className="row">
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Property Type <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt />Common Amenities <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Additional Amenities <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Special Features <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
            </div>
            <div className="row">
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Home Safety <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt />Kitchen <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Indoor/Outdoor activities nearby  <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Leisure <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
            </div>
            <div className="row">
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Swimming Pools <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Ideal For <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Household <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> IT &amp; Communication <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
            </div>
            <div className="row">
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Activities Nearby <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
              <div className="col-md-3 col-sm-6">
                <h3 className="filtertitleclick"><img src="img/house.svg" alt /> Transportation <i className="fa fa-angle-down" aria-hidden="true" /></h3>
                <div className="listing-morefilter-list">
                  <ul>
                    <li>
                      <label><input type="checkbox" /> Apartment <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> House <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Bed &amp; Breakfast <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Townhouse <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Condominium <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Cabin <span /></label>   
                    </li>
                    <li>
                      <label><input type="checkbox" /> Villa <span /></label>   
                    </li>
                  </ul>
                </div>  
              </div>
            </div>
          </div>
          {/* More filter section */}
          {/* listing-searchbar start */}
          <div className="listing-map-list">
            <div className="row">
              <div className="col-md-7 col-sm-12">
                <div className="listing-list-mainparent">
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div>                                 <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div> 
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div>
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div>
                  <div className="listing-list-main">
                    <div className="listing-left-img">
                      <a href><img src="img/listing.jpg" alt /> <div className="list-type">Featured</div></a>
                    </div> 
                    <div className="listing-right-content">
                      <a href>
                        <div className="listing-list-topbar">
                          <h4><img src="img/house.svg" alt />Gold listing 1</h4>
                          <h6><img src="img/us.svg" alt /> Branson / Missouri</h6>
                          <p>Caboose in Taney County</p>
                          <button>Listing Details</button>
                        </div>
                        <div className="listing-list-btmbar">
                          <div className="listing-price">
                            <h3><span>$</span>179</h3>
                          </div>
                          <div className="listing-dates">
                            <p><img src="img/calendar.svg" alt /> <span>2019-03-08</span> To <span>2020-03-08</span></p>
                          </div>
                        </div>
                      </a>
                    </div>  
                  </div>    
                </div>  
                {/* <div class="listing-pagination">
                                <ul>
                                    <li><a href=""><img src="img/left-arrow.svg" alt=""/></a></li>
                                    <li><a href="">1</a></li>
                                    <li><a href="">2</a></li>
                                    <li><a href="">3</a></li>
                                    <li><a href="">4</a></li>
                                    <li><a href=""><img src="img/right-arrow.svg" alt=""/></a></li>
                                </ul>  
                            </div>    */}
              </div>
              <div className="col-md-5 col-sm-12">
                <div className="list-maparea">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117763.55154239164!2d75.79380997633002!3d22.72411583768725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fcad1b410ddb%3A0x96ec4da356240f4!2sIndore%2C+Madhya+Pradesh!5e0!3m2!1sen!2sin!4v1553463225926" width="100%" frameBorder={0} style={{border: 0}} allowFullScreen />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    }
}

export default Search