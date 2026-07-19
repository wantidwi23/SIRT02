<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('index') ?? '/' }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('assets/img/logo.png') }}" alt="">
        <h1 class="sitename">SiRT02.Id</h1>
      </a>

      <div style="display: flex; align-items: center; gap: 30px;">
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="/" >Home</a></li>
            <li><a href="{{ route('news.index') }}">Berita</a></li>
            @if (auth()->check() || session('head_of_family_id'))
              @if (session('head_of_family_id'))
                <!-- HeadOfFamily menu -->
                <li><a href="{{ route('reports.index') }}">Laporan</a></li>
                <li><a href="{{ route('letters.index') }}">Surat</a></li>
                <li><a href="javascript:void(0)" onclick="openChatbot()">Chatbot</a></li>
              @elseif(auth()->user()->role !== 'admin')
                <li><a href="{{ route('reports.index') }}">Laporan</a></li>
                <li><a href="{{ route('letters.index') }}">Surat</a></li>
                <li><a href="javascript:void(0)" onclick="openChatbot()">Chatbot</a></li>
              @else
                <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
              @endif
            @endif
          </ul>
        </nav>

        <div class="header-social-links" style="display: flex; align-items: center; gap: 12px;">
          @if (auth()->check() || session('head_of_family_id'))
            <div class="dropdown">
              <a href="#" class="d-flex align-items-center gap-2" style="text-decoration: none; color: inherit; cursor: pointer;" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle" style="font-size: 1.5rem; color: #6bb8a1;"></i>
                <span style="color: #333;">
                  @if (session('head_of_family_id'))
                    {{ session('head_of_family_name') }}
                  @else
                    {{ auth()->user()->name }}
                  @endif
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                @if (session('head_of_family_id'))
                  <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                  <li><a class="dropdown-item" href="{{ route('password.change') }}">Ubah Password</a></li>
                @elseif (auth()->check())
                  @if(auth()->user()->role === 'admin')
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                  @else
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                  @endif
                  <li><a class="dropdown-item" href="{{ route('password.change') }}">Ubah Password</a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          @else
            <a href="{{ route('login') }}" class="btn btn-auth-primary" style="padding: 0.6rem 1.5rem; font-weight: 500; border-radius: 25px; background: linear-gradient(135deg, #6bb8a1 0%, #5a9b89 100%); border: none; color: white; box-shadow: 0px 4px 12px rgba(107, 184, 161, 0.25); transition: all 0.3s ease;">Login</a>
          @endif
        </div>
      </div>

    </div>
  </header>

  <script>
    function openChatbot() {
      const toggleBtn = document.getElementById('chatbot-toggle-btn');
      if (toggleBtn) {
        toggleBtn.click();
      }
    }
  </script>
