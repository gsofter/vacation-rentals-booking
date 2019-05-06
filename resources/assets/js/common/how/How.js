import React from 'react';
// import how1 from '<img src="https://arimitin.sirv.com/Images/new/how1.png" width="130" height="130" alt="" />';
// import how2 from './img/how2.png';
// import how3 from './img/how3.png';
// import how4 from './img/how4.png';
import './how.css';
import Masks from '../../components/ui_elements/Masks';

class How extends React.PureComponent {
    render(){
        return(
            <section className="how_it_works white_bg text-center mb-0 pt-70 pb-70 ">
			
				<div className="page-container-responsive page-container-no-padding">
					<div className="top_text_wrap">
						<div className="section-intro">
							<h2>How it works </h2>
						</div>
						<div className="how_it_sect col-lg-3 col-md-6 col-sm-12">
							<img src="https://res.cloudinary.com/vacation-rentals/image/upload/c_fill,fl_lossy,q_auto:low,w_130,h_130/v1555703591/images/how1.png" width="130" height="130" alt="" />
							<h3>Search</h3>
							<p>Search for the perfect vacation home for rent from our verified listings</p>
						</div>
						<div className="how_it_sect col-lg-3 col-md-6 col-sm-12">
							<img src="https://res.cloudinary.com/vacation-rentals/image/upload/c_fill,fl_lossy,q_auto:low,w_130,h_130/v1555703592/images/how2.png" width="130" height="130" alt="" />
							<h3>Make an inquiry</h3>
							<p>Contact the owner or property manager directly</p>
						</div>
						<div className="how_it_sect col-lg-3 col-md-6 col-sm-12">
							<img src="https://res.cloudinary.com/vacation-rentals/image/upload/c_fill,fl_lossy,q_auto:low,w_130,h_130/v1555703592/images/how3.png" width="130" height="130" alt="" />
							<h3>Make the booking</h3>
							<p>Once you have settled on the home of your choice, book direct with the homeowner or property manager</p>
						</div>
						<div className="how_it_sect col-lg-3 col-md-6 col-sm-12">
							<img src="https://res.cloudinary.com/vacation-rentals/image/upload/c_fill,fl_lossy,q_auto:low,w_130,h_130/v1555703592/images/how4.png" width="130" height="130" alt="" />
							<h3>Review your stay</h3>
							<p>Tell others about the great trip you had and place you stayed</p>
						</div>
					</div>
				</div>
				<Masks style='2'/>
			</section>
        )
    }
}

export default How;