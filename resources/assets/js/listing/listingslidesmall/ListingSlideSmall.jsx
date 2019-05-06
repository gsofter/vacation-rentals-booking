import React from 'react';
import Slider from "react-slick";
 
class ListingSlideSmall extends React.PureComponent {
  constructor(props){
    super(props)
  }
  
    render(){
      const settings = {
        lazyLoad: true,
        arrows: true,
        dots : false,
        centerPadding: "60px",
        infinite: false,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 4,
        initialSlide: 0,
        className: "center",
        responsive: [
          {
            breakpoint: 1280,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              initialSlide: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      };
      let slide_list = this.props.slide_data.map((slide, index) => {
      
        return  <div className="post hsize-150" key={index}>
          <a href="javascript:;" className="hoverBorder">
            <span className="hoverBorderWrapper">
              <img src={slide.featured_image} className="img-fluid img-cover h-100" alt="unique" title={slide.name} />
              <span className="theHoverBorder" />
            </span>
          </a>
          <div className="post-details pb-1 bg-black-trans-50">
            <h6 className="m_title">
            <a href = {`/homes/${slide.address_url}/${slide.room_id}`} title={slide.name}>
                {slide.short_description.replace('messages.rooms.bedroom', 'Bedroom | Bedrooms')}
              </a>
            </h6>
          </div>
        </div>
      
      })  
      console.log('+++++++++++++++++++',slide_list)
      if(this.props.slide_data.length && slide_list.length){
        return(
          <div className="swiper-slide ">
          <Slider {...settings}>
                        {slide_list}
                        </Slider>
                        </div>
        );
      }
      else{
        return <div></div>
      }
       
    }
}

export default ListingSlideSmall;