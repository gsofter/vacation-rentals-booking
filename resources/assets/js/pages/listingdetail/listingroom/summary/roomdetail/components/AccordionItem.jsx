import React from 'react'
class AccordionItem extends React.PureComponent {
    constructor() {
      super();
      this.state = {
        active: false
      };
      this.toggle = this.toggle.bind(this);
    }
    toggle() {
      this.setState({
        active: !this.state.active,
        className: "active"
      });
    }
    render() {
      const activeClass = this.state.active ? "active" : "inactive";
      const question = this.props.details;
      return (
              <div className={'row w-100' }>
                <div className="col-md-12 lang-chang-label col-sm-12 amenities_title"><a  onClick={this.toggle}>{question.title}</a></div>
                <div className={"col-md-12 col-sm-12 amenities_info " + activeClass}>{question.content}</div>
              </div>
      );
    }
  }
  export default AccordionItem