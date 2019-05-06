import React from 'react'
import Axios from 'axios';
import dateFns from 'date-fns'
import {Route , Link } from "react-router-dom";
class Category extends React.PureComponent{
    constructor(props){
        super(props)
        this.state = {
            blog_list : [],
            category : {}
        }
    }
    componentDidMount(){
        
        Axios.get(`/ajax/blog/category/${this.props.match.params.slug}`)
        .then(response =>{
            this.setState({
                blog_list : response.data.posts,
                category : response.data.category
            })
        })
    }
    componentWillReceiveProps(nextprops){
        Axios.get(`/ajax/blog/category/${nextprops.match.params.slug}`)
        .then(response =>{
            this.setState({
                blog_list : response.data.posts,
                category : response.data.category
            })
        })
    }
    render(){
        return <div className="col-lg-offset-2 col-md-offset-1 col-sm-offset-1">
        <div className="itemListView clearfix eBlog">
          <div className="itemList blog-item-pagination">
            {
                this.state.blog_list.length ? 
                this.state.blog_list.map((blog, index) =>{
                    return <div className="itemContainer" key={index}>
                    <div className="itemHeader">
                      <h3 className="itemTitle">
                        <a href="#" title={blog.title}>{blog.title}</a>
                      </h3>
                      <div className="post_details">
                        <span className="catItemDateCreated">
                        {dateFns.format(dateFns.parse(blog.publish_date), 'MMM D, YYYY')} </span>
                        <span className="catItemAuthor">by <a href="#" title={"Posts by " + blog.author_name} rel="author">{blog.author_name}</a></span>
                      </div>
                    </div>
                    <div className="itemBody">
                      <div className="itemIntroText">
                        <div className="col-12 col-md-4">
                          <div className="hg_post_image">
                            <a href="#" className="pull-left" title={blog.title}>
                              <img src={blog.image} className="img-responsive" alt={blog.title} title={blog.title} />
                            </a>
                          </div>
                        </div>
                        <div className="col-12 col-md-8">
                          <p>
                            {blog.excerpt}
                          </p>
                          <ul className="itemLinks">
                            <li className="itemCategory">
                              <span className="glyphicon glyphicon-folder-close" />
                              <span>Published in</span>
                              {
                                  blog.categories.map((category, index) =>{
                                    return <a href={`/blog/category/${category.slug}`} className='pl-2'>{category.name}{blog.categories.length -1 != index ? ', ' : ''}</a>
                                  })
                              }
                              
                              
                            </li>
                          </ul>
                          <div className="itemTagsBlock ml-3">
                            <div className="clear">
                            </div>
                          </div>
                        </div>
                        <div className="clear" />
                        <div className="clearfix">
                          <div className="itemReadMore">
                            <a className="btn btn-fullcolor readMore" href={`/blog/${blog.id}`} title="Read More {blog.title} ">Read more</a>
                          </div>
                        </div>
                        <div className="clear" />
                      </div>
                    </div>
                    <div className="clear" />
                  </div>
                  
                })
                :
                <div>No blogs for {this.state.category.name}</div>
            }
           </div>
        </div>
      </div>
      
    }
}

export default Category