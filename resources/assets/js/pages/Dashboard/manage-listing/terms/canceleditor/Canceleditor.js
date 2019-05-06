import React from 'react';
import MyStatefulEditor from '../../mystatefuleditor/MyStatefulEditor';

class Canceleditor extends React.Component {
    render(){
        return(
            <div className="base_priceamt">
        <div className="base_decs">
          <h3>Cancellation Policy</h3>
        </div>
        <div className="base_text_container">
          <div className="col-md-12 base_amut">
            <div id="cancellation-policy-select" className="row-space-2" style={{visibility: 'hidden', height: 0}}>
              <div className="base_select select">
                <select id="select-cancel_policy" name="cancel_policy" data-saving="additional-saving">
                  <option value>Select Cancellation Policy</option>
                  <option value="Flexible" selected>Flexible</option>
                  <option value="Moderate">Moderate</option>
                  <option value="Strict">Strict</option>
                </select>
              </div>
            </div>
            <label className="hidden-element">Cancellation Policy</label>
          </div>
          <div className="col-md-12 base_amut">
            <MyStatefulEditor/>
          </div>
        </div>
      </div>
        )
    }
}

export default Canceleditor;