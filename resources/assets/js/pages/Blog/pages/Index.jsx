import React from 'react'
import Axios from 'axios';
import dateFns from "date-fns";
import {Route , Link } from "react-router-dom";
import BlogItem from '../components/BlogItem';
export default class Index extends React.PureComponent{
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
        return <div className="col-lg-offset-2 col-md-offset-1 col-sm-offset-1">
        <div className="itemListView clearfix eBlog">
          <div className="itemList blog-item-pagination">
            {/* Blog item container */}
            {
                this.state.last_featured && (
                    <div className="itemContainer featured-post">
              {/* Post image */}
              <div className="zn_full_image" style={{backgroundImage: `url(${this.state.last_featured.image})`}} />
              {/*/ Post image */}
              {/* Post content */}
              <div className="itemFeatContent">
                <div className="itemFeatContent-inner">
                  {/* Post header */}
                  <div className="itemHeader">
                    {/* Title */}
                    <h3 className="itemTitle">
                      <a href={`/blog/${this.state.last_featured.id}`} title={this.state.last_featured.title}>{this.state.last_featured.title}</a>
                    </h3>
                    {/*/ Title */}
                    {/* Post details */}
                    <div className="post_details">
                      <span className="catItemDateCreated">
                        {dateFns.format(dateFns.parse(this.state.last_featured.publish_date), 'MMM D, YYYY')}  </span>
                      <span className="catItemAuthor">by <a href={`/blog/author/${this.state.last_featured.author_id}`} title={this.state.last_featured.author_name} rel="author">{this.state.last_featured.author_name}</a></span>
                    </div>
                    {/*/ Post details */}
                  </div>
                  {/*/ Post header */}
                  {/* Post category */}
                  <ul className="itemLinks clearfix">
                    <li className="itemCategory">
                      <span className="glyphicon glyphicon-folder-close" />
                      <span>Published in</span>
                      {
                          this.state.last_featured.categories.map((category, index) =>{
                              return <a href={`/blog/category/${category.slug}`} className='pl-2'>{category.name}{this.state.last_featured.categories.length -1 != index ? ', ' : ''}</a>
                          })
                      }
                    </li>
                  </ul>
                  {/* Post category */}
                  {/* Post comments */}
                  <div className="clearfix">
                  </div>
                </div>
                {/*/ .itemFeatContent-inner */}
              </div>
              {/*/ Post content */}
            </div>
            
                )
            }
           
            {
               this.state.posts.data &&  this.state.posts.data.map((blog,index)=>{
                    return <BlogItem key={index} blog={blog}/>
                })
            }
          </div>
        </div>
      </div>
      
    }
}