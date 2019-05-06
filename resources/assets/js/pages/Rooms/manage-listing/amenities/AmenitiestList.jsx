import React from 'react'
class AmenitiestList extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        let amenitiesList = this.props.amenities_type.map((type) =>{
            let products_list = this.props.amenities.map((amenity) => {
                if(type.id == amenity.type_id){
                    // console.log(this.props.prev_amenities.includes(amenity.id), this.props.prev_amenities, amenity.id.toString())
                    return  <div className="col-md-6" key={amenity.id}>
                                <label className="label-large label-inline amenity-label pos-rel">
                                    <input type="checkbox" onChange={this.props.onChange} className="comint" name="amenities" defaultChecked={this.props.prev_amenities.includes(amenity.id.toString())} value={amenity.id}/>
                                    <span className="comspn">{amenity.name}</span>     
                                </label>
                            </div>
                }
            })
            return <div className="amenites_list" key={type.id}>
                    <div className="amenities_left">
                        <h3>{type.name}</h3>
                    </div>
                    <div className="amenities_right">
                        <div className="amenitie_poduct">
                            {products_list}
                        </div>
                    </div>
                 </div>
        })
        return <div style = {{ position : 'unset' }}>{amenitiesList}</div>
    //     <div className="amenites_list">
    //     <div className="amenities_left">
    //         <h3>Common Amenities</h3>
    //     </div>
    //     <div className="amenities_right">
    //         <div className="amenitie_poduct">

    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">TV</span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">Cable TV</span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">Air Conditioning </span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  defaultValue={5} name="amenities"/>
    //                     <span className="comspn">Heating</span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">Kitchen</span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">Internet</span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">Wireless Internet</span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">Coffee Machine</span>     
    //                 </label>
    //             </div>
    //             <div className="col-md-6">
    //                 <label className="label-large label-inline amenity-label pos-rel">
    //                     <input type="checkbox" className="comint"  name="amenities"/>
    //                     <span className="comspn">Coffee Maker</span>     
    //                 </label>
    //             </div>
    //         </div>
    //     </div>
    // </div>
    }
}
export default AmenitiestList