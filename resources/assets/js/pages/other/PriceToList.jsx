import React from 'react'

class PriceToList extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        return   <div className="page-container-responsive">
        <div className="row-space-top-6 row-space-16 text-wrap">
          <h1>List With Us For Only&nbsp;$225 A Year!&nbsp;</h1><h1>(Additional properties are only&nbsp;$150 A Year!)</h1>
          <h2>Take back control of your vacation home listing and save money in the process:</h2>
          <p>We are dedicated to giving you the site that you demand and need. No commissions - no fees - no convenience charges. Just a straightforward $225 a year and nothing else.</p>
          <h2>Some useful features:</h2>
          <ol>
            <li>Immediate exposure to search engines</li>
            <li>Free Custom YouTube video</li>
            <li>Direct communication with your customers</li>
            <li>7/24 Support when and how you need it</li>
            <li>Free website hosting</li>
            <li>Free custom business cards</li>
          </ol>
          <h2>We <span style={{textDecorationLine: 'underline'}}>also</span> own the YouTube channel for Vacation Rentals</h2>
          <p>Once your order is placed we will create a custom video for your property and give you the link to paste it into your page and also put it into the rotation on our channel.&nbsp;This video is yours to share with as many guests and friends as you like.&nbsp;</p>
          <p><strong>We will do everything we can to market your property as aggressively as we can</strong>. There is simply nothing we will not do to drive as much business to you as possible. Spread the word, get others to join and help us - to help you take back control of your vacation rental.</p>
        </div>
      </div>
    }
}
export default PriceToList