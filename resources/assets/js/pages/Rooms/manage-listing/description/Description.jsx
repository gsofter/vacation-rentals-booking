import React from 'react';
import Content from './content/Content';
import property_help from '../img/property-help.png';
import Language from './language/Language';
import Formcontent from './formcontent/Formcontent';
import Formtitle from './formtitle/Formtitle';
import Savebutton from './savebutton/Savebutton';
import LanguageModal from 'react-awesome-modal';
import axios from 'axios'
import { ToastContainer, toast } from 'react-toastify';
  import 'react-toastify/dist/ReactToastify.css';
  import {connect} from 'react-redux'
  import { renderSidebarAction, renderStopSidebarAction} from '../../../../actions/managelisting/renderSidebarAction'
class Description extends React.Component {
    constructor(props){
        super(props)
        this.state = {
            page_data : {
                result : {}
            },
            lang_data : [],
            lang_lists : [],
            current_lang : 'en',
            visible_lang_modal : false,
            selected_lang_to_add : '',
            editing_description : {},
            post_data : {
                name : '',
                summary : '',
                description : {}
            }
        }
        this.handleChangeTitle = this.handleChangeTitle.bind(this)
        this.handleChangeSummary = this.handleChangeSummary.bind(this)
        this.handleDescriptionChange = this.handleDescriptionChange.bind(this)
        this.handleChangeLanguage = this.handleChangeLanguage.bind(this)
        this.openAddLanguageModal = this.openAddLanguageModal.bind(this)
        this.closeLangModal = this.closeLangModal.bind(this)
        this.selectLanguageToAdd = this.selectLanguageToAdd.bind(this)
        this.handleAddLanguage = this.handleAddLanguage.bind(this)
        this.handleUpdateRoom = this.handleUpdateRoom.bind(this)
        this.removeLanguage = this.removeLanguage.bind(this)
    }
    componentDidMount(){
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/lan_description`)
         .then(res => {
            let result = res.data;
            this.setState({
                lang_data : result,
                current_lang : 'en'
            });
         })
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/get_all_language`)
         .then(res => {
            let result = res.data;
            this.setState({
                lang_lists : result
            });
         })
         axios.get(`/ajax/rooms/manage_listing/${this.props.match.params.roomId}/description`)
         .then(res => {
            let result = res.data;
            let post_data = {}
            post_data.name = result.result.name
            post_data.summary = result.result.summary
            post_data.description = result.result.room_description
          
            this.setState({
                page_data : result,
                post_data : post_data
            }, () => {
                let active_lists = document.getElementsByClassName('nav-active')
                for(let i = 0 ; i < active_lists.length ; i++){
                    active_lists[i].classList.remove("nav-active");
                }
                let room_step = this.state.page_data.room_step
                let current_lists = document.getElementsByClassName(`nav-${room_step}`)
                for(let i = 0 ; i < current_lists.length ; i++){
                    current_lists[i].classList.add('nav-active')
                    // active_lists[i].classList.remove("nav-active");
                }
                
              
                console.log(active_lists)
            });
         })
    }
    handleChangeTitle(e){
        
        let post_data = this.state.post_data
        post_data.name = e.target.value
        if(this.state.current_lang != 'en'){

            let lang_data = this.state.lang_data
            let _self = this
            let lang_index = this.state.lang_data.findIndex(language =>{
                return language.language.value == _self.state.current_lang
            })
            // console.log(lang_data[lang_index])
            lang_data[lang_index].name = e.target.value
            this.setState({
                lang_data : lang_data,
                post_data : post_data
            }, ()=>{
                
            }) 
        }
        else{
            let page_data = this.state.page_data
           
            if(e.target.value.length <= 100){
                page_data.result.name= e.target.value
                this.setState({
                    page_data : page_data,
                    post_data : post_data
                })
            }
        }
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/update_rooms`, 
        {current_tab : this.state.current_lang, data : JSON.stringify({name : this.state.post_data.name, summary : this.state.post_data.summary}) })
        .then( res => {
            !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
        })
    }
    handleDescriptionChange(name, value){
        let post_data = this.state.post_data
        post_data.description = {}
        post_data.description[name] = value
        
        if(this.state.current_lang != 'en'){
            
            let lang_data = this.state.lang_data
            let _self = this
            let lang_index = this.state.lang_data.findIndex(language =>{
                return language.language.value == _self.state.current_lang
            })
            lang_data[lang_index][name] = value

            this.setState({
                lang_data : lang_data,
                post_data : post_data
            }) 
        }
        else{
            let page_data =  this.state.page_data
            page_data.result.room_description[name] = value
           
            this.setState({
                page_data : page_data,
                post_data : post_data
            })
        }
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/update_description`, 
        {current_tab : this.state.current_lang, data : JSON.stringify(this.state.post_data.description) })
        .then( res => {
            !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
        })
    }
    handleUpdateRoom(){
        
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/update_rooms`, 
        {current_tab : this.state.current_lang, data : JSON.stringify({name : this.state.post_data.name, summary : this.state.post_data.summary}) })
        .then( res => {
            !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
        })
    }
    handleChangeLanguage(Lang){
        
        // this.handleUpdateRoom()
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/update_rooms`, 
        {current_tab : this.state.current_lang, data : JSON.stringify({name : this.state.post_data.name, summary : this.state.post_data.summary}) })
        .then( res => {
            let post_data = this.state.post_data
            if(Lang!= 'en'){
                let lang_data = this.state.lang_data
                let _self = this
                let lang_index = this.state.lang_data.findIndex(language =>{
                    return language.language.value == Lang
                })
                post_data.summary = lang_data[lang_index].summary
                post_data.name = lang_data[lang_index].name
                
            }
            else{
                post_data.name = this.state.page_data.result.name
                post_data.summary = this.state.page_data.result.summary
            }
            this.setState({
                current_lang : Lang,
                post_data : post_data
            }, ()=>{
                !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
            })
        })
       
    }
    openAddLanguageModal(){
        
        this.setState({
            visible_lang_modal : true
        })
    }
    closeLangModal(){
        this.setState({
            visible_lang_modal : false
        })
    }
    selectLanguageToAdd(e){
        this.setState({
            selected_lang_to_add : e.target.value
        })
    }
    handleAddLanguage(e){
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/add_description`, { lan_code : this.state.selected_lang_to_add })
        .then(res => {
            let result = res.data
            toast.success("Language Added Successfully", {
                position: toast.POSITION.TOP_RIGHT
              });
            this.setState({
                lang_data : result ,
                visible_lang_modal : false,
                selected_lang_to_add : ''
            }, ()=>{
                !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
            })
        })
        
    }
    handleChangeSummary(name, value){
        
        let post_data = this.state.post_data
        console.log('Post Data', post_data)
        post_data.summary = value
        if(this.state.current_lang != 'en'){
            let lang_data = this.state.lang_data
            let _self = this
            let lang_index = this.state.lang_data.findIndex(language =>{
                return language.language.value == _self.state.current_lang
            })
            lang_data[lang_index].summary = value
            this.setState({
                lang_data : lang_data,
                post_data : post_data
            }) 
        }
        else{
        let page_data = this.state.page_data
        page_data.result[name] = value
      
        this.setState({
            page_data : page_data,
            post_data : post_data
        })  
        }
        
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/update_rooms`, 
        {current_tab : this.state.current_lang, data : JSON.stringify({name : this.state.post_data.name, summary : this.state.post_data.summary}) })
        .then( res => {
            !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
        }) 
    }
    removeLanguage(){
        axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/delete_language`, { current_tab : this.state.current_lang})
        .then(res => {
            if(res.data.success == 'true'){
                toast.success("Language Removed Succssfully!", {
                    position: toast.POSITION.TOP_RIGHT
                  });
                axios.post(`/ajax/rooms/manage-listing/${this.props.match.params.roomId}/lan_description`)
                .then(res => {
                   let result = res.data;
                   this.setState({
                       lang_data : result,
                       current_lang : 'en'
                   }, ()=>{
                    !this.props.re_render ? this.props.renderSidebarAction() : this.props.renderStopSidebarAction()
                   });
                })
            }
        })
    }
    render(){
        let form_data = {}
        if(this.state.current_lang != 'en'){
            let lang_index = this.state.lang_data.findIndex(language =>{
                return language.language.value == this.state.current_lang
            })
            let lang_description = this.state.lang_data[lang_index]
            console.log('Lang Description', lang_description)
            form_data.name = lang_description.name
            form_data.summary = lang_description.summary
            let room_description = {};
            room_description.access =  lang_description.access 
            room_description.house_rules =  lang_description.house_rules 
            room_description.interaction =  lang_description.interaction 
            room_description.neighborhood_overview =  lang_description.neighborhood_overview 
            room_description.notes =  lang_description.notes 
            room_description.room_id =  lang_description.room_id 
            room_description.space =  lang_description.space 
            room_description.transit =  lang_description.transit 
            form_data.room_description = room_description
        }
        else{
              form_data = this.state.page_data.result
        }
        console.log('Form Data', form_data)
        return(
            <div className="manage-listing-content-wrapper clearfix">
            <ToastContainer />
                <div className="listing_whole col-md-8" id="js-manage-listing-content">
                    <div className="common_listpage">
                        <Content roomId={this.props.match.params.roomId}/>
                        <Language removeLanguage={this.removeLanguage} handleChangeLanguage={this.handleChangeLanguage} openAddLanguageModal={this.openAddLanguageModal} lang_data = {this.state.lang_data} current_lang ={this.state.current_lang}/>
                        <LanguageModal 
                            visible={this.state.visible_lang_modal}
                            width="518"
                            effect="fadeInUp"
                            onClickAway={() => this.closeLangModal()}
                        >
                         <div className="panel rjbedbathpanel" id="add_language_des">
                         <div className="panel-header">
                         <a data-behavior="modal-close" className="modal-close" href="javascript:;" /><div className="h4 js-address-nav-heading">Add Language</div></div>
                         <div className="panel-body">
                         <div className="col-10 col-center text-center"> <i className="icon icon-globe icon-size-3 icon-rausch space-top-3" />
                            <h3>Write a description in another language</h3>
                            <h6> Vacation.Rentals----- has facility to add your own versions in other languages. </h6>
                            <div className="row row-table">
                                <div className="col-offset-1 col-7 col-middle">
                                <div className="select select-large select-block">
                                    <select id="language-select" onChange={this.selectLanguageToAdd} value={this.state.selected_lang_to_add}>
                                    <option disabled value="Choose language...">Choose language...</option>
                                    {/* ngRepeat: lan_row in all_language */}
                                    {
                                        this.state.lang_lists.map((language) =>{
                                            return  <option key={language.value} value={language.value}>{language.name}</option>
                                        })
                                    }
                                    </select>
                                </div>
                                </div>
                               
                            </div>
                            </div>
                          
                         </div>
                         <div className="panel-footer">
                            <div className="col-3 col-middle">
                                <button className="btn btn-large" id="write-description-button" onClick={this.handleAddLanguage}  disabled={this.state.selected_lang_to_add ? false : true}> <i className="icon icon-add float-none" /> Add </button>
                                </div>
                            </div>
                        </div>
                        </LanguageModal>
                        <div className="description_form col-sm-12">
                            <Formtitle/>
                            <Formcontent data={form_data} handleChangeSummary={this.handleChangeSummary} handleChangeTitle={this.handleChangeTitle} onDescriptionChange={this.handleDescriptionChange} />
                        </div>
                        <Savebutton roomId={this.props.match.params.roomId}/>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 listing_desc">
                    <div className="manage_listing_left">
                     <img src={property_help} alt="property-help" className="col-center" width="75" height="75"/>
                        <div className="amenities_about">
                        <h4>Description</h4>
                        <p>Your listing name will be the first thing travelers see when they find your space in search results.</p>
                        <p>Example: Cozy cottage just off Main Street</p>
                        </div>
                    </div>
                </div>
            </div>
        )

    }
}
 
const mapStateToProps = state =>({
    ...state
  })
  const mapDispatchToProps = dispatch =>({
    renderSidebarAction : () => dispatch(renderSidebarAction) ,
    renderStopSidebarAction : () => dispatch(renderStopSidebarAction) 
  })

  export default connect(mapStateToProps, mapDispatchToProps)(Description)