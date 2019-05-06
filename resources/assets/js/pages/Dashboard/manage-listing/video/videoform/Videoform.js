import React from 'react';

class Videoform extends React.Component {
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
                <input type="text" name="video" id="video" className="input-large ng-valid ng-touched ng-dirty ng-valid-parse" placeholder="YouTube URL"/>
                <p />
                <span style={{color: 'red', float: 'left', fontSize: 'smaller', margin: '0 0 10px 0'}}>Note*:Only Embed Video Ex:(https://youtu.be/IZXU_9pRabI)</span>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12  hide ">
                <a className="remove_rooms_video link-reset"style={{float: 'right', position: 'absolute', top: 47, right: 33, color: 'white', fontSize: 23, backgroundColor: '#f51f24'}}><i className="icon icon-trash" /></a>
                <iframe src="?showinfo=0" style={{width: '100%', height: 250}} id="rooms_video_preview" allowFullScreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" />
                </div>
            </div>
            </div>
        </form>
        )
    }
}

export default Videoform;