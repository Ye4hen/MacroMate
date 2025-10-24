<aside
    id="sidebar"
    class="fixed top-0 left-0 min-h-screen w-16 lg:w-64 bg-mm-dark-blue border-r border-mm-border transition-all duration-300 ease-in-out overflow-y-auto overflow-x-hidden z-100"
>
    <div
        id="sidebar-top"
        class="flex flex-col lg:flex-row items-center justify-center p-2 gap-x-5 border-b border-mm-border"
    >
        <h2
            id="sidebar-title-mobile"
            class="block lg:hidden text-lg md:text-xl font-bold text-center transition-opacity duration-300 ease-in-out"
        >
            MM
        </h2>
        <button
            id="sidebar-toggle"
            type="button"
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-mm-gray focus:outline-none cursor-pointer transition-transform duration-300 ease-in-out"
        >
            <span class="sr-only">Open sidebar</span>
            <svg
                id="toggle-icon"
                class="w-6 h-6 transform transition-transform duration-300 ease-in-out"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                ></path>
            </svg>
        </button>

        <h2
            id="sidebar-title"
            class="hidden lg:block md:pr-2 text-lg md:text-xl font-bold text-center transition-opacity duration-300 ease-in-out"
        >
            MacroMate
        </h2>
    </div>
    <nav
        id="sidebar-nav"
        class="hidden lg:block lg:h-[calc(100svh-55px)] h-[calc(100svh-85px)] overflow-y-auto transition-opacity duration-300 ease-in-out"
    >
        <ul>
            <li>
                <a
                    href="{{ route("dashboard") }}"
                    @class(["menu-link", "menu-link--active" => request()->routeIs("dashboard")])
                    {{ request()->routeIs("dashboard") ? "aria-current=page" : "" }}
                >
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a
                    href="{{ route("profile") }}"
                    @class(["menu-link", "menu-link--active" => request()->routeIs("profile")])
                    {{ request()->routeIs("profile") ? "aria-current=page" : "" }}
                >
                    <i class="fas fa-user-cog mr-3"></i>
                    Account Settings
                </a>
            </li>
            <li>
                <a
                    href="{{ route("profile-body-metrics") }}"
                    @class([
                        "menu-link",
                        "menu-link--active" => request()->routeIs("profile-body-metrics"),
                    ])
                    {{ request()->routeIs("profile-body-metrics") ? "aria-current=page" : "" }}
                >
                    <i class="fas fa-dumbbell mr-3"></i>
                    Body Metrics
                </a>
            </li>
            <li>
                <a
                    href="{{ route("profile-plan") }}"
                    @class(["menu-link", "menu-link--active" => request()->routeIs("profile-plan")])
                    {{ request()->routeIs("profile-plan") ? "aria-current=page" : "" }}
                >
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Plan
                </a>
            </li>
            <li>
                <a
                    href="{{ route("profile-macros") }}"
                    @class([
                        "menu-link",
                        "menu-link--active" => request()->routeIs("profile-macros"),
                    ])
                    {{ request()->routeIs("profile-macros") ? "aria-current=page" : "" }}
                >
                    <i class="fas fa-drumstick-bite mr-3"></i>
                    Macros
                </a>
            </li>
            <li>
                <a
                    href="{{ route("profile-summary") }}"
                    @class([
                        "menu-link",
                        "menu-link--active" => request()->routeIs("profile-summary"),
                    ])
                    {{ request()->routeIs("profile-summary") ? "aria-current=page" : "" }}
                >
                    <i class="fas fa-chart-pie mr-3"></i>
                    Summary
                </a>
            </li>
            @if ($user->isAdmin())
                <li>
                    <button
                        type="button"
                        class="menu-link justify-between w-full"
                        data-collapse-toggle="admin-submenu"
                    >
                        <span class="flex md:flex-nowrap items-center">
                            <i class="fa-solid fa-user-tie mr-3"></i>
                            Admin Panel
                        </span>
                        <svg
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <ul id="admin-submenu" class="hidden py-2">
                        <li>
                            <a
                                href="{{ route("admin.activities.index") }}"
                                @class([
                                    "menu-link pr-2 pl-3 md:pl-9",
                                    "menu-link--active" => request()->routeIs("admin.activities.index"),
                                ])
                                {{ request()->routeIs("admin.activities.index") ? "aria-current=page" : "" }}
                            >
                                <i class="fa-solid fa-person-running mr-3"></i>
                                Activities
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route("admin.foods.index") }}"
                                @class([
                                    "menu-link pr-2 pl-3 md:pl-9",
                                    "menu-link--active" => request()->routeIs("admin.foods.index"),
                                ])
                                {{ request()->routeIs("admin.foods.index") ? "aria-current=page" : "" }}
                            >
                                <i class="fa-solid fa-bowl-food mr-3"></i>
                                Foods
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route("admin.plans.index") }}"
                                @class([
                                    "menu-link pr-2 pl-3 md:pl-9",
                                    "menu-link--active" => request()->routeIs("admin.plans.index"),
                                ])
                                {{ request()->routeIs("admin.plans.index") ? "aria-current=page" : "" }}
                            >
                                <i class="fas fa-calendar-alt mr-3"></i>
                                Plans
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route("admin.users.index") }}"
                                @class([
                                    "menu-link pr-2 pl-3 md:pl-9",
                                    "menu-link--active" => request()->routeIs("admin.users.index"),
                                ])
                                {{ request()->routeIs("admin.users.index") ? "aria-current=page" : "" }}
                            >
                                <i class="fa-solid fa-users mr-3"></i>
                                Users
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</aside>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggle_btn = document.getElementById('sidebar-toggle');
    const nav = document.querySelector('#sidebar-nav');
    const sidebar_top = document.getElementById('sidebar-top');
    const title = document.getElementById('sidebar-title');
    const title_mobile = document.getElementById('sidebar-title-mobile');
    const toggle_icon = document.getElementById('toggle-icon');

    toggle_btn.addEventListener('click', () => {
        const is_mobile = window.innerWidth < 1024;
        if (is_mobile) {
            sidebar.classList.toggle('!w-64');
            nav.classList.toggle('!block');
            title.classList.toggle('!opacity-100');
            title.classList.toggle('!block');
            title_mobile.classList.toggle('!hidden');
        } else {
            sidebar.classList.toggle('!w-16');
            sidebar_top.classList.toggle('lg:flex-row');
            nav.classList.toggle('!opacity-0');
            title.classList.toggle('!opacity-0');
            title.classList.toggle('!hidden');
            title_mobile.classList.toggle('!block');
        }
        toggle_icon.classList.toggle('rotate-180');
    });
</script>
