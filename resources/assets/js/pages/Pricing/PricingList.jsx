import React from 'react'

class PricingList extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        return (
                <tr className="compare-row">
                    <td>{this.props.title}</td>
                    {
                        this.props.types.map((type, index) => {
                            return  <td><span className="tickblue" key={index}>{type[this.props.attribute] ? '✔' : '-'}</span></td>
                        })
                    }
                    
                </tr>)
    }
}
export default PricingList