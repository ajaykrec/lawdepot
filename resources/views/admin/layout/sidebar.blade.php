@php
$current_path       = explode('/',Request::getPathInfo()); 
//$current_path     = $current_path[2] ?? '';
$current_path       = $current_path[1] ?? '';
$current_path       = explode('?',$current_path); 
$current_path       = $current_path[0] ?? '';
//------
$dashboard_menu 	= ['dashboard'];  
$page_menu       	= ['pages','blocks'];
$banner_menu       	= ['banner-category','banners'];
$emailtemplate_menu = ['email-templates'];
$settings_menu    	= ['settings'];
$users_menu    		= ['users','user-types'];                        
$faq_menu           = ['faq'];
$testimonial_menu   = ['testimonial'];
$contact_menu       = ['contact'];
$document_menu      = ['document','document-category'];
$language_menu      = ['language'];
$location_menu      = ['country','zones'];

@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$dashboard_menu)){ echo 'collapsed'; } @endphp" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>   
        
        @if(has_permision(['settings']))
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$settings_menu)){ echo 'collapsed'; } @endphp" href="{{ route('settings.index') }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>
        @endif
        
        @if(has_permision(['users','usertypes']))
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$users_menu)){ echo 'collapsed'; } @endphp" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav" class="nav-content @php if(!in_array($current_path,$users_menu)){ echo 'collapse'; } @endphp" data-bs-parent="#sidebar-nav">
                
                @if(has_permision(['usertypes']))    
                <li>
                <a href="{{ route('user-types.index') }}" @php if( $current_path=='user-types' ){ echo 'class="active"'; } @endphp>
                <i class="bi bi-circle"></i><span>Manage User Types</span>
                </a>
                </li>
                @endif

                @if(has_permision(['users']))    
                <li>
                <a href="{{ route('users.index') }}" @php if( $current_path=='users' ){ echo 'class="active"'; } @endphp>
                <i class="bi bi-circle"></i><span>Manage Users</span>
                </a>
                </li> 
                @endif
                                          
            </ul>
        </li>
        @endif

        <!-- <li class="nav-heading">Pages</li> -->
        @if(has_permision(['pages','blocks']))
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$page_menu)){ echo 'collapsed'; } @endphp" data-bs-target="#cms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-card-text"></i><span>Cms</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="cms-nav" class="nav-content @php if(!in_array($current_path,$page_menu)){ echo 'collapse'; } @endphp" data-bs-parent="#sidebar-nav">

                @if(has_permision(['pages']))    
                <li>
                    <a href="{{ route('pages.index') }}" @php if( $current_path=='pages' ){ echo 'class="active"'; } @endphp>
                        <i class="bi bi-circle"></i><span>Pages</span>
                    </a>
                </li>
                @endif

                @if(has_permision(['blocks']))    
                <li>
                    <a href="{{ route('blocks.index') }}" @php if( $current_path=='blocks' ){ echo 'class="active"'; } @endphp>
                        <i class="bi bi-circle"></i><span>Blocks</span>
                    </a>
                </li>
                @endif               

            </ul>
        </li>
        @endif


        @if(has_permision(['country','zones']))
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$location_menu)){ echo 'collapsed'; } @endphp" data-bs-target="#location-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-geo-alt-fill"></i><span>Location</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="location-nav" class="nav-content @php if(!in_array($current_path,$location_menu)){ echo 'collapse'; } @endphp" data-bs-parent="#sidebar-nav">                
                <li>
                    <a href="{{ route('country.index') }}" @php if( $current_path=='country' ){ echo 'class="active"'; } @endphp>
                        <i class="bi bi-circle"></i><span>Countries</span>
                    </a>
                </li>               
                <li>
                    <a href="{{ route('zones.index') }}" @php if( $current_path=='zones' ){ echo 'class="active"'; } @endphp>
                        <i class="bi bi-circle"></i><span>Zones</span>
                    </a>
                </li>                
            </ul>
        </li>
        @endif

        @if(has_permision(['document']))
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$document_menu)){ echo 'collapsed'; } @endphp" data-bs-target="#document-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bag-plus-fill"></i><span>Documents</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="document-nav" class="nav-content @php if(!in_array($current_path,$document_menu)){ echo 'collapse'; } @endphp" data-bs-parent="#sidebar-nav">  
                
                <li>
                    <a href="{{ route('document-category.index') }}" @php if( $current_path=='document-category' ){ echo 'class="active"'; } @endphp>
                        <i class="bi bi-circle"></i><span>Category</span>
                    </a>
                </li>      
                <li>
                    <a href="{{ route('document.index') }}" @php if( $current_path=='document' ){ echo 'class="active"'; } @endphp>
                        <i class="bi bi-circle"></i><span>Document</span>
                    </a>
                </li>              
                          
            </ul>
        </li>
        @endif

       
        @if(has_permision(['banners']))    
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$banner_menu)){ echo 'collapsed'; } @endphp" href="{{ route('banner-category.index') }}">
                <i class="bi bi-images"></i>
                <span>Banners</span>
            </a>
        </li>
        @endif       

        
        @if(has_permision(['faq']))    
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$faq_menu)){ echo 'collapsed'; } @endphp" href="{{ route('faq.index') }}">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li>
        @endif

        @if(has_permision(['emailtemplates']))    
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$emailtemplate_menu)){ echo 'collapsed'; } @endphp" href="{{ route('email-templates.index') }}">
                <i class="bi bi-envelope"></i>
                <span>Email Templates</span>
            </a>
        </li>  
        @endif

        @if(has_permision(['testimonial']))    
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$testimonial_menu)){ echo 'collapsed'; } @endphp" href="{{ route('testimonial.index') }}">
                <i class="bi bi-chat-dots-fill"></i>
                <span>Testimonial</span>
            </a>
        </li>  
        @endif        
        

        @if(has_permision(['contact']))    
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$contact_menu)){ echo 'collapsed'; } @endphp" href="{{ route('contact.index') }}">
                <i class="bi bi-menu-up"></i>
                <span>Contact</span>
            </a>
        </li> 
        @endif      
        
        @if(has_permision(['language']))    
        <li class="nav-item">
            <a class="nav-link @php if(!in_array($current_path,$language_menu)){ echo 'collapsed'; } @endphp" href="{{ route('language.index') }}">
                <i class="bi bi-translate"></i>
                <span>Language</span>
            </a>
        </li> 
        @endif         

    </ul>
</aside>