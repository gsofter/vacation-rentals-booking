import React from 'react'
class Amenities extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
      let amenities_list = this.props.amenities_type ? this.props.amenities_type : []
          amenities_list = amenities_list.map((amenity_type) => {
            let amenties_items = this.props.amenities.map((amenity, index) => {
                if(amenity && amenity.type_id && amenity.type_id == amenity_type.id){
                    return <div className="row-space-2 col-sm-12  col-md-6 space-sm-0" key={index}>
                    {/* <img src={this.props.amenities_icon[index].image_url} style={{width: '20px', height: '20px'}} />
                    &nbsp; */}
                    <span className="js-present-safety-feature">
                      <strong>
                        {amenity.name}
                      </strong>
                    </span>
                  </div>
                }
            })
            return <div className="lang-chang-label clrleft" key={amenity_type.id}>
            <div className="title_category col-sm-12">
              <div className="amenities-title-container">
                <h6>{amenity_type.name}</h6>
              </div>
            </div>
            {amenties_items}
          </div>
        })
        return <div className="expandable-content-summary">
        <div className="row rooms_amenities_before">
        <div className="col-md-12 space-top-sm-2 col-sm-12 space-top-sm-2">
        {amenities_list}
        </div>
        </div>
        </div>
    }
}
export default Amenities