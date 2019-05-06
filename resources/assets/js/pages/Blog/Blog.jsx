import React from 'react'
import './blog.scss'
import {Route , Link } from "react-router-dom";
import Index from './pages/Index';
import Axios from 'axios';
import dateFns from "date-fns";
import BlogDetail from './pages/Detail';
import Category from './pages/Category';
import Tags from './pages/Tags';
import Author from './pages/Author';

export default class Blog extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            categories : [],
            featured : [],
            
            latest_listing : [],
            posts : [],
            tags : []
        }
    }
    componentDidMount(){
        Axios.get('/ajax/blog/index')
        .then(response =>{
            this.setState({
                categories : response.data.categories,
                featured : response.data.featured,
                last_featured : response.data.last_featured,
                latest_listing : response.data.latest_listing,
                posts : response.data.posts,
                tags : response.data.tags,
            })
        })
    }
    render(){
        return <div className="blog_panel  my-5">
        <div className="row">
          <div className="col-lg-8 col-md-11 col-sm-11 blog-section-pagination">
          <Route exact  path={`${this.props.match.url}`} component = {Index}/>
          <Route exact  path={`${this.props.match.url}/:blogID`} component = {BlogDetail}/>
          <Route exact  path={`${this.props.match.url}/category/:slug`} component = {Category}/>
          <Route exact  path={`${this.props.match.url}/tag/:slug`} component = {Tags}/>
          <Route exact  path={`${this.props.match.url}/author/:authorid`} component = {Author}/>
          </div>
          <div className="col-lg-3 col-md-11   col-sm-11  ">
            <div className="categories_side">
              <div className="categories_list_header">
                <span> CATEGORIES</span>
              </div>
              <div className="category_list">
              {
                  this.state.categories.map((category, index) =>{
                    return <div className="category_item" key={index}>
                    <span><i className="fa fa-angle-right" /> <a href={`/blog/category/${category.slug}`}>{category.name}</a></span>
                  </div>
                  })
              }
                
              </div>
            </div>
            <div className="featured_post_side">
              <div className="featured_post_header">
                <span> FEATURED POSTS </span>
              </div>
              {
                  this.state.featured.map((blog, index) =>{
                    return <div className="featured_list" key={index}>
                    <div className="slick_posts">
                      <div className="slick_posts_container">
                        <div className="row">
                          <div className="featured_post">
                            <div className="col-lg-3 col-md-3 col-sm-12">
                              <div className="featured_post_img_container ">
                                <a href={`/blog/${blog.id}`}> <img src={blog.image} className="img-responsive" alt="Post Image" /></a>
                              </div>
                            </div>
                            <div className="col-lg-9 col-md-9 col-sm-12">
                              <div className="featured_post_title">
                                <span><a href={`/blog/${blog.id}`}>{blog.title}</a></span>
                                <p> {dateFns.format(dateFns.parse(blog.publish_date), 'MMM D, YYYY')} </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  })
              }
               
            </div>
            <div className="featured_post_side">
              <div className="featured_post_header">
                <span> RECENT LISTINGS </span>
              </div>
              <div className="featured_list">
                <div className="slick_posts">
                  <div className="slick_posts_container">
                  {
                      this.state.latest_listing.map((listing, index) =>{
                        return <div className="row mt-2" key={index}>
                        <div className="featured_post">
                          <div className="col-lg-3 col-md-3 col-sm-12">
                            <div className="featured_post_img_container ">
                              <a href={`/homes/${listing.address_url}/${listing.id}`} target="_blank"> <img src={listing.featured_image} className="img-responsive" alt="Room Image" /></a>
                            </div>
                          </div>
                          <div className="col-lg-9 col-md-9 col-sm-12">
                            <div className="featured_post_title">
                              <span><a href={`/homes/${listing.address_url}/${listing.id}`} target="_blank">{listing.name}</a></span>
                              <p>{listing.sub_name}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      })
                  }
                    
                   </div> 
                   
                </div>
              </div>
            </div>
            <div className="tags_side">
              <div className="tags_post_header">
                <span> TAGS </span>
              </div>
              <div className="tags_list">
              {
                  this.state.tags.map((tag, index)=>{
                    return <span className="tag_item" key={index}><a href={`/blog/tag/${tag.slug}`}> {tag.name} </a></span>
                  })
              }
              </div>
            </div>
          </div>
        </div>
      </div>
    }
}