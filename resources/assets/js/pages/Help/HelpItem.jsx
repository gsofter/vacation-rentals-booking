import React from 'react'

class HelpItem extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            is_open : this.props.is_open
        }
        this.handleOpen = this.handleOpen.bind(this)
    }
    handleOpen(e){
        this.setState(
            {
                is_open : !this.state.is_open
            }
        )
    }
    render(){
        return(
            <li className={this.state.is_open ? 'open' : ' '}>
            <h3 className="accordion-title">
                <a href="javascript:;" onClick={this.handleOpen}><h1>{this.props.question} </h1><span className="pull-right"><i className={this.state.is_open ? 'fa fa-minus' : 'fa fa-plus'}></i></span> </a>
            </h3>
            <div className="accordion-content" style = { (this.state.is_open) ? { display : 'block' } : {display : 'none'}}>
              <p dangerouslySetInnerHTML={{   __html : this.props.answer }} ></p>
            </div>
          </li>
          
        )
    }
}

export default HelpItem