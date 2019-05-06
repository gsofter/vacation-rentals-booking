import React from 'react'
import './Masks.css'
class Masks extends React.PureComponent{
    constructor (props){
        super(props)
    }
    render(){
      console.log(document.body.clientWidth)
        if(this.props.style == 4){
            return <div className={`${this.props.section_class ? this.props.section_class : ''} kl-bottommask kl-bottommask--mask4`}>
            <svg width="5000px" height="57px" className={`svgmask ${this.props.svg_class ? this.props.svg_class : ''} `} viewBox="0 0 5000 57" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink">
            <defs>
            <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask4">
                  <feOffset dx={0} dy={2} in="SourceAlpha" result="shadowOffsetInner1" />
                  <feGaussianBlur stdDeviation="1.5" in="shadowOffsetInner1" result="shadowBlurInner1" />
                  <feComposite in="shadowBlurInner1" in2="SourceAlpha" operator="arithmetic" k2={-1} k3={1} result="shadowInnerInner1" />
                  <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowInnerInner1" type="matrix" result="shadowMatrixInner1" />
                  <feMerge>
                  <feMergeNode in="SourceGraphic" />
                  <feMergeNode in="shadowMatrixInner1" />
                  </feMerge>
              </filter>
            </defs>
            <path d="M3.63975516e-12,-0.007 L2418,-0.007 L2434,-0.007 C2434,-0.007 2441.89,0.742 2448,2.976 C2454.11,5.21 2479,15 2479,15 L2492,21 C2492,21 2495.121,23.038 2500,23 C2505.267,23.03 2508,21 2508,21 L2521,15 C2521,15 2545.89,5.21 2552,2.976 C2558.11,0.742 2566,-0.007 2566,-0.007 L2582,-0.007 L5000,-0.007 L5000,27 L2500,27 L3.63975516e-12,27 L3.63975516e-12,-0.007 Z" className="bmask-bgfill" filter="url(#filter-mask4)" fill="#fbfbfb" />
            </svg>
           
        </div>
        }
        else if (this.props.style == 1){
            return  <div className={`${this.props.section_class ? this.props.section_class : ''} kl-bottommask kl-bottommask--shadow`}>
            </div>
        }
        else if(this.props.style == 2){
            return <div className={`${this.props.section_class ? this.props.section_class : ''} kl-bottommask kl-bottommask--shadow_ud`}  />
        }
        else if (this.props.style == 3){
            return <div className={`${this.props.section_class ? this.props.section_class : ''} kl-bottommask kl-bottommask--mask3`}>
            <svg width="5000px" height="57px" className={`svgmask ${this.props.svg_class ? this.props.svg_class : ''} `} viewBox="0 0 5000 57" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink">
              <defs>
                <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask3">
                  <feOffset dx={0} dy={3} in="SourceAlpha" result="shadowOffsetInner1" />
                  <feGaussianBlur stdDeviation={2} in="shadowOffsetInner1" result="shadowBlurInner1" />
                  <feComposite in="shadowBlurInner1" in2="SourceAlpha" operator="arithmetic" k2={-1} k3={1} result="shadowInnerInner1" />
                  <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.4 0" in="shadowInnerInner1" type="matrix" result="shadowMatrixInner1" />
                  <feMerge>
                    <feMergeNode in="SourceGraphic" />
                    <feMergeNode in="shadowMatrixInner1" />
                  </feMerge>
                </filter>
              </defs>
              <path d="M9.09383679e-13,57.0005249 L9.09383679e-13,34.0075249 L2418,34.0075249 L2434,34.0075249 C2434,34.0075249 2441.89,33.2585249 2448,31.0245249 C2454.11,28.7905249 2479,11.0005249 2479,11.0005249 L2492,2.00052487 C2492,2.00052487 2495.121,-0.0374751261 2500,0.000524873861 C2505.267,-0.0294751261 2508,2.00052487 2508,2.00052487 L2521,11.0005249 C2521,11.0005249 2545.89,28.7905249 2552,31.0245249 C2558.11,33.2585249 2566,34.0075249 2566,34.0075249 L2582,34.0075249 L5000,34.0075249 L5000,57.0005249 L2500,57.0005249 L1148,57.0005249 L9.09383679e-13,57.0005249 Z" className="bmask-bgfill" filter="url(#filter-mask3)" fill="#fbfbfb" />
            </svg>
            <i className="glyphicon glyphicon-chevron-down" />
          </div>
        }
        else{
            return <div></div>
        }
        // switch(this.props.style)  {
        //     case 1 :
        //     return <div className={`${this.props.section_class ? this.props.section_class : ''} kl-bottommask kl-bottommask--shadow`}>
        //     </div>
        //     break;
        //     case 2 :
        //     return <div className={`${this.props.section_class ? this.props.section_class : ''} kl-bottommask kl-bottommask--shadow_ud`}>
        //     </div>
        //     break
        //     case 3:
        //    return  <div className={`${this.props.section_class ? this.props.section_class : ''} kl-bottommask kl-bottommask--mask3`}>
        //       <svg width="5000px" height="57px" className={`svgmask ${this.props.svg_class ? this.props.svg_class : ''} `} viewBox="0 0 5000 57" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink">
        //       <defs>
        //           <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask3">
        //           <feOffset dx={0} dy={3} in="SourceAlpha" result="shadowOffsetInner1" />
        //           <feGaussianBlur stdDeviation={2} in="shadowOffsetInner1" result="shadowBlurInner1" />
        //           <feComposite in="shadowBlurInner1" in2="SourceAlpha" operator="arithmetic" k2={-1} k3={1} result="shadowInnerInner1" />
        //           <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.4 0" in="shadowInnerInner1" type="matrix" result="shadowMatrixInner1" />
        //           <feMerge>
        //               <feMergeNode in="SourceGraphic" />
        //               <feMergeNode in="shadowMatrixInner1" />
        //           </feMerge>
        //           </filter>
        //       </defs>
        //       <path d="M9.09383679e-13,57.0005249 L9.09383679e-13,34.0075249 L2418,34.0075249 L2434,34.0075249 C2434,34.0075249 2441.89,33.2585249 2448,31.0245249 C2454.11,28.7905249 2479,11.0005249 2479,11.0005249 L2492,2.00052487 C2492,2.00052487 2495.121,-0.0374751261 2500,0.000524873861 C2505.267,-0.0294751261 2508,2.00052487 2508,2.00052487 L2521,11.0005249 C2521,11.0005249 2545.89,28.7905249 2552,31.0245249 C2558.11,33.2585249 2566,34.0075249 2566,34.0075249 L2582,34.0075249 L5000,34.0075249 L5000,57.0005249 L2500,57.0005249 L1148,57.0005249 L9.09383679e-13,57.0005249 Z" className="bmask-bgfill" filter="url(#filter-mask3)" fill="#fbfbfb" />
        //       </svg>
        //       <i className="glyphicon glyphicon-chevron-down" />
        //   </div>
        //     break;
        //     case 4:
           
        //     break;
        //     default :
        //   return <div></div>
        // }
    }
}

export default Masks