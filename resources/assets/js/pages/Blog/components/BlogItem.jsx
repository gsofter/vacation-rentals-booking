import React from 'react'
import dateFns from "date-fns";
import {Route , Link } from "react-router-dom";
class BlogItem extends React.PureComponent{
    render(){
        return  <div className="itemContainer">
          {/* Post header */}
          <div className="itemHeader">
            {/* Title */}
            <h3 className="itemTitle">
              <a href={`/blog/${this.props.blog.id}`} title={this.props.blog.title}>{this.props.blog.title}</a>
            </h3>
            {/*/ Title */}
            {/* Post details */}
            <div className="post_details">
              <span className="catItemDateCreated">
              {dateFns.format(dateFns.parse(this.props.blog.publish_date), 'MMM D, YYYY')} </span>
              <span className="catItemAuthor">by <a href={`/blog/author/${this.props.blog.author_id}`} title={this.props.blog.author_name} rel="author">{this.props.blog.author_name}</a></span>
            </div>
            {/* Post details */}
          </div>
          {/*/ Post header */}
          {/* Post content body*/}
          <div className="itemBody">
            {/* Item intro text */}
            <div className="itemIntroText">
              {/* Post image */}
              <div className="col-12 col-md-4">
                <div className="hg_post_image">
                  <a href={`/blog/${this.props.blog.id}`} className="pull-left" title={this.props.blog.title}>
                    <img src={this.props.blog.image} className="img-responsive" alt={this.props.blog.title} title={this.props.blog.title} />
                  </a>
                </div>
              </div>
              {/*/ Post image */}
              <div className="col-12 col-md-8">
                <p dangerouslySetInnerHTML={{ __html : this.props.blog.excerpt }}>
                
                </p>
                {/* Post category */}
                <ul className="itemLinks">
                  <li className="itemCategory">
                    <span className="glyphicon glyphicon-folder-close" />
                    <span>Published in </span>
                    {
                          this.props.blog.categories.map((category, index) =>{
                              return <a href={`/blog/category/${category.slug}`} title>{category.name}{this.props.blog.categories.length -1 != index ? ', ' : ''}</a>
                          })
                      }
                  </li>
                </ul>
                <div className="itemTagsBlock ml-3">
                  <div className="clear">
                  </div>
                </div>
                {/* end tags blocks */}
                {/*/ Post category */}
              </div>
              {/* end Item intro text */}
              <div className="clear" />
              {/* Item tags */}
              <div className="clearfix">
                {/* Read more button */}
                <div className="itemReadMore">
                  <a className="btn btn-fullcolor readMore" href={`/blog/${this.props.blog.id}`} title={`Read More ${this.props.blog.title} `}>Read more</a>
                </div>
                {/*/ Read more button */}
              </div>
              {/*/ Item tags */}
              <div className="clear" />
            </div>
          </div>
          {/*/ Post content body*/}
          <div className="clear" />
        </div>
       
        
    }
}

export default BlogItem