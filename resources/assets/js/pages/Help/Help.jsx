import React from 'react'
import HelpItem from './HelpItem'
import axios from 'axios'
import HelpBanner from './HelpBanner'
class Help extends React.PureComponent {
  constructor(props) {
    super(props)
    this.state = {
      query: '',
      searchResult: [],
      showSearchResult: false,
      categories: [],
      active_questions: [],
      active_category: 0,
      active_subcgory : 0,
      active_question : 0
    }
    this.handleQueryInput = this.handleQueryInput.bind(this)
    this.HandleSelectQuestion = this.HandleSelectQuestion.bind(this)
    this.handleSelectCategory = this.handleSelectCategory.bind(this)
    this.handleSelectSubcategory = this.handleSelectSubcategory.bind(this)
  }

  componentDidMount() {
    axios.post('/ajax/getHelpListByCategory')
      .then(response => {
        console.log(response)
        this.setState({
          categories: response.data
        })
      })
      .catch(error => {
        console.log(error)
      })
  }
  handleQueryInput(e) {
    e.preventDefault();
    let target = e.target;
    let value = target.value;
    if(value != ''){
      const query = {
        query: value
      }
      axios.post('/ajax/helpSearch', query)
        .then(response => {
          console.log(response)
          this.setState({
            searchResult: response.data,
            showSearchResult: true
          })
        })
        .catch(error => {
          console.log(error)
        })
      this.setState({
        query: value,
      })
    }
    else{
      this.setState({
        query: value,
        showSearchResult: false
      })
    }
    
  }
  HandleSearch(e) {
    e.preventDefault();
    console.log('Hello')
  }
  HandleSelectQuestion(question) {
    console.log(question)
    
        let category_index = this.state.categories.findIndex((category) => {
          return category.category_id == question.category_id
        })
        
        if(category_index != -1){
          let subcategory_index = this.state.categories[category_index].subcategories.findIndex((sub_category) => {
            return sub_category.sub_category_id == question.subcategory_id
          })
          console.log(subcategory_index)
          if(subcategory_index != -1){
            this.setState({
              query: question.question,
              showSearchResult: false,
              active_category : category_index,
              active_subcgory: subcategory_index,
              active_question: question.id
            })
          }

        }

        
      
  }
  handleSelectCategory(category_index) {
    console.log(category_index)
        this.setState({
          active_category: category_index,
          active_subcgory : 0,
          active_question : 0,
        })
  }
  handleSelectSubcategory(sub_index) {
    this.setState({
      active_subcgory: sub_index,
      active_question: 0,
    })
  }
  render() {
    let query_search_result = []
    let query_search_result_panel = <div></div>
    if (this.state.showSearchResult) {
      this.state.searchResult.forEach(question => {
        if(question.category_id && question.subcategory_id) {
          query_search_result.push(<div key={question.id} className="query_search_item" onClick={() => this.HandleSelectQuestion(question)}>
          {question.question}
        </div>)
        }
      }) 
      query_search_result_panel = <div className="query_search_panel">{query_search_result}</div>
    }
    let category_list = []
    this.state.categories.forEach(category => {
      // console.log(category_list)
      let subcategory_list = []

      if (category.subcategories.length) {
        category.subcategories.forEach(subcategory => {
          subcategory_list.push(
            <li className={subcategory.sub_category_id === this.state.active_subcgory ? 'selected_subcategory' : ''} key={subcategory.sub_category_id}>

              <a href="javascript:;" onClick={() => this.handleSelectSubcategory(subcategory.sub_category_id)}>
                <h6>{subcategory.sub_category_name}</h6>
                <p>{subcategory.sub_category_description}</p>
              </a>
            </li>
          )
        })
      }
      category_list.push(
        <li className={category.category_id === this.state.active_category ? 'active' : ''} key={category.category_id}>
          <a href="javascript:;" onClick={() => this.handleSelectCategory(category.category_id)}>
            <h3>{category.category_name}</h3>
            <p>{category.category_description}</p>
          </a>
          <ul className='subcategory_menu'>
            {subcategory_list}
          </ul>
        </li>
      )
    })

    let question_list = [];
    this.state.active_questions.forEach(question => {
      question_list.push(<HelpItem key={question.id} is_open={true} question={question.question} answer={question.answer} />)
    })
    return (
        <main>
        <HelpBanner onChange={this.handleQueryInput} searchResult={query_search_result_panel}  value={this.state.query}/>
        <div className="columns-container">
          <div id="columns" className="container">
            <div className="row">
              <div id="left_column" className="column col-xs-12 col-md-3">
                <div id="categories_block_left" className="block">
                  <h2 className="title_block">
                    Categories
                </h2>
                  <div className="block_content">
                    <ul className="tree dynamized">
                    {this.state.categories.map((category, index) => {
                      return  <li className="last" key={category.category_id}>
                        <span className={ this.state.active_category == index ? " grower OPEN" : "grower CLOSE"}> </span><a href="javascript:;" onClick={() => this.handleSelectCategory(index)}>
                          {category.category_name}
                      </a>
                      </li>
                    })}
                     
                    </ul>
                  </div>
                </div>
                <section id="informations_block_left_1" className="block informations_block_left">
                  <p className="title_block">
                    <a href="#content/category/1-home">
                      SubCategories				</a>
                  </p>
                  <div className="block_content list-block">
                    <ul>
                    {
                        this.state.categories[this.state.active_category] ? 
                        this.state.categories[this.state.active_category].subcategories.map((subcategory, sub_index) => {
                          return   <li className="first_item" key={subcategory.sub_category_id}>
                          <a href="javascript:; " className={this.state.active_subcgory == sub_index ? 'selected_subcategory' : ''} onClick={() => this.handleSelectSubcategory(sub_index)} title="More about Converse">
                            {subcategory.sub_category_name}
                        </a>
                        </li>
                        })
                        : null
                      }
                    
                    </ul>
                  </div>
                </section>
              </div>
              <div id="center_column" className="center_column col-xs-12 col-md-9">
                <section id="bonfaq">

                  <div className="panel-group" id="faqAccordion">
                      {
                        this.state.categories[this.state.active_category] && this.state.categories[this.state.active_category].subcategories[this.state.active_subcgory] && this.state.categories[this.state.active_category].subcategories[this.state.active_subcgory].questions.length ?
                        this.state.categories[this.state.active_category].subcategories[this.state.active_subcgory].questions.map((question, index) => {
                          return  <div className="panel panel-default " key={index}>
                          <div className={ this.state.active_question == question.id ? "panel-heading accordion-toggle question-toggle " : 'panel-heading accordion-toggle question-toggle collapsed'} data-toggle="collapse" data-parent="#faqAccordion" data-target={`#question${question.id}`} aria-expanded="false">
                            <h2 className="panel-title">
                              <a href="javascript:;" className="ing"><span>{index + 1}. </span>{question.question}</a>
                            </h2>
                          </div>
                          <div id={`question${question.id}`} className={ this.state.active_question == question.id ? "panel-collapse collapse show" :  "panel-collapse collapse"}  aria-expanded="false">
                            <div className="panel-body" dangerouslySetInnerHTML={{ __html : question.answer }}>
                             
                            </div>
                          </div>
                        </div>
    
                        } )
                        : <div>No Questions</div>
                      }
                   
                  </div>
                </section>
              </div>{/* #center_column */}
            </div>{/* .row */}
          </div>{/* #columns */}
        </div>
        </main>
    )
  }
}

export default Help