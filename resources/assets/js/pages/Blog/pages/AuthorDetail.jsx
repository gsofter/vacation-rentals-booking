import React from 'react'
import Axios from 'axios';

export default class AuthorDetail extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            author : {}
        }
    }
    componentDidMount(){
        Axios.get(`/ajax/blog/get_author_info/${this.props.author_id}`)
        .then(response =>{
            this.setState({
                author : response.data
            })
        })
    }
    render(){
        return <div className="author_info">
         <h3>Author</h3>
        <div className="row">
        <div className="col-lg-2 col-md-2 col-sm-12 col-12 text-center text-center-md">
              {this.state.author.profile_picture? <img src={this.state.author.profile_picture.src} className="mx-auto media-photo media-round user-profile-image d-block" style={{width: '100%'}} /> : null }
              <a href={`/blog/author/${this.state.author.id}`} className="d-block">{this.state.author.full_name}</a>
            </div>
            <div className="col-lg-10 col-md-10 col-sm-12">
            <div className="author_bio_container">
              <span className="author_bio" dangerouslySetInnerHTML={{ __html : this.state.author.about }}></span>
            </div>
          </div>
          <div className="author_photo_container">
            
          </div>
         
        </div>
      </div>
    }
}