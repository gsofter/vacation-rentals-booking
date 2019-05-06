import React from 'react'
import StarRatingComponent from 'react-star-rating-component';
class StarRating extends React.PureComponent {
    constructor(props) {
        super(props)
        this.state = {
            rating: 0
        };
        this.onStarClick = this.onStarClick.bind(this)
    }
    onStarClick(nextValue, prevValue, name) {
        console.log(nextValue)
        this.setState({ rating: nextValue });
        
    }
    render() {
        return <div className="form-group clearfix">
            <label className="rating_type">{this.props.labelName}</label>
            <div className="rating_container">
                <StarRatingComponent
                    name={this.props.name}
                    starCount={this.props.starCount}
                    value={this.props.rating}
                    onStarClick={(nextValue) => this.props.onChange(nextValue)}
                />
            </div>


            <p className="text-muted fs-small clearfix">{this.props.description}</p>
        </div>
    }
}
export default StarRating