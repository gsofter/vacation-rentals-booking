import React from 'react';

class SubNav extends React.PureComponent {
    constructor(props){
        super(props);
    }

    render(){
        return(
            <div className="subnav-container hide-sm">
                <div data-sticky="true" data-transition-at="#summary" aria-hidden="true" className="subnav section-titles">
                <div className="page-container-responsive p-0">
                    <ul className="subnav-list">
                    <li>
                        <a href="#jssor_1" aria-selected="true" className="subnav-item"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                            Photos
                            </font></font></a>
                    </li>
                    <li>
                        <a href="#summary" className="subnav-item" data-extra="#summary-extend" aria-selected="false"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                            About this listing
                            </font></font></a>
                    </li>
                    <li>
                        <a href="#reviews" className="subnav-item" aria-selected="false"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                            Reviews
                            </font></font></a>
                    </li>
                    <li>
                        <a href="#host-profile" className="subnav-item" aria-selected="false"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                            The Host
                            </font></font></a>
                    </li>
                    <li>
                        <a href="#neighborhood" className="subnav-item" aria-selected="false"><font style={{verticalAlign: 'inherit'}}><font style={{verticalAlign: 'inherit'}}>
                            Location
                            </font></font></a>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
        );
    }
}

export default SubNav;