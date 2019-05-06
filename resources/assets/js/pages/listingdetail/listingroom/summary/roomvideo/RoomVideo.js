import React from 'react';

class RoomVideo extends React.PureComponent {
    constructor(props){
        super(props);
    }

    render(){
        return  this.props.video_url ? 
                    <div className="row-space-2">
                    <iframe width="100%" height="300" src={this.props.video_url} allowFullScreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"></iframe>
                    </div>
                    :
                    <div></div>
            
            
        
    }
}

export default RoomVideo;