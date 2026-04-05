 <nav class="side-nav">
     <a href="{{ route('dash') }}" class="intro-x flex items-center pl-5 pt-4">
         <img alt="logo" class="w-12" src="{{ asset('dist/images/food-truck.png') }}">
         <span class="hidden xl:block text-white text-lg ml-3"> fast<span class="font-medium">Food</span> </span>
     </a>
     <div class="side-nav__devider my-6"></div>
     <ul>

         <li>
             <a href="{{ url('categories') }}" class="side-menu">
                 <div class="side-menu__icon"> <i data-feather="layers"></i> </div>
                 <div class="side-menu__title"> CATEGORIAS </div>
             </a>
         </li>
         <li>
             <a href="{{ url('products') }}" class="side-menu">
                 <div class="side-menu__icon"> <i data-feather="coffee"></i> </div>
                 <div class="side-menu__title"> PRODUCTOS </div>
             </a>
         </li>
         <li>
             <a href="{{ url('sales') }}" class="side-menu">
                 <div class="side-menu__icon"> <i data-feather="shopping-cart"></i> </div>
                 <div class="side-menu__title"> VENTAS</div>
             </a>
         </li>
         <li class="side-nav__devider my-6"></li>

         <li>
             <a href="{{ url('customers') }}" class="side-menu">
                 <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                 <div class="side-menu__title"> CLIENTES </div>
             </a>
         </li>
         <li>
             <a href="{{ url('users') }}" class="side-menu">
                 <div class="side-menu__icon"> <i data-feather="key"></i> </div>
                 <div class="side-menu__title"> USUARIOS </div>
             </a>
         </li>

         <li class="side-nav__devider my-6"></li>

         <li>
             <a href="{{ url('reports') }}" class="side-menu">
                 <div class="side-menu__icon"> <i data-feather="calendar"></i> </div>
                 <div class="side-menu__title"> REPORTES </div>
             </a>
         </li>
         <li class="side-nav__devider my-6"></li>


         <li>
             <a href="{{ url('settings') }}" class="side-menu">
                 <div class="side-menu__icon"> <i data-feather="settings"></i> </div>
                 <div class="side-menu__title"> SETTINGS </div>
             </a>
         </li>



     </ul>
 </nav>