<ul class="navbar-nav bg-white text-dark sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin-index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="far fa-check-square"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Quản lý</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin-index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Trang quản lý</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Quản lý
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="far fa-building"></i>
            <span>Phòng ban</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('department.index') }}">Danh sách phòng ban</a>
                <a class="collapse-item" href="{{ route('department.create') }}">Thêm phòng ban</a>
                <a class="collapse-item" href="{{ route('department-archived') }}">Phòng ban đã xóa</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-user-tie"></i>
            <span>Admin đơn vị</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('create-department-admin.create') }}">Tạo mới Admin đơn vị</a>
                <a class="collapse-item" href="{{ route('department-admin.index') }}">Danh sách Admin đơn vị</a>
                <a class="collapse-item" href="{{ route('department-admin-archived') }}">Admin đơn vị đã bị xóa</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Department User -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#nhansu" aria-expanded="true" aria-controls="nhansu">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Nhân sự - phòng ban</span>
        </a>
        <div id="nhansu" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('department-user.create') }}">Tạo mới nhân sự</a>
                <a class="collapse-item" href="{{ route('department-user.index') }}">Danh sách nhân sự</a>
                <a class="collapse-item" href="{{ route('department-user.trash') }}">nhân sự đã bị xóa</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Công văn/ Văn bản
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Loại văn bản</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('document-type.create') }}">Tạo mới loại văn bản</a>
                <div class="collapse-divider"></div>
                <a class="collapse-item" href="{{ route('document-type.index') }}">Danh sách loại văn bản</a>
                <a class="collapse-item" href="{{ route('document-type-archived') }}">Loại văn bản đã xóa</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
