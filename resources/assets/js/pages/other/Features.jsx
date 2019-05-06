import React from 'react'
class Features extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        return <div className="page-container-responsive">
        <div className="row">
          <div className="feature_section">
            <h1>Side By Side, there is simply, no comparison</h1>
            <img className='img-responsive' src="/images/Compare-side-by-side-different-vacation-rental-websites.jpg" />
            <div className="rj_head_block">
              <h2>LOOK AT WHAT WE OFFER</h2>
              <p>We understand we are a new site – no debate there. but, we are a motivated company that intends to change the way vacationers find their homes and owners list their homes. look at the chart below and see how we compare</p>
              <table className="table" border={10} cellSpacing={2} cellPadding={2} style={{width: '800px'}} align="center">
                <tbody>
                  <tr><td>&nbsp;Features</td><td>&nbsp;AirBNB©</td><td>&nbsp;VRBO©</td><td>&nbsp;Vacation.Rentals©</td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Image Gallery</span></li></ul></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold'}}>&nbsp;<span style={{fontSize: 'x-large'}}>X</span></span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold'}}>&nbsp;<span style={{fontSize: 'x-large'}}>X</span></span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold'}}>&nbsp;<span style={{fontSize: 'x-large'}}>X</span></span></td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Direct Communication</span></li></ul></td>
                      <td style={{textAlign: 'center'}}><span style={{fontSize: 'x-large', fontWeight: 'bold'}}>&nbsp;</span></td>
                      <td style={{textAlign: 'center'}}><span style={{fontSize: 'x-large', fontWeight: 'bold'}}>&nbsp;</span></td>
                      <td style={{textAlign: 'center'}}><span style={{fontSize: 'x-large', fontWeight: 'bold'}}>&nbsp;X</span></td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Technical Staff</span></li></ul></td><td style={{textAlign: 'center'}}><span style={{fontSize: 'x-large', fontWeight: 'bold'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontSize: 'x-large', fontWeight: 'bold'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontSize: 'x-large', fontWeight: 'bold'}}>&nbsp;X</span></td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Google Maps</span></li></ul></td><td style={{textAlign: 'center'}}>&nbsp;<span style={{fontWeight: 'bold', fontSize: 'x-large'}}>X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Reviews</span></li></ul></td><td style={{textAlign: 'center'}}>&nbsp;<span style={{fontWeight: 'bold', fontSize: 'x-large'}}>X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>iCal Import</span></li></ul></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Host commission</span></li></ul></td><td style={{textAlign: 'center'}}>&nbsp;<span style={{fontWeight: 'bold', fontSize: 'x-large'}}>X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td>&nbsp;</td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Traveler Fees</span></li></ul></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td>&nbsp;</td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Seasonal Rates</span></li></ul></td><td style={{textAlign: 'center'}}>&nbsp;<span style={{fontWeight: 'bold', fontSize: 'x-large'}}>X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td></tr>
                  <tr><td>&nbsp;<ul><li><span style={{fontWeight: 'bold'}}>Amenities</span></li></ul></td><td style={{textAlign: 'center'}}>&nbsp;<span style={{fontWeight: 'bold', fontSize: 'x-large'}}>X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td><td style={{textAlign: 'center'}}><span style={{fontWeight: 'bold', fontSize: 'x-large'}}>&nbsp;X</span></td></tr></tbody>
              </table>
            </div>
            <div className="rj_price_table_holder">
              <div className="rj_price_col">
              </div><div className="rj_text_rj">
                <p><br /></p>
              </div>
            </div>
            </div>
        </div>
        <div className="row">
              <div className="col-md-5">
                <img className='img-responsive' src="/images/shackled-and-chained.jpg" />
              </div>
              <div className="col-md-7">
                <div className="rj_word_content">
                  <h4>DON’T SETTLE FOR LESS</h4>
                  <h5>You DO have options!</h5>
                  <div className="broder_rj" />
                  <p>We are going to give you options! We will overwhelm you with options! You are not bound to just one online travel agency. Yes – they have name recognition. Yes – they have established clientele. Yes – they have a great support staff in place. <span style={{textDecoration: 'underline'}}><strong>But they also charge a massive amount in the way of homeowner and traveler fees and commissions.</strong></span>&nbsp;You can break free and operate your vacation home for rent as you see fit and we are here to help you achieve that. You are back in control with <a href="https://vacation.rentals">Vacation Rentals by Vacarent</a>. You have the final say on who you rent out your investment to. As a traveler you will have direct control over who you stay with. Homeowners are back in control of their finances and pricing on their property. Both the homeowner AND the traveler win and we are proud to be a part of it.</p>
                </div>
              </div>
            </div>
            <div className="row">
              <div className="col-md-12">
                <div className="rj_head_block">
                  <h2>YES, YOU CAN STILL LIST ON OTHER SITES</h2>
                  <p>sometimes the fear of leaving what is comfortable overwhelms the logical choice to do what’s right. we understand that and welcome the opportunity to show you over the next year how well we stack up against the other choices.</p>
                </div>
              </div>
            </div>
            <div className="row">
              <div className="col-md-5">
                <img className='img-responsive' src="/images/hut.jpg" />
              </div>
              <div className="col-md-7">
                <div className="rj_word_content">
                  <h4>DON’T SETTLE FOR LESS</h4>
                  <h5>Don’t toss your hard earned cash away on “wannabes”</h5>
                  <div className="broder_rj" />
                  <p>There are at least 500 Vacation Rental websites out there. Ask yourself honestly – does ANYONE search for “Tex By Oh” (Texas By Owner) homes? Have you EVER said to your spouse “Honey, see if there is a FYAH (Fie-Ah) “For You A House” homes in Branson?</p>
                </div>
              </div>
            </div>
      </div>
    }
}

export default Features