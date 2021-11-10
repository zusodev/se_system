<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item">
                <a class="nav-link" data-url="reports" href="{{ route("report.index") }}">
                    <i class="far fa-file-word fa-1-5x m-1"></i>
                    <span class="menu-title">報表</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-users fa-1-5x m-1"></i>
                    <span class="menu-title">用戶管理</span>
                    <i class="menu-arrow"></i></a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" data-url="users" href="{{ route("users.index") }}">
                                系統使用者管理
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-url="target_companys" href="{{ route("target_companys.index") }}">
                                目標公司
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-mountain fa-1-5x m-1"></i>
                    <span class="menu-title">信件與網站樣式</span>
                    <i class="menu-arrow"></i></a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" data-url="email_templates"
                               href="{{ route("email_templates.index") }}">
                                信件樣式管理
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-url="phishing_websites"
                               href="{{ route("phishing_websites.index") }}">
                                釣魚網站樣式管理
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-envelope fa-1-5x m-1"></i>
                    <span class="menu-title">寄件專案與 Log</span>
                    <i class="menu-arrow"></i></a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" data-url="email_projects"
                               href="{{ route("email_projects.index") }}">
                                寄件專案
                            </a>
                        </li>
                        {{--<li class="nav-item">
                            <a class="nav-link" data-url="email_jobs"
                               href="{{ route("email_jobs.index") }}">
                                寄件專案部門
                            </a>
                        </li>--}}
                        <li class="nav-item">
                            <a class="nav-link" data-url="email_logs" href="{{ route("email_logs.index") }}">
                                寄件 Log
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-url="system_logs" href="{{ route("system_logs.index") }}">
                    <i class="far fa-file fa-1-5x m-1"></i>
                    <span class="menu-title">系統日誌</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
