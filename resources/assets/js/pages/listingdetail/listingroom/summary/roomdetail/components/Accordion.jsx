import React from 'react'

import AccordionItem from './AccordionItem';
import './accordion.scss'
class Accordion extends React.PureComponent{
    constructor() {
        super();
       
        this.renderQuestion = this.renderQuestion.bind(this);
      }
      renderQuestion(key) {
        return <div className='row col-12 pb-3' key={key}><AccordionItem key={key} index={key} details={this.props.data[key]} /> </div>
      }
      render() {
        return(
          <div>
            {Object.keys(this.props.data).map(this.renderQuestion)} 
           
          </div>    
        )
      }
}
export default Accordion