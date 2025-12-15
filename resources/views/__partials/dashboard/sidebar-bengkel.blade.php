 <div class="col-xl-3 col-lg-4 theiaStickySidebar">
     <div class="card user-sidebar agent-sidebar mb-lg-0 mb-4">
         <div class="card-header user-sidebar-header bg-gray-transparent text-center">
             <div class="agent-profile d-inline-flex">
                 <x-img src="assets/img/users/user-43.jpg" alt="image" class="img-fluid rounded-circle" />
                 <a href="{{ route('my-bengkel.settings.index') }}"
                     class="avatar avatar-sm rounded-circle btn btn-primary d-flex align-items-center justify-content-center p-0"><i
                         class="isax isax-edit-2 fs-14"></i></a>
             </div>
             <h6 class="fs-16">{{ auth()->user()->name }}</h6>
             <p class="mb-2 badge bg-primary">{{ auth()->user()->role }}</p>
             <div class="d-flex align-items-center justify-content-center notify-item">
                 <a href="javascript:void(0);"
                     class="rounded-circle btn btn-white d-flex align-items-center justify-content-center position-relative me-2 p-0">
                     <i class="isax isax-notification-bing5 fs-20"></i>
                     <span class="position-absolute bg-secondary rounded-circle p-1"></span>
                 </a>
                 <a href="javascript:void(0);"
                     class="rounded-circle btn btn-white d-flex align-items-center justify-content-center position-relative p-0">
                     <i class="isax isax-message-square5 fs-20"></i>
                     <span class="position-absolute bg-danger rounded-circle p-1"></span>
                 </a>
             </div>
         </div>
         <div class="card-body user-sidebar-body">
             <ul>
                 <li>
                     <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                         <i class="isax isax-element-2 me-2"></i>Dashboard
                     </a>
                 </li>

                 <li>
                     <div class="message-content">
                         <a href="{{ route('bengkel.service-requests.index') }}" class="d-flex align-items-center">
                             <i class="isax isax-danger"></i> Request Darurat
                         </a>
                     </div>
                 </li>

                 <li>
                     <a href="{{ route('my-bengkel.services.index') }}" class="d-flex align-items-center">
                         <i class="isax isax-setting-2 me-2"></i>Service
                     </a>
                 </li>

                 <li>
                     <a href="{{ route('my-bengkel.settings.index') }}" class="d-flex align-items-center">
                         <i class="isax isax-user me-2"></i>Account
                     </a>
                 </li>

                 <li class="logout-link">
                     <a href="{{ route('logout') }}" class="d-flex align-items-center pb-0">
                         <i class="isax isax-logout-1 me-2"></i>Logout
                     </a>
                 </li>
             </ul>

         </div>
     </div>
 </div>
