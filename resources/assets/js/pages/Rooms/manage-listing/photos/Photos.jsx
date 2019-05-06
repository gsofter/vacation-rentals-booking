import React from 'react';
import Photostitle from './photostitle/Photostitle';
import property_help from '../img/property-help.png';
import Photosbutton from './photosbutton/Photosbutton';
import FileUploadProgress from 'react-fileupload-progress';
import './photos.css'
import {
    SortableContainer,
    SortableElement,
    arrayMove,
} from 'react-sortable-hoc';
import PhotoItem from './PhotoItem';
const SortableItem = SortableElement(({ value, removeHandler }) =>{
    
return <PhotoItem value = {value} removeHandler = {removeHandler}/>
} );
const SortableList = SortableContainer(({ items , highlightHandler, featureHandler, removeHandler}) => {
    
    return (
        <ul id="js-photo-grid" className="row list-unstyled all-slides d-flex flex-wrap ui-sortable">
            {items.map((value, index) => (
                <SortableItem key={`item-${index}`} index={index} value={value} highlightHandler = {highlightHandler} featureHandler = {featureHandler} removeHandler = {removeHandler} />
            ))}
        </ul>
    );
});
class Photos extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            photo_list: []
        }
        this.customFormRenderer = this.customFormRenderer.bind(this)
        this.featureImage = this.featureImage.bind(this)
        this.changeHighlight = this.changeHighlight.bind(this)
        this.removeImage = this.removeImage.bind(this)
        this.onSortEnd = this.onSortEnd.bind(this)
    }
    componentDidMount() {
        axios.get(`/ajax/manage-listing/${this.props.match.params.roomId}/photos_list`)
            .then(res => {
                console.log(res)
                this.setState({
                    photo_list: res.data
                })
            })
            let active_lists = document.getElementsByClassName('nav-active')
            for (let i = 0; i < active_lists.length; i++) {
                active_lists[i].classList.remove("nav-active");
            }
            let room_step = 'photos'
            let current_lists = document.getElementsByClassName(`nav-${room_step}`)
            for (let i = 0; i < current_lists.length; i++) {
                current_lists[i].classList.add('nav-active')
                    // active_lists[i].classList.remove("nav-active");
            }
    }
    formGetter() {
        return new FormData(document.getElementById('customForm'));
    }
    customFormRenderer(onSubmit) {
        return <form id='customForm' style={{ marginBottom: '15px', display : 'unset'}} encType="multipart/form-data" method='post' >
            <div id="js-photos-grid" className="photo-encourage">
                <div className="row row-table">
                    <div className="col-12 col-sm-12 col-md-4">
                        <div className="add-photos-button w-100 text-center">
                            <button id="photo-uploader" className="btn text-center btn-large row-space-2" style={{ position: 'relative', zIndex: 0 }}>
                                <i className="flaticon-camera light-gray fs-44 fw-normal" />
                                <span className="photosnote">Minimum 1 photo required <b className="requiredRJ">*</b> <br /> Max Filesize = 5MB <br /></span>
                            </button>
                            <div id="fileupload-progress-container" className="upload-progress">
                                <div className="progressbar_container">
                                </div>
                            </div>
                            {/* <input style={{display: 'block'}} type="file" name='file' id="exampleInputFile" /> */}
                            <input id="fileupload" className="fileupload" type="file" name="photos[]" multiple onChange={onSubmit} />
                        </div>
                        <br />
                    </div>
                    <div className="h4 text-right col-sm-12 text-muted" id="photo_count" ng-show="photos_list.length > 0" style={{ display: 'block' }}>
                        <small className="ng-binding">{this.state.photo_list.length} photo<span ng-show="photos_list.length > 1"  >s</span></small>
                    </div>
                </div>
            </div>
        </form>

    }
    featureImage(photo_id) {
        axios.post(`/ajax/manage-listing/featured_image`, { id: this.props.match.params.roomId, photo_id: photo_id })
            .then(res => {
                console.log(res)
                this.setState({
                    photo_list: res.data
                })
            })
    }
    removeImage(photo_id) {
        axios.post(`/ajax/manage-listing/${this.props.match.params.roomId}/delete_photo`, { photo_id: photo_id })
            .then(res => {
                let photo_list = this.state.photo_list
                let photo_index = photo_list.findIndex((photo) => {
                    console.log(photo)
                    return photo.id == photo_id
                })
                console.log(photo_index)

                if (photo_index > -1) {
                    photo_list.splice(photo_index, 1)
                    this.setState({
                        photo_list: photo_list
                    })
                }


            })
    }
    changeHighlight(event, photo_id) {
        let value = event.target.value

        axios.post(`/ajax/manage-listing/photo_highlights`, { data: value, photo_id: photo_id })
            .then(res => {
                console.log(res)

            })
    }
    onSortEnd({ oldIndex, newIndex }) {
        console.log(oldIndex, newIndex)
        this.setState({
            photo_list: arrayMove(this.state.photo_list, oldIndex, newIndex)
        }, ()=> {
            //change_photo_order
            let image_ids = this.state.photo_list.map((listing) => {
                return listing.id
            })
            axios.post(`/ajax/manage-listing/change_photo_order`, { id: this.props.match.params.roomId, image_id: image_ids })
            .then(res => {
                // console.log(res)
                this.featureImage(this.state.photo_list[0].id)
            })
            // console.log(this.state.photo_list[0])
           
        })
    };
    render() {
        
        let token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
            console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
        return (
            <div className="manage-listing-content-wrapper clearfix">
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Photostitle roomId={this.props.match.params.roomId} />

                        <FileUploadProgress key='ex1' url={`/ajax/rooms/add_photos/${this.props.match.params.roomId}`}
                            onProgress={(e, request, progress) => { console.log('progress', e, request, progress); }}
                            onLoad={(e, request) => {
                                let result = JSON.parse(request.response)
                                this.setState({
                                    photo_list: result.succresult
                                })
                            }}
                            onError={(e, request) => { console.log('error', e, request); }}
                            onAbort={(e, request) => { console.log('abort', e, request); }}
                            formGetter={this.formGetter.bind(this)}
                            formRenderer={this.customFormRenderer.bind(this)}
                        />
                        <SortableList distance = {1} items={this.state.photo_list} onSortEnd={this.onSortEnd} axis='xy' highlightHandler = {this.highlightHandler}   removeHandler = {this.removeImage} />
                        <Photosbutton roomId={this.props.match.params.roomId} />
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                        <img src={property_help} alt="property-help" className="col-center" width="75" height="75" />
                        <div className="amenities_about">
                            <h4>Guests Love Photos</h4>
                            <p>We recommend using good quality landscape oriented photos (3:2 or 4:3 aspect ratio recommended).</p>
                            <p>Include a few well-lit photos.</p>
                            <p>Cell phone photos are just fine.</p>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Photos;