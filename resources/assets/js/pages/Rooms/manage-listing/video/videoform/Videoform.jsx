import React from 'react';
import axios from 'axios'
class Videoform extends React.Component {
    constructor(props){
        super(props)
        this.state = {
            video_url : ''
        }
        this.handleInputURL = this.handleInputURL.bind(this)
    }
    componentDidMount(){
        axios.get(`/ajax/manage_listing/${this.props.roomId}/get_videoUrl`)
        .then(res => {
            this.setState({
                video_url : res.data.url
            })
        })
    }
    handleInputURL(e){
        let value = e.target.value;
        axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/update_rooms`, 
        {  data : JSON.stringify({video : value}) })
        .then( res => {
            if(res.data.success == 'true'){
                this.setState({
                    video_url : res.data.video
                })
            }
        })
    }
    render(){
        return(
            <form name="overview" className="ng-valid ng-dirty ng-valid-parse">
            <div className="js-section">
            <div className="js-saving-progress saving-progress" style={{display: 'none'}}>
                <h5>Saving...</h5>
            </div>
            <div className="js-saving-progress icon-rausch error-value-required row-space-top-1" style={{float: 'right', display: 'block'}}>
                <h5>Please Enter a Valid URL</h5>
            </div>
            <div className="row-space-2 clearfix" id="help-panel-video" ng-init="video=''">
                <div className="row row-space-top-2">
                <div className="col-4">
                    <label className="label-large">YouTube URL</label>
                </div>
                </div>
                <input type="text" name="video" id="video" className="input-large" placeholder="YouTube URL" onChange={this.handleInputURL}/>
                <p />
                <span style={{color: 'red', float: 'left', fontSize: 'smaller', margin: '0 0 10px 0'}}>Note*:Only Embed Video Ex:(https://youtu.be/IZXU_9pRabI)</span>
            </div>
            <br />
            <div className="row">
                <div className={this.state.video_url !='' ? "col-md-12   " : "col-md-12  hide " }>
                <a className="remove_rooms_video link-reset"style={{float: 'right', position: 'absolute', top: 47, right: 33, color: 'white', fontSize: 23, backgroundColor: '#f51f24'}}><i className="icon icon-trash" /></a>
                <iframe src={this.state.video_url} style={{width: '100%', height: 250}} id="rooms_video_preview" allowFullScreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" />
                </div>
            </div>
            </div>
        </form>
        )
    }
}

export default Videoform;