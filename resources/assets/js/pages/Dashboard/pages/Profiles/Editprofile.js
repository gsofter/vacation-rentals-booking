import React from 'react'
// import 'react-phone-number-input/style.css'
// import 'react-responsive-ui/style.css'
import ReactDOM from 'react-dom';
import Modal from 'react-responsive-modal';
import axios from 'axios'

import PhoneInput from 'react-phone-input-2'
import './profile.css'

import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


class Editprofile extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      language_modal_open: false,
      userinfo: {
        first_name: '',
        last_name: ''
      },
      page_data: {},
      timezones: [],
      languages: [],
      phone_number_array : []

    }
    this.openLanguageModal = this.openLanguageModal.bind(this)
    this.closeLanguageModal = this.closeLanguageModal.bind(this)
    this.handleLanguage = this.handleLanguage.bind(this)
    this.handleUserinfoChange = this.handleUserinfoChange.bind(this)
    this.handelChangeBirthDay = this.handelChangeBirthDay.bind(this)
    this.handleSubmit = this.handleSubmit.bind(this)
    this.handlePhoneNumberChange = this.handlePhoneNumberChange.bind(this)
    this.handleAddNewPhone = this.handleAddNewPhone.bind(this)
    this.handleRemovePhoneNumber = this.handleRemovePhoneNumber.bind(this)
    

  }
  componentDidMount() {
    fetch('/ajax/dashboard/index')
      .then(response => response.json())
      .then(data => {
        console.log(data)
        this.setState({
          userinfo: data.user_info,
          page_data: data.data,
          timezones: data.timezones,
          languages: data.languages
        })
      });
  }
  handleChange(e) {

  }
  handleAddNewPhone(){
    let user_info = this.state.userinfo
    let phone_number_array = user_info.phone_number
    let new_phone_number = {
      id : null,
      phone_number :'+1',
      country_name : 'us',
      default_phone_code : '1',
      status : null
    }
    phone_number_array.push(new_phone_number)
    this.setState({
      user_info : user_info
    })
  }
  handleRemovePhoneNumber(e, index){
    e.preventDefault()
    let user_info = this.state.userinfo
    let phone_number_array = user_info.phone_number
    
    if(phone_number_array[index].id){
      axios.post('/ajax/removeUserPhoneNumber', {phone_number_id : phone_number_array[index].id})
      .then(response =>{
        console.log(response.data)
        if(response.data.status == 'success'){
          phone_number_array.splice(index, 1)
          this.setState({
            userinfo : user_info
          })
          toast.success(response.data.message, {
            position: toast.POSITION.TOP_CENTER
          });
        }
      })
    }
    else{
      phone_number_array.splice(index, 1)
      this.setState({
        user_info : user_info
      })
    }
    
  }
  handlePhoneNumberChange(phone_number, country, data, index){
    let user_info = this.state.userinfo
    let phone_number_array = user_info.phone_number
    if(index == -1){
      let new_phone_number = {
        id : null,
        phone_number :phone_number,
        country_name : country.countryCode,
        default_phone_code : country.dialCode,
        status : null
      }
      phone_number_array.push(new_phone_number)
    }
    else{
      phone_number_array[index].phone_number =  phone_number
      phone_number_array[index].country_name =  country.countryCode
      phone_number_array[index].default_phone_code =  country.dialCode
    }
    this.setState({
      user_info : user_info
    })
  }
 
  openLanguageModal(e) {
    e.preventDefault();
    this.setState({
      language_modal_open: true
    })
  }
  closeLanguageModal(e) {
    e.preventDefault();
    this.setState({
      language_modal_open: false
    })
  }
  handleLanguage(language_id, e) {
    let userinfo = this.state.userinfo
    let languages = userinfo.languages
    let index = languages.indexOf(language_id)
    if (index == -1) {
      languages.push(language_id)
    }
    else {
      languages.splice(index, 1)
    }
    userinfo.languages = languages
    this.setState({
      userinfo: userinfo
    })
  }
  handleUserinfoChange(e) {
    e.preventDefault();
    let { userinfo } = this.state
    let name = e.target.name
    let value = e.target.value
    userinfo[name] = value
    this.setState({
      userinfo: userinfo
    })
  }
  handelChangeBirthDay(e) {
    e.preventDefault();
    let name = e.target.name
    let value = e.target.value
    let userinfo = this.state.userinfo
    let dob = this.state.userinfo.dob
    let year = dob.split('-')[0]
    let month = dob.split('-')[1]
    let day = dob.split('-')[2]
    let newDob = dob;
    if (name == 'year') {
      newDob = value + '-' + month + '-' + day
    }
    if (name == 'month') {
      newDob = year + '-' + value + '-' + day
    }
    if (name == 'day') {
      newDob = year + '-' + month + '-' + value
    }
    userinfo.dob = newDob;
    this.setState({
      userinfo: userinfo
    })


  }
  handleSubmit(e) {
    e.preventDefault();
    let {userinfo} = this.state
    axios.post('/ajax/saveuserprofile', userinfo)
    .then(response =>{
      console.log(response.data)
      if(response.data.status == 'success'){
        this.setState({
          userinfo : response.data.userinfo
        })
        toast.success(response.data.message, {
          position: toast.POSITION.TOP_CENTER
        });
      }
    })
  }

  render() {
    let { userinfo, page_data, timezones, languages } = this.state
    console.log(userinfo)
    let phone_number_section = []
    if (userinfo.phone_number) {
      userinfo.phone_number.forEach((phone_number, index) => {
        phone_number_section.push(
          <div className='col-sm-9 ml-auto' key={index}>
            <PhoneInput
              placeholder="Enter phone number"
              value={phone_number.phone_number}
              disabled = {phone_number.status == 'Confirmed'}
              onChange = {(phone,country , data) => this.handlePhoneNumberChange(phone, country, data, index)}
            />
             <span className={phone_number.status == 'Confirmed' ? 'label mr-1 label-success' : 'label mr-1 label-warning'}>Status : {phone_number.status ? phone_number.status : 'UnSaved'}</span>
             |
             <span className='ml-1 label label-danger' onClick={(event) =>this.handleRemovePhoneNumber(event, index)}>Delete</span>
          </div>
        )
      })
      phone_number_section.push(
        <div className='col-sm-9 ml-auto' key={'new'}>
          <button type='button' className='btn btn-primary' onClick={this.handleAddNewPhone}>Add New Phone Number</button>
        </div>
      )
       
    }

    return (
      <div className="col-md-9">
      <ToastContainer />
      <div class="aside-main-content">
          <form method="POST" acceptCharset="UTF-8" name="update_form" id="update_form" onSubmit={this.handleSubmit} >
            <div className="panel row-space-4">
            <div class="side-cnt">
                                <div class="head-label">
                                    <h4>Required</h4>
                                </div>
                
                  </div>
                  <div class="aside-main-cn">
                                    <div class="edit-profile_">
                                        <div class="form-wrapper">
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_first_name">
                    First Name
                      </label>
                  <div className="col-sm-9">
                    <input id="user_first_name" size={30} className="focus" name="first_name" type="text" value={userinfo.first_name} onChange={this.handleUserinfoChange} />
                    <span className="text-danger" />
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_last_name">
                    Last Name
                      </label>
                  <div className="col-sm-9">
                    <input id="user_last_name" size={30} className="focus" name="last_name" type="text" value={userinfo.last_name} onChange={this.handleUserinfoChange} />
                    <span className="text-danger" />
                    <div className="text-muted row-space-top-1">You information will be shared with other confirmed Vacation.Rentals----- user.</div>
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_gender">
                    I Am <i className="icon icon-lock icon-ebisu" data-behavior="tooltip" aria-label="Private" />
                  </label>
                  <div className="col-sm-9">
                    <div className="select">
                      <select id="user_gender" className="focus" name="gender" value={userinfo.gender ? userinfo.gender : 'Male'} onChange={this.handleUserinfoChange}>
                        <option >Gender</option><option value="Male">Male</option>
                        <option value="Female">Female</option><option value="Other">Other</option></select>
                    </div>
                    <span className="text-danger" />
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_birthdate">
                    Birth Date <i className="icon icon-lock icon-ebisu" data-behavior="tooltip" aria-label="Private" />
                  </label>
                  <div className="col-sm-9">
                    <div className="select">
                      <select id="user_birthday_month" className="focus" name="month" onChange={this.handelChangeBirthDay} value={userinfo.dob ? parseInt(userinfo.dob.split('-')[1]) : 0}><option value = {0}>Month</option><option value={1}>January</option><option value={2} >February</option><option value={3}>March</option><option value={4}>April</option><option value={5}>May</option><option value={6}>June</option><option value={7}>July</option><option value={8}>August</option><option value={9}>September</option><option value={10}>October</option><option value={11}>November</option><option value={12}>December</option></select>
                    </div>
                    <div className="select">
                      <select id="user_birthday_day" className="focus" name="day" onChange={this.handelChangeBirthDay} value={userinfo.dob ? parseInt(userinfo.dob.split('-')[2]) + 0 : 0}><option value = {0}>Day</option><option value={1}>1</option><option value={2}>2</option><option value={3}>3</option><option value={4}>4</option><option value={5}>5</option><option value={6}>6</option><option value={7}>7</option><option value={8}>8</option><option value={9}>9</option><option value={10}>10</option><option value={11}>11</option><option value={12}>12</option><option value={13}>13</option><option value={14}>14</option><option value={15}>15</option><option value={16}>16</option><option value={17}>17</option><option value={18}>18</option><option value={19}>19</option><option value={20}>20</option><option value={21}>21</option><option value={22}>22</option><option value={23} >23</option><option value={24}>24</option><option value={25}>25</option><option value={26}>26</option><option value={27}>27</option><option value={28}>28</option><option value={29}>29</option><option value={30}>30</option><option value={31}>31</option></select>
                    </div>
                    <div className="select">
                      <select id="user_birthday_year" className="focus" name="year" onChange={this.handelChangeBirthDay} value={userinfo.dob ? userinfo.dob.split('-')[0] : 0}><option value = {0}>Year</option><option value={2018}>2018</option><option value={2017}>2017</option><option value={2016}>2016</option><option value={2015}>2015</option><option value={2014}>2014</option><option value={2013}>2013</option><option value={2012}>2012</option><option value={2011}>2011</option><option value={2010}>2010</option><option value={2009}>2009</option><option value={2008}>2008</option><option value={2007}>2007</option><option value={2006}>2006</option><option value={2005}>2005</option><option value={2004}>2004</option><option value={2003}>2003</option><option value={2002}>2002</option><option value={2001}>2001</option><option value={2000}>2000</option><option value={1999}>1999</option><option value={1998}>1998</option><option value={1997}>1997</option><option value={1996}>1996</option><option value={1995}>1995</option><option value={1994}>1994</option><option value={1993}>1993</option><option value={1992}>1992</option><option value={1991}>1991</option><option value={1990}>1990</option><option value={1989}>1989</option><option value={1988}>1988</option><option value={1987}>1987</option><option value={1986}>1986</option><option value={1985}>1985</option><option value={1984}>1984</option><option value={1983}>1983</option><option value={1982}>1982</option><option value={1981}>1981</option><option value={1980}>1980</option><option value={1979}>1979</option><option value={1978}>1978</option><option value={1977}>1977</option><option value={1976}>1976</option><option value={1975}>1975</option><option value={1974}>1974</option><option value={1973}>1973</option><option value={1972}>1972</option><option value={1971}>1971</option><option value={1970}>1970</option><option value={1969}>1969</option><option value={1968}>1968</option><option value={1967}>1967</option><option value={1966}>1966</option><option value={1965} >1965</option><option value={1964}>1964</option><option value={1963}>1963</option><option value={1962}>1962</option><option value={1961}>1961</option><option value={1960}>1960</option><option value={1959}>1959</option><option value={1958}>1958</option><option value={1957}>1957</option><option value={1956}>1956</option><option value={1955}>1955</option><option value={1954}>1954</option><option value={1953}>1953</option><option value={1952}>1952</option><option value={1951}>1951</option><option value={1950}>1950</option><option value={1949}>1949</option><option value={1948}>1948</option><option value={1947}>1947</option><option value={1946}>1946</option><option value={1945}>1945</option><option value={1944}>1944</option><option value={1943}>1943</option><option value={1942}>1942</option><option value={1941}>1941</option><option value={1940}>1940</option><option value={1939}>1939</option><option value={1938}>1938</option><option value={1937}>1937</option><option value={1936}>1936</option><option value={1935}>1935</option><option value={1934}>1934</option><option value={1933}>1933</option><option value={1932}>1932</option><option value={1931}>1931</option><option value={1930}>1930</option><option value={1929}>1929</option><option value={1928}>1928</option><option value={1927}>1927</option><option value={1926}>1926</option><option value={1925}>1925</option><option value={1924}>1924</option><option value={1923}>1923</option><option value={1922}>1922</option><option value={1921}>1921</option><option value={1920}>1920</option><option value={1919}>1919</option><option value={1918}>1918</option><option value={1917}>1917</option><option value={1916}>1916</option><option value={1915}>1915</option><option value={1914}>1914</option><option value={1913}>1913</option><option value={1912}>1912</option><option value={1911}>1911</option><option value={1910}>1910</option><option value={1909}>1909</option><option value={1908}>1908</option><option value={1907}>1907</option><option value={1906}>1906</option><option value={1905}>1905</option><option value={1904}>1904</option><option value={1903}>1903</option><option value={1902}>1902</option><option value={1901}>1901</option><option value={1900}>1900</option><option value={1899}>1899</option><option value={1898}>1898</option></select>
                    </div>
                    <span className="text-danger" />
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_email">
                    Email Address <i className="icon icon-lock icon-ebisu" data-behavior="tooltip" aria-label="Private" />
                  </label>
                  <div className="col-sm-9">
                    <input id="user_email" size={30} className="focus" name="email" type="text" value={userinfo.email} onChange={this.handleUserinfoChange} />
                    <span className="text-danger" />
                    <div className="text-muted row-space-top-1">This is the email address you will use to correspond with other Vacation.Rentals----- users.</div>
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label phone-number-verify-label">
                    Phone Number<i className="icon icon-lock icon-ebisu" data-behavior="tooltip" aria-label="Private" />
                  </label>
                  {phone_number_section}

                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_live">
                    Where You Live
                      </label>
                  <div className="col-sm-9">
                    <input id="user_live" placeholder="e.g. Paris, FR / Brooklyn, NY / Chicago, IL" size={30} className="focus" name="live" type="text" value={userinfo.live} onChange={this.handleUserinfoChange} />
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_about">
                    Describe Yourself
                      </label>
                  <div className="col-sm-9">
                    <textarea id="user_about" cols={40} rows={5} className="focus" name="about" onChange={this.handleUserinfoChange} value={userinfo.about} />
                    <div className="text-muted row-space-top-1">Help other people get to know you by being descriptive and detailed in your profile write up.<br /><br />Sometimes, the very thing that secures a booking is the connection made between host and traveler. Let them know your favorite shows or music styles. Try to find common ground and be open and forthcoming to your guests.<br /><br />Both homeowner and traveler can use this opportunity to demonstrate why they are a good match for each other. </div>
                  </div>
                </div>
              </div>
              </div>
              </div>
            </div>
            <div className="panel row-space-4">
            <div class="side-cnt">
                                <div class="head-label">
                                    <h4>Required</h4>
                                </div>
                
                  </div>
                
                  <div class="aside-main-cn">
                                    <div class="edit-profile_">
                                        <div class="form-wrapper">
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_profile_info_website">
                    Website
                      </label>
                  <div className="col-sm-9">
                    <input id="user_profile_info_website" size={30} className="focus" name="website" type="url" value={userinfo.website} onChange={this.handleUserinfoChange} />
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_profile_info_university">
                    School
                      </label>
                  <div className="col-sm-9">
                    <input id="user_profile_info_university" size={30} className="focus" name="school" type="text" value={userinfo.school} onChange={this.handleUserinfoChange} />
                  </div>
                </div>
                <div className="row row-condensed space-4">
                  <label className="text-right col-sm-3 lang-chang-label" htmlFor="user_profile_info_employer">
                    Work
                      </label>
                  <div className="col-sm-9">
                    <input id="user_profile_info_employer" size={30} className="focus" name="work" type="text" value={userinfo.work} onChange={this.handleUserinfoChange} />
                  </div>
                </div>
             
              </div>
              </div>
              </div>
            </div>
            <button type="submit" className="lang-btn-cange btn btn-primary btn-large">
              Save
                </button>
          </form>
        </div>


       
      </div>

    )
  }
}
export default Editprofile