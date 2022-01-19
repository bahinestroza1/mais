<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"> MAIS - SENA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @if (Auth::check())
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{Auth::user()->rol->nombre}}</a>
          </div>
        </div>
      @endif

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{route('home')}}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Inicio
                </p>
              </a>
            </li>

            @if(Auth::check())
              @if(tiene_rol(1,2))
                <li class="nav-item has-treeview @yield('menu-administrador','')">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>
                      Administración
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                
                <ul class="nav nav-treeview">
                  @if(tiene_rol(1,2))
                    <li class="nav-item">
                        <a href="{{route('gestion_municipios')}}" class="nav-link @yield('menu-administrador-gestion_municipios','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Gestión de Municipios
                          </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('gestion_usuarios')}}" class="nav-link @yield('menu-administrador-gestion_usuario','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Gestión de Usuarios
                          </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('gestion_funcionarios')}}" class="nav-link @yield('menu-administrador-gestion_funcionarios','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Gestión de Funcionarios
                          </p>
                        </a>
                    </li>
                    @endif
                    @if(false)
                      <li class="nav-item">
                          <a href="{{route('gestion_servicios')}}" class="nav-link @yield('menu-administrador-gestion_servicio','')">
                            <i class="nav-icon fas fa-circle-notch"></i>
                            <p>
                                Gestión de Servicios
                            </p>
                          </a>
                      </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{route('gestion_ofertas')}}" class="nav-link @yield('menu-administrador-gestion_oferta','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Gestión de Ofertas
                          </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('gestion_programas')}}" class="nav-link @yield('menu-administrador-gestion_programa','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Gestión de Programas
                          </p>
                        </a>
                    </li>
                  </ul>
                </li>
              @endif 
              @if(tiene_rol(1,2,3,4))
                <li class="nav-item has-treeview @yield('menu-servicios','')">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-sitemap"></i>
                    <p>
                      Servicios
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('ver_ofertas')}}" class="nav-link @yield('menu-servicios-oferta','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Oferta Programas SENA
                          </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('ver_ofertas_competencias')}}" class="nav-link @yield('menu-servicios-oferta-competencia','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Oferta Competencias SENA
                          </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('ver_solicitudes')}}" class="nav-link @yield('menu-servicios-solicitudes','')">
                          <i class="nav-icon fas fa-circle-notch"></i>
                          <p>
                              Solicitudes SENA
                          </p>
                        </a>
                    </li>
                  </ul>
                </li>
              @endif                                    
            @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>