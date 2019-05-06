import React from 'react'
 
import Container from './Pricingpage'
import Banner from './Banner';
class Pricing extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        return <div>
            {/* <Header/> */}
                <Banner/>
                <Container/>
            {/* <Footer/> */}
        </div>
    }
}

export default Pricing