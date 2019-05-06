import React from 'react'
import axios from 'axios'
import Modal from 'react-responsive-modal';
import './wishlist.scss'
class Wishilist extends React.PureComponent {
    constructor(props) {
        super(props)
        this.state = {
            wishlist_items: [],
            modal_open: false,
            wish_list_text : ''
        }
        this.openModal = this.openModal.bind(this)
        this.closeModal = this.closeModal.bind(this)
        this.handleChangeWishListText = this.handleChangeWishListText.bind(this)
        this.handleCreateWishlist = this.handleCreateWishlist.bind(this)
        this.handeSaveWishlist = this.handeSaveWishlist.bind(this)
    }

    componentDidMount() {
        axios.get('/ajax/wishlist_list?id=' + this.props.roomId)
            .then(result => {
                this.setState({
                    wishlist_items: result.data
                })
            })
    }
    openModal() {
        this.setState({
            modal_open: true
        })
    }
    closeModal() {
        this.setState({
            modal_open: false
        })
    }
    handleChangeWishListText(e){
        this.setState({
            wish_list_text : e.target.value
        })
    }
    handleCreateWishlist(){
        axios.post('/ajax/wishlist_create', {data : this.state.wish_list_text, id : this.props.roomId})
        .then(result=> {
            this.setState({
                wishlist_items : result.data,
                wish_list_text : ''
            })
        })
    }
    handeSaveWishlist(index, wishlist_id, saved_id){
        axios.post('/ajax/save_wishlist', { data : this.props.roomId, saved_id : saved_id, wishlist_id : wishlist_id})
        .then(result => {
            let list_items = this.state.wishlist_items
            list_items[index].saved_id = result.data
            this.setState({
                wishlist_items : list_items
            })
        })
    }
    render() {
        return <div className="wishlist-wrapper ">
            <Modal open={this.state.modal_open} onClose={this.closeModal} closeIconSize={20} center styles={{ modal: { padding: '0px' } }}>
                <div className="row d-lg-flex flex-md-column flex-lg-row">
                    <div className="col-lg-5 d-flex flex-basis-40 p-0">
                        <div id="review_form_wizard_left_form" className="left_form">
                            <figure><img src="https://cdn2.iconfinder.com/data/icons/christmas-1-14/96/Christmas-solid_Wishlist_-512.png" width={100} /></figure>
                            <h2>Wishlist</h2>
                            <p>Do you like this listing? You can add this listing to your wishlist. So you can visit this page directly in your Wishlist.</p>
                            <a href="https://www.vacation.rentals/united-states" id="more_info"><i className="icon icon3-house" /></a>
                        </div>
                    </div>
                    <div className="col-lg-7 d-flex justify-content-center p-4">

                        <div className="wl-modal-wishlists w-100">
                            <div className="panel-header panel-light wl-modal__header">
                                <div className="va-container va-container-h va-container-v">
                                    <div className="va-middle">
                                        <div className="pull-left h3">Save to Wish List</div>
                                    </div>
                                </div>
                            </div>
                            <div className="panel-body panel-body-scroll wl-modal-wishlists__body wl-modal-wishlists__body--scroll">
                                <div className="text-lead text-gray space-4">Save your favorite listings, compare notes, and start planning your next adventure.</div>
                                <div className="wl-modal-wishlist-row clickable ng-scope text-dark-gray" ng-class="(item.saved_id) ? 'text-dark-gray' : 'text-gray'" ng-click="wishlist_row_select($index)" id="wishlist_row_0">
                                    {
                                        this.state.wishlist_items && this.state.wishlist_items.length ? this.state.wishlist_items.map((item, index) => {
                                           return  <div className="va-container va-container-v va-container-h" key={index}>
                                        <div className="va-middle text-left text-lead wl-modal-wishlist-row__name">
                                            <span> </span>
                                            <span className="ng-binding">{item.name}</span>
                                            <span> </span>
                                        </div>
                                        <div className="va-middle text-right">
                                            <div className="h3 wl-modal-wishlist-row__icons">
                                                {item.saved_id ? <i className="icon icon-heart-alt icon-light-gray wl-modal-wishlist-row__icon-heart-alt" onClick={()=>this.handeSaveWishlist(index, item.id, item.saved_id)}/> : 
                                                <i className="icon icon-heart icon-rausch wl-modal-wishlist-row__icon-heart"  onClick={()=>this.handeSaveWishlist(index, item.id, item.saved_id)} />}
                                            </div>
                                        </div>
                                        
                                    </div>
                                        } ) : null
                                    }
                                </div>
                            </div>
                            <div className="text-beach panel-body wl-modal-wishlists__body ">
                                <small />
                            </div>
                            <div className="panel-footer wl-modal-footer clickable">
                                <form className="wl-modal-footer__form  ng-pristine ng-valid">
                                    <strong>
                                        <div className="pull-left text-lead va-container va-container-v">
                                            <input type="text" className="wl-modal-footer__text wl-modal-footer__input" onChange={this.handleChangeWishListText} autoComplete="off" id="wish_list_text" value={this.state.wish_list_text} placeholder="Name Your Wish List" required />
                                        </div>
                                        <div className="pull-right">
                                            <button id="wish_list_btn" className="btn btn-flat wl-modal-wishlists__footer__save-button btn-contrast" onClick={this.handleCreateWishlist} type="button">Create</button>
                                        </div>
                                    </strong>
                                </form>
                           
                            </div>
                        </div>
                    </div>
                </div>{/* /Row */}
            </Modal>
            <div className="rich-toggle wish_list_button not_saved" data-hosting_id={11449}>
                <button type='button' className="btn btn-block btn-large" onClick={this.openModal}>
                    {
                        this.state.wishlist_items.length ?
                            <span className="rich-toggle-checked">
                                <i className="icon icon-heart icon-rausch" />
                                Saved to Wish List
                        </span>
                            :
                            <span className="rich-toggle-unchecked">
                                <i className="icon icon-heart-alt icon-light-gray" /><font style={{ verticalAlign: 'inherit' }}><font style={{ verticalAlign: 'inherit' }}>
                                    Save to Wish List
                            </font></font></span>
                    }

                </button>
            </div>
        </div>
    }
}
export default Wishilist