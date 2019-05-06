import React from 'react';
import { Link , Redirect} from 'react-router-dom';

import axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
class Publishbutton extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            is_redirect : false
        }
        this.handleDraft = this.handleDraft.bind(this)
        this.handlePublish = this.handlePublish.bind(this)
    }
    handlePublish(e) {
        //Unlisted
        var self = this
        axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/update_rooms`,
            { data: JSON.stringify({ status: 'Unlisted' }) })
            .then(res => {
                if(res.data.steps_count > 0){
                    toast.warn("You cannot publish this listing, Because you have to complte "+res.data.steps_count+"steps to publis yet.!", {
                    });
                }
                else{
                    console.log('ddd')
                    this.setState({
                        is_redirect : true
                    })
                    // location.href = `/rooms/${this.props.roomId}/subscribe_property`
                }
                
            })
    }
    handleDraft(e) {
        //Draft
        axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/update_rooms`,
        { data: JSON.stringify({ status: 'Draft' }) })
        .then(res => {  
            toast.success("Saved to draft!", {
                    });
            
        })
    }
    render() {
        if(this.state.is_redirect){

            return <Redirect to={`/rooms/${this.props.roomId}/subscribe_property`} />
        }
        return (
            <div className="calendar_savebuttons">
                <ToastContainer />
            
                <div className="col-md-12">
                <a href={`/rooms/manage-listing/${this.props.roomId}/terms`} className="right_save">Back
                </a>
                    <button className="right_save btn btn-primary" id="listing_draft_btn" onClick={this.handleDraft}>Draft</button>
                    {/* 4 is correspoding "No Subscription" plan */}
                    <button className="right_save btn btn-success" id="listing_publish_btn" onClick={this.handlePublish}>
                        Publish
                </button>
                </div>
            </div>
        )
    }
}

export default Publishbutton;