import React from 'react';
import SmartGallery from 'react-smart-gallery';
import Lightbox from 'react-images';
class Photo extends React.PureComponent {
    constructor(props){
        super(props);
        this.state = { currentImage: 0 , gallery_loaded : false};
        this.closeLightbox = this.closeLightbox.bind(this);
        this.openLightbox = this.openLightbox.bind(this);
        this.gotoNext = this.gotoNext.bind(this);
        this.gotoPrevious = this.gotoPrevious.bind(this);
        this.onImageSelect = this.onImageSelect.bind(this);
        this.onclickThumbname = this.onclickThumbname.bind(this);
    }
    onclickThumbname(index){
      this.setState({
        currentImage: index,
        lightboxIsOpen: true,
      });
    }
    openLightbox(event, obj) {
        this.setState({
          currentImage: obj.index,
          lightboxIsOpen: true,
        });
      }
      closeLightbox() {
        this.setState({
          currentImage: 0,
          lightboxIsOpen: false,
        });
      }
      gotoPrevious() {
        this.setState({
          currentImage: this.state.currentImage - 1,
        });
      }
      gotoNext() {
        this.setState({
          currentImage: this.state.currentImage + 1,
        });
      }
      onImageSelect(event, src, index){
        this.setState({
            currentImage: index,
            lightboxIsOpen: true,
          });
      }
    render() {
        let photolist = this.props.photos ? this.props.photos : []

        let images = photolist.map((photo) =>{
            return  photo.name 
        })
        let images_1 = photolist.map((photo) =>{
            return  { src: photo.slide_image_name, width: 4, height: 3, caption : photo.highlights , thumbnail : photo.listing_image_name}
        })
        // let thumb_images = photolist.map((photo) => {
        //   return {src : photo.listing_image_name}
        // })
        return (
            <div>
              {this.state.gallery_loaded == false }           
               <SmartGallery width={'100%'} height={400} images={images} onImageSelect={this.onImageSelect}
              />
              <Lightbox images={images_1}
                onClose={this.closeLightbox}
                onClickPrev={this.gotoPrevious}
                onClickNext={this.gotoNext}
                currentImage={this.state.currentImage}
                isOpen={this.state.lightboxIsOpen}
                showThumbnails={true}
                onClickThumbnail={this.onclickThumbname}
                backdropClosesModal={true}
              />
                  {/* <FbImageLibrary images={images}/>   */}
            </div>
        );
    }
}

export default Photo;