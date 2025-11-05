<div class="col-xl-3 col-lg-4 theiaStickySidebar">
     <div class="card user-sidebar agent-sidebar mb-lg-0 mb-4">
         <div class="card-header user-sidebar-header bg-gray-transparent text-center">
             <div class="agent-profile d-inline-flex">
                 <x-img
                     src="assets/img/users/user-43.jpg"
                     alt="image"
                     class="img-fluid rounded-circle"
                 />
                 <a
                     href="agent-settings.html"
                     class="avatar avatar-sm rounded-circle btn btn-primary d-flex align-items-center justify-content-center p-0"
                 ><i class="isax isax-edit-2 fs-14"></i></a>
             </div>
             <h6 class="fs-16">{{ auth()->user()->name }}</h6>
             <p class="mb-2 badge bg-primary">{{ auth()->user()->role }}</p>
             <div class="d-flex align-items-center justify-content-center notify-item">
                 <a
                     href="agent-notifications.html"
                     class="rounded-circle btn btn-white d-flex align-items-center justify-content-center position-relative me-2 p-0"
                 >
                     <i class="isax isax-notification-bing5 fs-20"></i>
                     <span class="position-absolute bg-secondary rounded-circle p-1"></span>
                 </a>
                 <a
                     href="agent-chat.html"
                     class="rounded-circle btn btn-white d-flex align-items-center justify-content-center position-relative p-0"
                 >
                     <i class="isax isax-message-square5 fs-20"></i>
                     <span class="position-absolute bg-danger rounded-circle p-1"></span>
                 </a>
             </div>
         </div>
         <div class="card-body user-sidebar-body">
             <ul>
                 <li>
                     <a
                         href="agent-dashboard.html"
                         class="d-flex align-items-center active"
                     >
                         <i class="isax isax-grid-55 me-2"></i>Dashboard
                     </a>
                 </li>
                 <li>
                     <a
                         href="agent-listings.html"
                         class="d-flex align-items-center"
                     >
                         <i class="isax isax-menu-14 me-2"></i>Listings
                     </a>
                 </li>
                 <li class="submenu">
                     <a
                         href="javascript:void(0);"
                         class="d-block"
                     ><i class="isax isax-calendar-tick5 me-2"></i><span>Bookings</span><span
                             class="menu-arrow"></span></a>
                     <ul>
                         <li>
                             <a
                                 href="agent-hotel-booking.html"
                                 class="fs-14 d-inline-flex align-items-center"
                             >Hotels</a>
                         </li>
                         <li>
                             <a
                                 href="agent-car-booking.html"
                                 class="fs-14 d-inline-flex align-items-center"
                             >Cars</a>
                         </li>
                         <li>
                             <a
                                 href="agent-cruise-booking.html"
                                 class="fs-14 d-inline-flex align-items-center"
                             >Cruise</a>
                         </li>
                         <li>
                             <a
                                 href="agent-tour-booking.html"
                                 class="fs-14 d-inline-flex align-items-center"
                             >Tour</a>
                         </li>
                         <li>
                             <a
                                 href="agent-flight-booking.html"
                                 class="fs-14 d-inline-flex align-items-center"
                             >Flights</a>
                         </li>
                     </ul>
                 </li>
                 <li>
                     <a
                         href="agent-enquirers.html"
                         class="d-flex align-items-center"
                     >
                         <i class="isax isax-magic-star5 me-2"></i>Enquiries
                     </a>
                 </li>
                 <li>
                     <a
                         href="agent-earnings.html"
                         class="d-flex align-items-center"
                     >
                         <i class="isax isax-wallet-add-15 me-2"></i>Earnings
                     </a>
                 </li>
                 <li>
                     <a
                         href="agent-review.html"
                         class="d-flex align-items-center"
                     >
                         <i class="isax isax-magic-star5 me-2"></i>Reviews
                     </a>
                 </li>
                 <li>
                     <a
                         href="agent-settings.html"
                         class="d-flex align-items-center"
                     >
                         <i class="isax isax-setting-25"></i> Settings
                     </a>
                 </li>
                 <li class="logout-link">
                     <a
                         href="{{ route('logout') }}"
                         class="d-flex align-items-center pb-0"
                     >
                         <i class="isax isax-logout-15"></i> Logout
                     </a>
                 </li>
             </ul>
         </div>
     </div>
 </div>
