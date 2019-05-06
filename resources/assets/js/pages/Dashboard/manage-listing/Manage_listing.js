import React from 'react';
import './manage_listing.css'
import Submenu from './submenu/Submenu';
// import Sidebar from './sidebar/Sidebar';
import Subfooter from './subfooter/Subfooter';
// import Header from '../components/Header/Header'
import Header from '../../../common/header/Header'
import Sidebar from './Sidebar'
import Footer from '../../../common/footer/Footer';
class Manage_listing extends React.Component {
    constructor(props){
        super(props)
        console.log('Hello',this.props)
    }
    render(){
        return(
            <div className="body">
               <Header/>
               <Submenu/>
               <div className="manage-listing-row-container">
                    <Sidebar base_url={`${this.props.match.params.roomId}`}/>
                </div>
                <Footer/>
               </div>
        );
    }
}

export default Manage_listing;