import React from 'react'
class Security extends React.Component{

    render(){
        return(
          <div className="col-md-9">
        <div className="aside-main-content">
          <div className="side-cnt">
            <div className="head-label">
              <h4>Change Your Password</h4>
            </div>
            <div className="aside-main-cn">
              <div className="edit-profile_">
                <div className="form-wrapper">
                  <form action className="form">
                  <div className="row">
             <div className="col-lg-7 lang-chang-label">
               <div className="row row-condensed row-space-2">
                 <div className="col-md-5 text-right lang-chang-label">
                   <label htmlFor="old_password">
                     Old Password
                   </label>
                 </div>
                 <div className="col-md-7 ">
                   <input className="input-block" id="old_password" name="old_password" type="password" />
                 </div>
               </div>
             </div>
           </div>
           <div className="row">
             <div className="col-lg-7 lang-chang-label ">
               <div className="row row-condensed row-space-2">
                 <div className="col-md-5 text-right lang-chang-label">
                   <label htmlFor="user_password">
                     New Password
                   </label>
                 </div>
                 <div className="col-7">
                   <input className="input-block" data-hook="new_password" id="new_password" name="new_password" size={30} type="password" />
                 </div>
               </div>
               <div className="row row-condensed row-space-2">
                 <div className="col-md-5 text-right lang-chang-label">
                   <label htmlFor="user_password_confirmation">
                     Confirm Password
                   </label>
                 </div>
                 <div className="col-md-7">
                   <input className="input-block" id="user_password_confirmation" name="password_confirmation" size={30} type="password" />
                 </div>
               </div>
             </div>
             <div className="col-lg-5 password-strength" data-hook="password-strength" />
           </div>
                    <div className="row">
                      
                     
                     
                      <div className="col-md-12  col-sm-12">
                        <div className="field-wrapper">
                          <button className="btn btn-outline-primary pull-right">Update Password</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
          // <div className="col-md-9">
          // <div className="aside-main-content">
            
          // <div className="col-md-9 password-change-right">
          //       {/* Change Your Password */}
          //       <form method="POST"   acceptCharset="UTF-8" className="show ng-pristine ng-valid"><input name="_token" type="hidden" defaultValue="QBjMTWvPkaTXfLSl74JWrQHyT2giVnPfXDY7Lkg1" />
          //         <div id="change_your_password" className="panel row-space-4">
          //           <div className="panel-header">
          //             Change Your Password
          //           </div>
          //           <div className="panel-body">
          //             <input id="id" name="id" type="hidden" defaultValue={33661974} />
          //             <input id="redirect_on_error" name="redirect_on_error" type="hidden" defaultValue="/users/security?id=33661974" />
          //             <input id="user_password_ok" name="user[password_ok]" type="hidden" defaultValue="true" />
          //             <div className="row">
          //               <div className="col-lg-7 lang-chang-label">
          //                 <div className="row row-condensed row-space-2">
          //                   <div className="col-md-5 text-right lang-chang-label">
          //                     <label htmlFor="old_password">
          //                       Old Password
          //                     </label>
          //                   </div>
          //                   <div className="col-md-7 ">
          //                     <input className="input-block" id="old_password" name="old_password" type="password" />
          //                   </div>
          //                 </div>
          //               </div>
          //             </div>
          //             <div className="row">
          //               <div className="col-lg-7 lang-chang-label ">
          //                 <div className="row row-condensed row-space-2">
          //                   <div className="col-md-5 text-right lang-chang-label">
          //                     <label htmlFor="user_password">
          //                       New Password
          //                     </label>
          //                   </div>
          //                   <div className="col-7">
          //                     <input className="input-block" data-hook="new_password" id="new_password" name="new_password" size={30} type="password" />
          //                   </div>
          //                 </div>
          //                 <div className="row row-condensed row-space-2">
          //                   <div className="col-md-5 text-right lang-chang-label">
          //                     <label htmlFor="user_password_confirmation">
          //                       Confirm Password
          //                     </label>
          //                   </div>
          //                   <div className="col-md-7">
          //                     <input className="input-block" id="user_password_confirmation" name="password_confirmation" size={30} type="password" />
          //                   </div>
          //                 </div>
          //               </div>
          //               <div className="col-lg-5 password-strength" data-hook="password-strength" />
          //             </div>
          //           </div>
          //           <div className="panel-footer">
          //             <button type="submit" className="btn btn-primary">
          //               Update Password
          //             </button>
          //           </div>
          //         </div>
          //       </form>
          //     </div>
           
          // </div>
          // </div>
        )
    }
}

export default Security