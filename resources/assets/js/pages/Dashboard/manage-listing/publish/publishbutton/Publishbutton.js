import React from 'react';

class Publishbutton extends React.Component {
    render(){
        return(
            <div className="calendar_savebuttons">
                <div className="col-md-6 text-left">
                <a data-prevent-default href="https://www.vacation.rentals/manage-listing/11504/terms" className="right_save">Back
                </a>
                </div>
                <div className="col-md-6">
                <button className="right_save btn btn-primary" id="listing_draft_btn">Draft</button>
                {/* 4 is correspoding "No Subscription" plan */}
                <button className="right_save btn btn-success" id="listing_publish_btn">
                    Publish
                </button>
                </div>
            </div>
        )
    }
}

export default Publishbutton;