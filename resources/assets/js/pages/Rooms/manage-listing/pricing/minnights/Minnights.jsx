import React from 'react';

class Minnights extends React.Component {
    constructor(props){
        super(props)
       
    }
    render(){
        
        return(
            <div className="base_priceamt">
                <div className="base_decs">
                <h4>Minimum nights of booking required:</h4>
                </div>
                <div className="base_text">
                    <div className="col-xl-6 col-lg-12 base_amut bottom_space clearfix">
                        <label className="h6">Enter minimum night</label>
                        <div className="base_pric">
                        <input type="number" value={this.props.value ? this.props.value : ''} onChange={this.props.onChange}   name="minimum_stay" className="autosubmit-text input-stem input-large"   />
                        </div>
                        <p data-error="minimum_stay" className="ml-error" />
                    </div>
                </div>
            </div>
        )
    }
}

export default Minnights;