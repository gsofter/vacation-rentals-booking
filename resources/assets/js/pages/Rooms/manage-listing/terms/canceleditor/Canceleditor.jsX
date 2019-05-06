import React from 'react';
import MyStatefulEditor from '../../mystatefuleditor/MyStatefulEditor';
import { connect } from 'react-redux'
import { renderSidebarAction, renderStopSidebarAction } from '../../../../../actions/managelisting/renderSidebarAction'
class Canceleditor extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      cancel_message: ''
    }
    this.onChange = this.onChange.bind(this)
  }
  componentDidMount() {
    axios.get(`/ajax/manage_listing/${this.props.roomId}/get_cancel_message`)
      .then(res => {
        this.setState({
          cancel_message: res.data.cancel_message
        })
      })
  }
  onChange(value) {
    axios.post(`/ajax/rooms/manage-listing/${this.props.roomId}/update_rooms`,
      { data: JSON.stringify({ cancel_message: value }) })
      .then(res => {
        if (res.data.success == 'true') {
          this.setState({
            cancel_message: value
          }, () => {
            !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
          })
        }
      })
  }
  render() {
    return (
      <div className="base_priceamt row">
        <div className="base_decs col-12">
          <h3>Cancellation Policy</h3>
        </div>
        <div className="base_text_container col-12">

          <div className="col-md-12 base_amut">
            <MyStatefulEditor value={this.state.cancel_message} onChange={this.onChange} />
          </div>
        </div>
      </div>
    )
  }
}


const mapStateToProps = state => ({
  ...state
})
const mapDispatchToProps = dispatch => ({
  renderSidebarAction: () => dispatch(renderSidebarAction),
  renderStopSidebarAction: () => dispatch(renderStopSidebarAction)
})

export default connect(mapStateToProps, mapDispatchToProps)(Canceleditor)