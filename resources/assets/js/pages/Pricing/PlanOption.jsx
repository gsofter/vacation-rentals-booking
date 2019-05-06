import React from 'react'
class PlanOption extends React.PureComponent{
    constructor(props){
        super(props)
        
    }
    render(){
        return <i className={this.props.active ? 'fa fa-check text-primary mr-3' : 'fa fa-times text-mute mr-3'}></i>
    }
}
export default PlanOption