import React from 'react'
import axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
class Photos extends React.Component {

  constructor(props) {
    super(props)
    this.state = {
      userinfo: {
        first_name: '',
        last_name: ''
      },
      page_data: {}

    }
    this.uploadPhoto = this.uploadPhoto.bind(this)
  }
  componentDidMount() {
    fetch('/ajax/dashboard/index')
      .then(response => response.json())
      .then(data => {
        console.log(data)
        this.setState({
          userinfo: data.user_info,
          page_data: data.data
        })
      });
  }
  uploadPhoto(e) {
    const file = event.target.files[0]
    const formData = new FormData()
    formData.append('myFile', file, file.name)
    axios.post('/ajax/profilepictureupload', formData)
      .then(Response => {
        let { page_data } = this.state;
        page_data.profile_pic = Response.data.file_url
        toast.success('Profile Image Uploaded', {
          position: toast.POSITION.TOP_CENTER
        });
        this.setState({
          page_data: page_data
        })
        console.log(Response.data.file_url)
      })
  }
  render() {
    let { userinfo, page_data } = this.state

    return (
      <div className="col-md-9">
      <ToastContainer/>
      <div className="aside-main-content">
        <div className="side-cnt">
          <div className="head-label">
            <h4>Profile Photo</h4>
          </div>
          <div className="aside-main-cn">
            <div className="photo-profile_">
              <div className="form-wrapper">
                <form name="ajax_upload_form" method="post" id="ajax_upload_form"  className="form" encType="multipart/form-data">
                  <div className="user-profile">
                    <img src={page_data.profile_pic} className="img-responsive" alt="profile" />
                  </div>
                  <div className="small-info">
                    <p>Part of the trust factor is clearly identifying who you are to
                      your guests. A clear photo of yourself is a great way to start
                      the process</p>
                    <div className="file">
                      <input type="file" name="file" id="file"  onChange={this.uploadPhoto}/>
                      <label htmlFor="file" className="btn btn-outline-primary">Upload your
                        image <i className="far fa-image fa-2x" /></label>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      </div>
    )
  }
}
export default Photos