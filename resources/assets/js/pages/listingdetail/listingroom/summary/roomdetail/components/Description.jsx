import React from 'react'

class Description extends React.PureComponent{
    constructor(props){
        super(props)
    }
    render(){
        let description_result = []
        for (var jj in this.props.rooms_description){
            if(jj == 'access' || jj == 'interaction'  || jj == 'neighborhood_overview'  || jj == 'transit' || jj == 'notes' || jj == 'house_rule') description_result.push(
                <div key={jj}>
                <p><strong>{jj}</strong></p>
                        <p dangerouslySetInnerHTML={{ __html : this.props.rooms_description[jj] }}></p>
                        <hr></hr>
                </div>
            )
        }
        return  description_result 
    }
}
export default Description