import React from 'react';
import { BrowserRouter as Router, Route, Switch, Link  } from 'react-router-dom';
class ListingSlideLarge extends React.PureComponent {
  constructor(props){
    super(props)
  }
    render(){
      let slide_data = this.props.slide_data
      let slide_list = slide_data.map((slide) => {
        console.log('--------------',slide.first_room.featured_image)
          return    <div className="swiper-slide" data-tag={slide.id}  key={slide.id}>
            <div className="post big-post  max-h-400">
              <a href={`/homes/${slide.first_room.address_url}/${slide.first_room.room_id}`} className="hoverBorder" title={`${slide.first_room.sub_name}`}>
                <span className="hoverBorderWrapper">
                  <img src={slide.first_room.featured_image} className="img-fluid img-cover" alt={`${slide.first_room.sub_name}`} title={`${slide.first_room.sub_name}`} />
                  <span className="theHoverBorder" />
                </span>
              </a>
              <div className="post-details">
                <h3 className="m_title">
                  <a href={`/homes/${slide.first_room.address_url}/${slide.first_room.room_id}`} title={`${slide.first_room.sub_name}`}>
                   {slide.first_room.name}
                  </a>
                </h3>
                <em>
                {slide.first_room.short_description}
                </em>
              </div>
            </div>
          </div>
         
      })
        return(
            <div className="featured-swipe swiper-container  max-h-400 swiper-container-horizontal">
            {/* Additional required wrapper */}
            <div className="swiper-wrapper" style={{transform: 'translate3d(0px, 0px, 0px)'}}>
                {slide_list}
            </div>
            <span className="swiper-notification" aria-live="assertive" aria-atomic="true" /></div>
        );
    }
}

export default ListingSlideLarge;