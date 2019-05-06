import React from 'react'
import Axios from 'axios';
import dateFns from "date-fns";
import {Route , Link } from "react-router-dom";
import AuthorDetail from './AuthorDetail';
export default class BlogDetail extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            blog_detail : {},
            related_posts : []
        }
    }
    componentDidMount(){
        console.log()
        Axios.get(`/ajax/blog/detail/${this.props.match.params.blogID}`)
        .then(response =>{
            this.setState({
                blog_detail : response.data.post,
                related_posts : response.data.related_posts
            })
            console.log(response.data)
        })
    }
    render(){
        return <div className="col-lg-offset-2 col-md-offset-1 col-sm-offset-1">
      <div className="post_panel">
  <div className="itemContainer featured-post">
    <div className="zn_full_image hsize-320" style={{overflow: 'hidden'}}>
      <img src={this.state.blog_detail.image} className="img-responsive" alt={this.state.blog_detail.title} />
    </div>
  </div>
  <div className="text_panel">
    <div className="row">
      <div className="col-lg-1 col-md-1 hide-sm">
        <div className="date_single_post">
          <span className="day_publish"> 25 </span>
          <span className="month_publish"> Jun </span>
        </div>
      </div>
      <div className="col-lg-11 col-md-11 col-sm-8">
        <div className="post_title">
          <h3 className="title">
          {this.state.blog_detail.title}
          <span className="catItemDateCreated">
                          </span>
                      <span className="catItemAuthor">by <a href={`/blog/author/${this.state.blog_detail.author_id}`} title={this.state.blog_detail.author_name} rel="author">{this.state.blog_detail.author_name}</a></span>
            <span className="show-sm">
            {dateFns.format(dateFns.parse(this.state.blog_detail.publish_date), 'D')}
            {dateFns.format(dateFns.parse(this.state.blog_detail.publish_date), 'MMM')}
           
            </span>
          </h3>
        </div>
        <div className="post_footer">
          <span className="post_author">
            <i className="fa fa-user" />
            by <a href={`/blog/author/${this.state.blog_detail.author_id}`}>{this.state.blog_detail.author_name}</a>
          </span>
          {
            this.state.blog_detail.categories && this.state.blog_detail.categories.length ?  this.state.blog_detail.categories.map((category, index) =>{
                return  <span className="post_categories">
                <i className="fa fa-folder" />
                <a href={`/blog/category/${category.slug}`} >{category.name}{this.state.blog_detail.categories.length -1 != index ? ', ' : ''} </a>
              </span>
              
            })
            : null
                      }
         
        </div>
      </div>
    </div>
    <div className="single_post_container">
      <div className="row">
        <span className="single_post_content" dangerouslySetInnerHTML={{ __html : this.state.blog_detail.content }}></span>
      </div>
    </div>
  </div>
  <hr />
  {
      this.state.blog_detail.author_id && <AuthorDetail author_id = {this.state.blog_detail.author_id}/>
  }
  
  
   
</div>
</div>
    }
}