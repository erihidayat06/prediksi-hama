 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link {{ Request::is('admin') ? '' : 'collapsed' }}" href="/admin">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li><!-- End Dashboard Nav -->
         {{-- <li class="nav-item">
             <a class="nav-link {{ Request::is('admin/bio*') ? '' : 'collapsed' }}" href="/admin/bio">
                 <i class="bi bi-card-list"></i>
                 <span>Bio informasi hama</span>
             </a>
         </li><!-- End Dashboard Nav --> --}}

         <li class="nav-heading">Management informasi</li>

         {{-- Sidebar Padi --}}
         <li class="nav-item">
             <a class="nav-link {{ request()->is('admin/tanaman/padi*') ? '' : 'collapsed' }}"
                 data-bs-target="#padi-nav" data-bs-toggle="collapse" href="#">
                 <img src="/img/pngtree-rice-plant-illustration-png-image_6120558.png" width="15%" alt="">
                 <span class="ms-2">Padi</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="padi-nav" class="nav-content collapse {{ request()->is('admin/tanaman/padi*') ? 'show' : '' }}"
                 data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ url('admin/tanaman/padi/gap') }}"
                         class="{{ request()->is('admin/tanaman/padi/gap*') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Good Agricultural Practice</span>
                     </a>
                 </li>
                 {{-- <li>
                     <a href="{{ url('admin/tanaman/padi/komoditi') }}"
                         class="{{ request()->is('admin/tanaman/padi/komoditi') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Info Komoditi</span>
                     </a>
                 </li> --}}
                 <li>
                     <a href="{{ url('admin/tanaman/padi/panduan') }}"
                         class="{{ request()->is('admin/tanaman/padi/panduan') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Panduan Penggunaan Pestisida</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ url('admin/tanaman/padi/bio') }}"
                         class="{{ request()->is('admin/tanaman/padi/bio') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Bio Informasi Hama dan Penyakit</span>
                     </a>
                 </li>
             </ul>
         </li>

         <li class="nav-item">
             <a class="nav-link {{ request()->is('admin/tanaman/cabai*') ? '' : 'collapsed' }}"
                 data-bs-target="#cabai-nav" data-bs-toggle="collapse" href="#">
                 <img src="/img/chilli-303865_1280.png" width="15%" alt="">
                 <span class="ms-2">Cabai</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="cabai-nav" class="nav-content collapse {{ request()->is('admin/tanaman/cabai*') ? 'show' : '' }}"
                 data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ url('admin/tanaman/cabai/gap') }}"
                         class="{{ request()->is('admin/tanaman/cabai/gap') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Good Agricultural Practice</span>
                     </a>
                 </li>
                 {{-- <li>
                     <a href="{{ url('admin/tanaman/cabai/komoditi') }}"
                         class="{{ request()->is('admin/tanaman/cabai/komoditi') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Info Komoditi</span>
                     </a>
                 </li> --}}
                 <li>
                     <a href="{{ url('admin/tanaman/cabai/panduan') }}"
                         class="{{ request()->is('admin/tanaman/cabai/panduan') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Panduan Penggunaan Pestisida</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ url('admin/tanaman/cabai/bio') }}"
                         class="{{ request()->is('admin/tanaman/cabai/bio') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Bio Informasi Hama dan Penyakit</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End Tables Nav -->
         <li class="nav-item">
             <a class="nav-link {{ request()->is('admin/tanaman/bawang-merah*') ? '' : 'collapsed' }}"
                 data-bs-target="#bawang-merah-nav" data-bs-toggle="collapse" href="#">
                 <img src="/img/pngtree-cartoon-onion-png-image_5880025.png" width="15%" alt="">
                 <span class="ms-2">bawang-merah</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="bawang-merah-nav"
                 class="nav-content collapse {{ request()->is('admin/tanaman/bawang-merah*') ? 'show' : '' }}"
                 data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ url('admin/tanaman/bawang-merah/gap') }}"
                         class="{{ request()->is('admin/tanaman/bawang-merah/gap') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Good Agricultural Practice</span>
                     </a>
                 </li>
                 {{-- <li>
                     <a href="{{ url('admin/tanaman/bawang-merah/komoditi') }}"
                         class="{{ request()->is('admin/tanaman/bawang-merah/komoditi') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Info Komoditi</span>
                     </a>
                 </li> --}}
                 <li>
                     <a href="{{ url('admin/tanaman/bawang-merah/panduan') }}"
                         class="{{ request()->is('admin/tanaman/bawang-merah/panduan') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Panduan Penggunaan Pestisida</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ url('admin/tanaman/bawang-merah/bio') }}"
                         class="{{ request()->is('admin/tanaman/bawang-merah/bio') ? 'active' : '' }}">
                         <i class="bi bi-circle"></i><span>Bio Informasi Hama dan Penyakit</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End Tables Nav -->


         <li class="nav-heading">Pestisida</li>
         <li class="nav-item">
             <a class="nav-link {{ Request::is('admin/golongan*') ? '' : 'collapsed' }}" href="/admin/golongan">
                 <i class="bi bi-list-columns-reverse"></i>
                 <span class="ms-2">Golongan Pestisida</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link {{ Request::is('admin/insektisida*') ? '' : 'collapsed' }}" href="/admin/insektisida">
                 <i class="bi bi-journal-bookmark"></i>
                 <span class="ms-2">Insektisida Resisten</span>
             </a>
         </li>


         {{-- <li class="nav-item">
             <a class="nav-link {{ Request::is('admin/tanaman/padi*') ? '' : 'collapsed' }}" href="/admin/tanaman/padi">
                 <img src="/img/pngtree-rice-plant-illustration-png-image_6120558.png" width="15%" alt="">
                 <span class="ms-2">Padi</span>
             </a>
         </li><!-- End Dashboard Nav -->
         <li class="nav-item">
             <a class="nav-link {{ Request::is('admin/tanaman/cabai*') ? '' : 'collapsed' }}"
                 href="/admin/tanaman/cabai">
                 <img src="/img/chilli-303865_1280.png" width="15%" alt="">
                 <span class="ms-2">Cabai</span>
             </a>
         </li><!-- End Dashboard Nav -->
         <li class="nav-item">
             <a class="nav-link {{ Request::is('admin/tanaman/bawang-merah*') ? '' : 'collapsed' }}"
                 href="/admin/tanaman/bawang-merah">
                 <img src="/img/pngtree-cartoon-onion-png-image_5880025.png" width="15%" alt="">
                 <span class="ms-2">Bawamg Merah</span>
             </a>
         </li><!-- End Dashboard Nav --> --}}

     </ul>

 </aside><!-- End Sidebar-->
