 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">AdminLTE 3</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block">Alexander Pierce</a>
             </div>
         </div>

         <!-- SidebarSearch Form -->
         <div class="form-inline">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                     aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="{{ route('parents.index') }}" class="nav-link nav-color">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             categeory
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('puppies.index') }}" class="nav-link nav-color">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             Puppies
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('breeder-categories.index') }}" class="nav-link nav-color">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             Breeder Categories
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('adoptions.index') }}" class="nav-link nav-color">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             adoptions
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('questions.index') }}" class="nav-link nav-color">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             Questins
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('chat.index') }}" class="nav-link nav-color">
                         <i class="nav-icon fas fa-comments"></i>
                         <p>
                             Chats
                             <span id="sidebar-unread-count" class="badge bg-danger ms-2"
                                 style="{{ auth()->user()->receivedMessages()->where('is_read', false)->count() > 0 ? '' : 'display: none;' }}">
                                 {{ auth()->user()->receivedMessages()->where('is_read', false)->count() }}
                             </span>
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('breeders.profile', ['id' => auth()->user()->id]) }}"
                         class="nav-link nav-color">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             Your profile
                         </p>
                     </a>
                 </li>



             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
 <style>
     .nav-color {
         background: #444242 !important;
     }

     .nav-sidebar .nav-link p .badge {
    font-size: 0.65rem;
    padding: 0.25em 0.4em;
    font-weight: normal;
    vertical-align: middle;
    margin-left: 0.5rem;
}
 </style>
@vite(['resources/js/app.js'])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script>
document.addEventListener('DOMContentLoaded', function() {
    const currentUserId = {{ auth()->id() }};
    
    if (typeof window.Echo !== 'undefined') {
        window.Echo.private(`user.${currentUserId}`)
            .listen('.ChatMessageSent', (data) => {
                updateSidebarUnreadCount(1);
            });
    }

    function updateSidebarUnreadCount(change) {
        let badgeElement = document.getElementById('sidebar-unread-count');
        let currentCount = 0;
        
        if (badgeElement) {
            currentCount = parseInt(badgeElement.innerText) || 0;
        } else {
            // Create the badge if it doesn't exist
            const pElement = document.querySelector('a[href="{{ route("chat.index") }}"] p');
            badgeElement = document.createElement('span');
            badgeElement.id = 'sidebar-unread-count';
            badgeElement.className = 'badge bg-danger ms-2';
            pElement.appendChild(badgeElement);
        }
        
        const newCount = Math.max(0, currentCount + change);
        badgeElement.innerText = newCount;
        
        // Show or hide based on count
        badgeElement.style.display = newCount > 0 ? 'inline-block' : 'none';
        
        console.log('Sidebar unread count updated to:', newCount);
    }
    
    // Make function available globally
    window.updateSidebarUnreadCount = updateSidebarUnreadCount;
});
</script>
