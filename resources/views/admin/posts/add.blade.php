@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Posts Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.posts')}}">Posts</a></li>
                     <li class="breadcrumb-item">Add</li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">
                    <div class="card-header table-card-header">  
                        <div class="row">
                            <div class="col-sm-9 text-left">
                                <h5>Add Post Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_post')}}" enctype="multipart/form-data"  accept-charset="UTF-8" class="form-horizontal bordered row" role="form">
                            {{ csrf_field() }}
                        <div class="col-sm-7">                                

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Title<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" class="form-control"  placeholder="Title" required>
                                </div>
                            </div>
                                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Excerpt<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="excerpt" class="form-control"  placeholder="Excerpt" required>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Content<span class="text-danger">*</span></label>
                                <div class="col-sm-9">                                       
                                    <textarea name="content" class="summernote"></textarea>
                                </div>             
                            </div>        

                        </div>

                        <div class="col-sm-5">  
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Image</label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" id="input-file-now1" data-default-file="{{asset("images/posts/default.jpg")}}" class="dropify"  />                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Author<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="author_id"  class="categories-select form-control required" required>
                                        <option value="">Select</option>                                            
                                        @foreach($authores as $row)
                                            <option value="{{$row->id}}">{{$row->first_name}} {{$row->last_name}}</option>
                                        @endforeach                                           
                                    </select>
                                </div>
                            </div>
       
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Category</label>
                                <div class="col-sm-9">                                    
                                    <select name="categories[]"  class="categories-select form-control" multiple="multiple">
                                        <option value="">Select Some Option</option>                                            
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach                                           
                                    </select>
                                </div>
                            </div>
       
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Tag</label>
                                <div class="col-sm-9">
                                    <select name="tags[]"  class="categories-select form-control" multiple="multiple">
                                        <option value="">Select Some Option</option>                                            
                                        @foreach($tags as $tag)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach                                           
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Featured</label>
                                <div class="col-sm-9 checkbox-fade fade-in-default">
                                    <label>
                                        <input type="checkbox" name="featured" value="1" class="form-control">
                                        <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                        </span> 
                                    </label>                                   
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Publish Date</label>
                                <div class="col-sm-6">
                                    <input id="dropper-default" name="publish_date" class="form-control required " type="text" value="{{date('Y-m-d')}}" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control form-control-default required categories-select"  required>
                                        <option value="draft">Draft</option>
                                        <option value="publish">Publish</option>                                            
                                        <option value="pending">Pending</option> 
                                    </select>
                                </div>
                            </div>       
                            <div class="form-group row">
                                <div class="col-sm-12" style="padding-left: 65px;">
                                    <ul class="nav nav-tabs md-tabs " role="tablist">
                                        <li class="nav-item" style="display: none">
                                            <a class="nav-link active" data-toggle="tab" href="#firsttab" role="tab" >SEO</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#seo" role="tab">SEO</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#meta" role="tab">Meta</a>
                                            <div class="slide"></div>
                                        </li>                                        
                                    </ul>
                                    <div class="tab-content card-block">
                                        <div class="tab-pane active" id="firsttab" role="tabpanel" style="display: none" >
                                            <p>This is first tab</p>
                                        </div>
                                        <div class="tab-pane" id="seo" role="tabpanel">
                                                <div class="form-group row col-sm-12">
                                                    <label class="col-form-label text-right">Slug</label>
                                                    <div class=" input-group">                                                        
                                                        <span class="input-group-addon" id="basic-addon1">/</span>
                                                        <input type="text" class="form-control"  name="permalink[slug]">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row col-sm-12">
                                                    <label class="col-form-label text-right">Page title/60</label>                                                    
                                                    <input type="text" name="meta_title" class="form-control">                                                    
                                                </div>
                                                <div class="form-group row col-sm-12">
                                                    <label class="col-form-label text-right">H1 Tag/30</label>                                                    
                                                    <input type="text" name="permalink[seo][meta][h1_tag]" class="form-control">                                                    
                                                </div>
                                                <div class="form-group row col-sm-12">
                                                    <label class="col-form-label text-right">H1 description/300</label>                                                    
                                                    <textarea type="text" name="meta_description" class="form-control">  </textarea>                                                  
                                                </div>
                                                <div class="form-group row col-sm-12">
                                                    <label class="col-form-label text-right">Meta Keywords/030</label>                                                    
                                                    <input type="text" name="permalink[seo][meta][keywords]" class="form-control">                                                    
                                                </div>

                                                <div class="col-lg-12 col-xl-6">
                                                    
                                                        
                                                    <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-toggle="tab" href="#google" role="tab">
                                                                <div class="permalink-meta-preview__header mb-2">
                                                                    <span class="font-weight-bold">View </span>
                                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAAAdCAMAAAAZ3lvZAAABp1BMVEUAAAA0qFM0qFNChfQ0qFNAgvBChfTsUy9ChfT7vAVChfRChfRChfRChfTqQzVChfRChfRChfTqQzVChfRBhfRBhfPqQzVChfTqQzVChfRChfRChfTqQjTqQzVChfRChfTqQzXqQzXqQzXqQzXsQjVChfRChfRChfT7vAVChfTqQzVChfRChfRChfTqQzVChfTqQzVChfTqQzVChfTqQzXqQzXqQzVChfQwqlRChfT8vQPqQzVChfRBhPTqQjX6zAPqQTT7uwX7vAXqQzXqQzX7vAXqQzVChfTqQzVChfRChfRChfT7vAXqQzXqQzT7vAXqQzVChfRChfRChfT7vARChfP7vAVBhfTxPjP7uwT7vAXqQzX7vAVChfT7vAXqQzVChfT7vAVChfT7vAX7vAX9vQJBhfT/vQDqQzVBhPM0qFP7vAPqQjTpQjU0qFP7vAU0qFP7vAVChfQ0qFPqQzX7vAX7vAX7vAX7vAX7vAX7vAU0qFPvQDTqQzT/wQDqQzXyPzT7vAX6vAP7vAXqQzX/6gDpQzT/+AA0qFNChfTqQzX7vAU0qFNk+OFbAAAAiXRSTlMABMZXXAG+BAX894hw2dnMxKuIYjgL/fz45XppK/Lp382smI9IIRD59PHh3dHHvbSnnYF2dGxlXFlUTUIpGAwKCAXo0sm7tqWimo6AfnphW1JMSUQ8MB8UEA/u6tXTysKhl5WPbEY+Mh4cGhkYFe/h1cTAuq+rpaGGdmdjVVRSTjQvJyQhHx0WFNARjvUAAANHSURBVEjHrZRnVxNBFIZfxSWbhJCQEIoEQkgIvTdBugICSu+CgIJ0e+9dZzY/2juzs1lzwA/iPl927zkzz9y5c2egqMwaD9QHWroqcS5+HR5ewBn0NXiYicd/cA7vhacPUldwmhL2J13av4svplKXcIo8RtSFDpJ9XT76K3NKnEOy6KwK5qO+MJwR95K3WE+HehLOiLV68mYk6ZC4l/ohB3/B5XJlJDE0lBHrup4hVlPsjsDZzDwrzy2PfYRi4ObI+vrj7SUoFsf8voYJPeT1LqbFV5tpyo2Iaok8nMVKOTfZ7Jfxgtsw2TGzvcskUT9jWUrsquAmUwDq7Up0B7IVLcBgLSeKOFF7AuCNkeYeiCZGVDHCFjdy4jYnbgHUuSG77xTFwHWyBimJeAHnMWC12jAe7gJf7pB5AWijUU199PXY4hkyNlOFgzT1GxoYmzwlLkOC84IECDn8BNuGMTwk4+eGsYZwnVXBblucy3lQFrpI/FCp6pU4/7KgzUvXEFStXJhsimGUZw8ke27DvVdJOg2SqCVe4bwU2O+sFSWMYY6GZD5pIcayMcp5q4pvcX79p2FUf1Wxm9aQY0wmlfhKgsZFGks50d6voa+Gsa0M8QZjXnEOHSruoOS/k3jJFn/IsXupxBK/o+pxonEKkjFKOR829wtFHOP8BkzinI8OGIb7MySrJN6dZcwHkxZL/IkLKlY0mGjFovywmKcdBOT+S/shoc29x7DoMsk0lfsoKVcXhD3pw+OUzCAEEfMGeUTrJHUNmqZ56b9GB45F64BwXaPWBHpINw3iiBIegR6g1lkWaY3bXRGnOfuyLXhMLpBfwwh/3lZewMOswnRyKm2wM55L306KRf+OvN55Qd61VfNNLBsvmfQzW3xcRNus6Ggf5dbJL/uYTXQZkooCroiDGBg2FNUL8ijUrSusSosRSU+5NmhVtklpN7LCUCRqzTFXrTfI9L5U3dGbzQQlT4T4USr1FsCPZi4o6HAhjTbX5r3crayKSHuwPQKbnpuvpofssDLHG9JAxZhFmv6p1tYE/otu9a1ihflwDC1Uph7FLMY8YTjHBB2bV9w7augJOElAPq+M8MFR9Gzr7U7CYeZaGur8Y104m9/r+lmvMkKejAAAAABJRU5ErkJggg==" height="16px" alt="Google logo"><span class="font-weight-bold"> Snippet</span>
                                                                </div>
                                                            </a>
                                                            <div class="slide"></div>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#facebook" role="tab">
                                                                <div class="permalink-meta-preview__header mb-2">
                                                                    <span class="font-weight-bold">View </span>
                                                                    <img src="data:image/png;base64,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" height="14px" class="mb-2" alt="Facebook logo"><span class="font-weight-bold"> Snippet</span>
                                                                </div>
                                                            </a>
                                                            <div class="slide"></div>
                                                        </li>                                                         
                                                    </ul>                                                        
                                                    <div class="tab-content tabs-left-content card-block">
                                                        <div class="tab-pane active" id="google" role="tabpanel" style="margin-top: 15px;">
                                                            <div id="js-seo-preview__google-inner"><span id="js-seo-preview__google-title"></span><span id="js-seo-preview__google-url">https://www.vacation.rentals//</span><span id="js-seo-preview__google-desc"></span></div>
                                                        </div>
                                                        <div class="tab-pane" id="facebook" role="tabpanel" style="margin-top: 105px;">
                                                            <div id="js-seo-preview__facebook-inner"><div id="js-seo-preview__facebook-inner-text"><span id="js-seo-preview__facebook-title"></span><span id="js-seo-preview__facebook-desc"></span><span id="js-seo-preview__facebook-url">vacation.rentals</span></div></div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="tab-pane" id="meta" role="tabpanel">
                                            
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Allow search engines to show this page in search results?</label>
                                                        <select id="input_permalink_robots_index" class="form-control" name="permalink[seo][advanced][robots][index]">
                                                            <option value="-1">Default</option>
                                                            <option value="1">Yes (index)</option>
                                                            <option value="0">No (no index)</option></select>
                                                        <span class="text-danger"></span>
                                                    </div>

                                                    
                                                    <div class="form-group">
                                                        <label>Should search engines follow links on this page?</label>
                                                        <select id="input_permalink_robots_follow" class="form-control" name="permalink[seo][advanced][robots][follow]">
                                                            <option value="1">Follow</option>
                                                            <option value="0">No follow</option>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    

                                                    <div class="form-group">
                                                        <label>Meta robots advanced</label>
                                                        <div class="form-group">
                                                            <span class="switch">
                                                                <input class="switch1" id="image-index-checkbox" name="permalink[seo][advanced][robots][noimageindex]" type="checkbox">
                                                                <label for="image-index-checkbox">No Image Index</label>
                                                            </span> <span class="text-danger"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <span class="switch">
                                                                <input class="switch2" id="no-archive-checkbox" name="permalink[seo][advanced][robots][noarchive]" type="checkbox">
                                                                <label for="no-archive-checkbox">No Archive</label>
                                                            </span> <span class="text-danger"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <span class="switch">
                                                                <input class="switch3" id="no-snippet-checkbox" name="permalink[seo][advanced][robots][nosnippet]" type="checkbox">
                                                                <label for="no-snippet-checkbox">No Snippet</label>
                                                            </span> <span class="text-danger"></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Canonical URL</label>
                                                        <input class="form-control" id="input_canonical_url" name="permalink[seo][advanced][canonical]" type="text">
                                                        <span class="text-danger"></span>
                                                    </div>

                                                </div>
                                        </div>                                           
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        
                           
                                
                        <div class="col-sm-12 text-center" style="margin-bottom:10px;">
                            <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{route('admin.posts')}}" class="btn btn-default btn-round">Cancel</a>
                        </div>
                    
                           
                        
                        </form>


                    </div>
                    </div>
               </div>
            </div>

         </div>
         <div id="styleSelector"></div>
      </div>
   </div>
</div>
  
    <script>       

        $('.summernote').summernote({
            height: 300
        });

        $('.dropify').dropify();

        $(".categories-select").select2();

        $("#dropper-default").dateDropper( {
            dropWidth: 200,
            format: "Y-m-d",
            dropPrimaryColor: "#1abc9c", 
            dropBorder: "1px solid #1abc9c"
        });
        var elemsingle = document.querySelector('.switch1');
	    switchery = new Switchery(elemsingle, { color: '#1abc9c', jackColor: '#fff' });
        
        var elemsingle = document.querySelector('.switch2');
	    switchery = new Switchery(elemsingle, { color: '#1abc9c', jackColor: '#fff' });
        
        var elemsingle = document.querySelector('.switch3');
	    switchery = new Switchery(elemsingle, { color: '#1abc9c', jackColor: '#fff' });
        
    </script>
 
@stop