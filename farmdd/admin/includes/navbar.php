 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <!-- Left navbar links -->
   <ul class="navbar-nav">
     <li class="nav-item">
       <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
     </li>
     <li class="nav-item d-none d-sm-inline-block">
       <a href="index.php" class="nav-link">Home</a>
     </li>
   </ul>

   <!-- Right navbar links -->
   <ul class="navbar-nav ml-auto">
     <li class="nav-item">
       <button onclick="localStorage.login = '', window.location = 'login.php';" class="btn btn-danger" type="submit" id="logout" name="logout"><i class="fas fa-sign-out-alt"></i></button>
     </li>
   </ul>
 </nav>
 <!-- /.navbar -->

 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="index.php" class="brand-link text-center" style="text-decoration: none;">
     <h4 class="brand-text">ของดีบนดอย</h4>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <div class="row">
           <!-- <i class="fas fa-user-shield text-white p-1"></i> -->
         </div>
         <!-- <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
       </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
           <a href="index.php" class="nav-link">
             <i class="nav-icon fas fa-chart-line"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="member.php" class="nav-link">
             <i class="nav-icon fas fa-users"></i>
             <p>
               จัดการสมาชิก
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="product.php" class="nav-link">
             <i class="nav-icon fas fa-shopping-basket"></i>
             <p>
               จัดการสินค้า
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="content.php?contentType=ข่าวประชาสัมพันธ์" class="nav-link">
             <i class="nav-icon fas fa-pen"></i>
             <p>
               จัดการข่าวประชาสัมพันธ์
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="content.php?contentType=แนะนำผลผลิต" class="nav-link">
             <i class="nav-icon fas fa-pen"></i>
             <p>
               จัดการแนะนำผลผลิต
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="edit_aboutus.php?id=1" class="nav-link">
             <i class="nav-icon fas fa-info-circle"></i>
             <p>
               จัดการเมนูเกี่ยวกับเรา
             </p>
           </a>
         </li>
         <!-- <li class="nav-item">
           <a href="slideshow.php" class="nav-link">
             <i class="nav-icon fas fa-images"></i>
             <p>
               จัดการ SlideShow
             </p>
           </a>
         </li> -->
         <!-- <li class="nav-item has-treeview">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-copy"></i>
             <p>
               Layout Options
               <i class="fas fa-angle-left right"></i>
               <span class="badge badge-info right">6</span>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="pages/layout/top-nav.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Top Navigation</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Top Navigation + Sidebar</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/boxed.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Boxed</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Fixed Sidebar</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/fixed-topnav.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Fixed Navbar</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/fixed-footer.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Fixed Footer</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Collapsed Sidebar</p>
               </a>
             </li>
           </ul>
         </li> -->
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>