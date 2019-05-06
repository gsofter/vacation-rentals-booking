import React from 'react'

class MenuItem extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        return <div className="row nav-item">
            <div className="col-sm-12 va-container">
                <span className="va-middle">{this.props.menu_text}
                </span>
                <div className="instant-book-status pull-right">
                <div className="instant-book-status__on hide">
                    <i className="icon icon-bolt icon-beach h3">
                    </i>
                </div>
                <div className="instant-book-status__off hide">
                    <i className="icon icon-bolt icon-light-gray h3">
                    </i>
                </div>
                </div>
                <div className="js-new-section-icon not-post-listed pull-right transition visible">
                <i className="nav-icon icon icon-add icon-grey">
                </i>
                </div>
                <div className="pull-right lang-left-change">
                <i className="nav-icon icon icon-ok-alt icon-babu not-post-listed hide">
                </i>
                <i className="dot dot-success hide">
                </i>
                </div>
            </div>
            </div>
    }
}

export default MenuItem