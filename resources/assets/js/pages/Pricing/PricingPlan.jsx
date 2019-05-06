import React from 'react'
import Header from '../../common/header/Header'
import Footer from '../../common/footer/Footer'
import PlanContainer  from './PlanContainer'
import Banner from './Banner';
class PricingPlan extends React.PureComponent{
    constructor(props){
        super(props)
    }
    componentDidMount(){
       
    }
    render(){
        let planId = this.props.match.params.planId
        console.log(planId)
        return <div>
        <Header/>
            <Banner/>
            <PlanContainer planId={planId}/>
        <Footer/>
    </div>
    }
}
export default PricingPlan