import React from 'react'

class PhotoItem extends React.Component{
    constructor(props){
        super(props)
        this.changeHighlight = this.changeHighlight.bind(this)
        // this.removeImage = this.removeImage.bind(this)
    }
    changeHighlight(event, photo_id) {
        let value = event.target.value

        axios.post(`/ajax/manage-listing/photo_highlights`, { data: value, photo_id: photo_id })
            .then(res => {
                console.log(res)
            })
    }
    render(){
        let value = this.props.value
        return <li className="col-12 col-lg-4 col-md-6 row-space-4 photo-item-container photo_drag_item slide " style={{ display: 'list-item' }}  >
        <div className="panel photo-item">
            {/* <div className="featured-photo-ribbon" data-toggle="tooltip" data-placement="top" title="Set as featured photo">
                <i className="icon icon-heart-alt icon-light-gray" style={{ fontSize: '29px', color: '#fafafa' }} />
                <i className={value.featured == 'Yes' ? 'icon icon-heart icon-rausch' : 'icon icon-heart '} style={{ position: 'absolute', top: '2px', left: '2px' }} />
            </div> */}
            <div className="photo-size photo-drag-target js-photo-link" id="photo-79130" />
            <a className="media-photo media-photo-block text-center photo-size" href="#">
                <img className="img-responsive-height" src={value.name} />
            </a>
            <button className="  overlay-btn js-delete-photo-btn" onClick={() => this.props.removeHandler(value.id)} distance = {1} >
                <i className="fa fa-trash" />
            </button>
            <div className="panel-body panel-condensed">
                <textarea cols={1} rows={3} placeholder="What are the highlights of this photo?" className="input-large input highlights " tabIndex={1} defaultValue={value.highlights} onChange={(event) => this.changeHighlight(event, value.id)} />
                <p className="ml-error ng-binding" />
            </div>
        </div>
        </li>
    }
}
export default PhotoItem