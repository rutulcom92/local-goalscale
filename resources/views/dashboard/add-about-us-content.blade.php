<div class="modal fade" id="aboutContentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => "dashboard.about-us.store", 'class' => '', 'id' => 'aboutContentForm','files' => 'true')) }}
                {{ Form::hidden('sitecontent[reference_key]','about_us_content')}}
                {{ Form::hidden('aboutUsHeading[reference_key]','about_us_heading')}}
                {{ Form::hidden('aboutUsImage[reference_key]','about_us_image')}}
                {{ Form::hidden('aboutUsImageContent[reference_key]','about_us_image_content')}}
                <div class="modal-header">
                    <h4 class="modal-title">About Us</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="{{ asset('images/icon-close.png') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="full_width">
                        <div class="top-content">
                            <div class="color_des">
                                <label>Heading</label>
                                <div class="form-group mrbtm48">
                                    {{ Form::text('aboutUsHeading[content]', !empty(getSiteConfig('about_us_heading')) ? getSiteConfig('about_us_heading') : "About Us" , array('class' => "form-control about-heading-info")) }}
                                </div>
                            </div>
                        	<div class="color_des">
                                <label>Content</label>
                                <div class="form-group mrbtm48">
                                	{{ Form::textarea('sitecontent[content]', !empty(getSiteConfig('about_us_content')) ? getSiteConfig('about_us_content') : "GAS is a method of measuring goal attainment over time, using a five-point scale to capture all possible outcomes for a given goal. GAS is a unique approach to goal setting, one that promotes success along a continuum rather than the traditional all-or-nothing success vs. failure model.  It has been used in healthcare and educational settings since 1968. Numerous studies have found GAS to be highly sensitive to change, unlike other measures that use a generic and broad evaluation, not specific to the needs of each individual. The ability to capture small but meaningful change over time makes it a preferred outcome measure among clinicians, researchers, teachers, and caregivers." , array('class' => "form-control about-info")) }}
                                </div>
                            </div>
                            <div class="color_des">
                                <label>Image</label>
                                <div class="form-group mrbtm48">
                                    {{ Form::file('about_us_image',array('class'=> 'file-upload' , 'id' => 'aboutUsImage' , 'accept' => 'image/*')) }}
                                </div>
                            </div>
                            <div class="color_des">
                                <label>Image Description</label>
                                <div class="form-group mrbtm48">
                                    {{ Form::text('aboutUsImageContent[content]', !empty(getSiteConfig('about_us_image_content')) ? getSiteConfig('about_us_image_content') : "Ann Chapleau & Jennifer Harrison" , array('class' => "form-control about-image-info")) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn-cls float-right" type="submit" value="Save">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>