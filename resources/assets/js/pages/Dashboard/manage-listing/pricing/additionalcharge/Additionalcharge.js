import React from 'react';

class Additionalcharge extends React.Component {
    render(){
        return(
            <div className="base_priceamt">
                <div className="input-group control-group after-add-more-additional_charge">
                <p data-error="additional_charge" className="ml-error hide">There is a empty charge name or charge fee.</p>
                <input type="hidden" defaultValue={11502} name="room_id" />
                </div>
                <div className="input-group-btn rjaddcharge">
                <button id="save_additional_charge" className="btn btn-success add-more-additional_charge1" type="button">+ Add additional charges</button>
                </div>
            </div>
        )
    }
}

export default Additionalcharge;