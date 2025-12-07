  <div class="main-header">
      <!-- Header -->
      <header
          class="header-three wow fadeInDown"
          data-wow-delay="0.3"
      >
          <div class="container">
              <div class="offcanvas-info">
                  <div class="offcanvas-wrap">
                      <div class="offcanvas-detail">
                          <div class="offcanvas-head">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                  <a
                                      href="/"
                                      class="black-logo-responsive"
                                  >
                                      <x-img
                                          src="assets/img/logo-dark.svg"
                                          alt="logo-img"
                                      />
                                  </a>
                                  <a
                                      href="/"
                                      class="white-logo-responsive"
                                  >
                                      <x-img
                                          src="assets/img/logo.svg"
                                          alt="logo-img"
                                      />
                                  </a>
                                  <div class="offcanvas-close">
                                      <i class="ti ti-x"></i>
                                  </div>
                              </div>
                              <div class="wishlist-info d-flex justify-content-between align-items-center">
                                  <h6 class="fs-16 fw-medium">Wishlist</h6>
                                  <div class="d-flex align-items-center">
                                      <div class="fav-dropdown">
                                          <a
                                              href="wishlist.html"
                                              class="position-relative"
                                          >
                                              <i class="isax isax-heart"></i><span
                                                  class="count-icon bg-secondary text-gray-9"
                                              >0</span>
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="mobile-menu fix mb-3"></div>
                          <div class="offcanvas__contact">
                              <div class="mt-4">
                                  <div class="header-dropdown d-flex flex-fill">
                                      <div class="w-100">
                                          <div class="dropdown flag-dropdown mb-2">
                                              <a
                                                  href="javascript:void(0);"
                                                  class="dropdown-toggle d-flex align-items-center border bg-white"
                                                  data-bs-toggle="dropdown"
                                                  aria-expanded="false"
                                              >
                                                  <img
                                                      src="assets/img/flags/us-flag.svg"
                                                      class="me-2"
                                                      alt="flag"
                                                  >ENG
                                              </a>
                                              <ul class="dropdown-menu p-2">
                                                  <li>
                                                      <a
                                                          class="dropdown-item d-flex align-items-center rounded"
                                                          href="javascript:void(0);"
                                                      >
                                                          <img
                                                              src="assets/img/flags/us-flag.svg"
                                                              class="me-2"
                                                              alt="flag"
                                                          >ENG
                                                      </a>
                                                  </li>
                                                  <li>
                                                      <a
                                                          class="dropdown-item d-flex align-items-center rounded"
                                                          href="javascript:void(0);"
                                                      >
                                                          <img
                                                              src="assets/img/flags/arab-flag.svg"
                                                              class="me-2"
                                                              alt="flag"
                                                          >ARA
                                                      </a>
                                                  </li>
                                                  <li>
                                                      <a
                                                          class="dropdown-item d-flex align-items-center rounded"
                                                          href="javascript:void(0);"
                                                      >
                                                          <img
                                                              src="assets/img/flags/france-flag.svg"
                                                              class="me-2"
                                                              alt="flag"
                                                          >FRA
                                                      </a>
                                                  </li>
                                              </ul>
                                          </div>
                                          <div class="dropdown">
                                              <a
                                                  href="javascript:void(0);"
                                                  class="dropdown-toggle d-block border bg-white"
                                                  data-bs-toggle="dropdown"
                                                  aria-expanded="false"
                                              >
                                                  USD
                                              </a>
                                              <ul class="dropdown-menu p-2">
                                                  <li><a
                                                          class="dropdown-item rounded"
                                                          href="javascript:void(0);"
                                                      >USD</a></li>
                                                  <li><a
                                                          class="dropdown-item rounded"
                                                          href="javascript:void(0);"
                                                      >YEN</a></li>
                                                  <li><a
                                                          class="dropdown-item rounded"
                                                          href="javascript:void(0);"
                                                      >EURO</a></li>
                                              </ul>
                                          </div>
                                      </div>
                                  </div>
                                  <div><a
                                          href="javascript:void(0);"
                                          class="btn btn-dark w-100 mb-3 text-white"
                                          data-bs-toggle="modal"
                                          data-bs-target="#login-modal"
                                      >Sign In</a></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="offcanvas-overlay"></div>
              <div class="header-nav">
                  <div class="main-menu-wrapper">
                      <div class="navbar-logo">
                          <a
                              class="logo-white header-logo"
                              href="/"
                          >
                              <x-img
                                  src="assets/img/logo-dark.svg"
                                  class="logo"
                                  alt="Logo"
                              />
                          </a>
                          <a
                              class="logo-dark header-logo"
                              href="/"
                          >
                              <x-img
                                  src="assets/img/logo.svg"
                                  class="logo"
                                  alt="Logo"
                              />
                          </a>
                      </div>
                      <nav id="mobile-menu">
                          <ul class="main-nav">
                              <li class="megamenu {{ Route::is('landing') ? 'active' : '' }}">
                                  <a href="/">Home</a>
                              </li>
                              <li class="megamenu {{ Route::is('bengkels*') ? 'active' : '' }}">
                                  <a href="{{ route('bengkels.grid') }}">Bengkel</a>
                              </li>
                          </ul>
                      </nav>
                      <div class="header-btn d-flex align-items-center">
                          @auth
                              <div class="cart-dropdown me-3">
                                  <a
                                      href="{{ route('dashboard') }}"
                                      class="position-relative"
                                  >
                                      <i class="isax isax-user"></i>
                                  </a>
                              </div>
                          @endauth
                          <div class="me-3">
                              <a
                                  href="javascript:void(0);"
                                  id="dark-mode-toggle"
                                  class="theme-toggle"
                              >
                                  <i class="isax isax-moon"></i>
                              </a>
                              <a
                                  href="javascript:void(0);"
                                  id="light-mode-toggle"
                                  class="theme-toggle"
                              >
                                  <i class="isax isax-sun-1"></i>
                              </a>
                          </div>
                          @auth
                              <div class="fav-dropdown me-3">
                                  <a
                                      href="wishlist.html"
                                      class="position-relative"
                                  >
                                      <i class="isax isax-heart"></i><span
                                          class="count-icon bg-secondary text-gray-9">0</span>
                                  </a>
                              </div>
                          @endauth
                          <div>
                              @guest
                                  <a
                                      href="{{ route('login') }}"
                                      class="fs-13 btn btn-dark btn-md text-white"
                                  >Sign In</a>
                              @endguest
                              @auth
                                  <a
                                      href="{{ route('logout') }}"
                                      class="fs-13 btn btn-primary btn-md text-white"
                                  >Logout</a>
                              @endauth
                          </div>
                          <div class="header__hamburger d-xl-none my-auto">
                              <div class="sidebar-menu">
                                  <i class="isax isax-menu5"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </header>
      <!-- /Header -->
  </div>
