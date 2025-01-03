@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">
        
        <div class="col-12">
          <div class="row">

            @if(has_permision(['settings']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('settings.index') }}">
              <div class="card info-card revenue-card">  
                <div class="card-body">
                  <h5 class="card-title">Settings</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gear"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $table_count['settings_count'] ?? '0' }}</h6>                      
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif

            @if(has_permision(['users','user-types']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('users.index') }}">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Users</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">

                    @if(has_permision(['users']))                     
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('users.index') }}">- Users ({{ $table_count['users_count'] ?? '0' }})</a></span><br />
                    @endif

                    @if(has_permision(['user-types']))    
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('user-types.index') }}">- User Types ({{ $table_count['users_types_count'] ?? '0' }})</a></span><br />
                    @endif

                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif
            
            @if(has_permision(['pages','blocks']))
            <div class="col-xxl-3 col-md-4">
              <div class="card info-card sales-card">                
                <div class="card-body">
                  <h5 class="card-title">CMS</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-card-text"></i>
                    </div>
                    <div class="ps-3">     

                    @if(has_permision(['pages']))                     
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('pages.index') }}">- Pages ({{ $table_count['pages_count'] ?? '0' }})</a></span><br />
                    @endif

                    @if(has_permision(['blocks']))    
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('blocks.index') }}">- Blocks ({{ $table_count['blocks_count'] ?? '0' }})</a></span><br />
                    @endif
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif


            @if(has_permision(['country','zones']))
            <div class="col-xxl-3 col-md-4">
              <div class="card info-card sales-card">                
                <div class="card-body">
                  <h5 class="card-title">Location</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="ps-3">     

                    @if(has_permision(['country']))                     
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('country.index') }}">- Country ({{ $table_count['country_count'] ?? '0' }})</a></span><br />
                    @endif

                    @if(has_permision(['zones']))    
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('zones.index') }}">- Zones ({{ $table_count['zones_count'] ?? '0' }})</a></span><br />
                    @endif
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif


            @if(has_permision(['document']))
            <div class="col-xxl-3 col-md-4">
              <div class="card info-card sales-card">                
                <div class="card-body">
                  <h5 class="card-title">Documents</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-bag-plus-fill"></i>
                    </div>
                    <div class="ps-3">  
                      
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('document-category.index') }}">- Category ({{ $table_count['document_category_count'] ?? '0' }})</a></span><br />
                    
                    <span class="text-muted small pt-2 ps-1"><a href="{{ route('document.index') }}">- Document ({{ $table_count['document_count'] ?? '0' }})</a></span><br />                    
                   
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif


            @if(has_permision(['banners']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('banner-category.index') }}">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Banners</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-images"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $table_count['banners_count'] ?? '0' }}</h6>                      
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif

            

            

            @if(has_permision(['faq']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('faq.index') }}">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">F.A.Q</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $table_count['faqs_count'] ?? '0' }}</h6>                      
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif

            @if(has_permision(['emailtemplates']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('email-templates.index') }}">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Email Templates</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-envelope"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $table_count['email_templates_count'] ?? '0' }}</h6>                      
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif

            @if(has_permision(['testimonial']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('testimonial.index') }}">
              <div class="card info-card revenue-card">  
                <div class="card-body">
                  <h5 class="card-title">Testimonial</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $table_count['testimonial_count'] ?? '0' }}</h6>                      
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif

            @if(has_permision(['contact']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('contact.index') }}">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Contact</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-menu-up"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $table_count['contacts_count'] ?? '0' }}</h6>                      
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif            

            @if(has_permision(['language']))     
            <div class="col-xxl-3 col-md-4">
              <a href="{{ route('language.index') }}">
              <div class="card info-card customers-card">  
                <div class="card-body">
                  <h5 class="card-title">Language</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-translate"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $table_count['language_count'] ?? '0' }}</h6>                      
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            @endif

          </div>
        </div>
      </div>
    </section>
    
@endsection