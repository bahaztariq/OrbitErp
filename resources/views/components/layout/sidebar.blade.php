<aside
    :class="{
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen,
        'xl:w-[290px]': $store.sidebar.isExpanded,
        'xl:w-[90px]': !$store.sidebar.isExpanded
    }"
    class="fixed left-0 top-0 z-50 flex h-screen flex-col border-r border-gray-200 bg-white transition-all duration-300 ease-in-out">


    <!-- Company Switcher (Notion Style) -->
    <x-layout.company-switcher />

    <!-- Navigation -->
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar grow px-4">
        @php
            $company = $company ?? request()->route('company');
        @endphp
        <nav x-data="{ selected: '{{ Request::routeIs('dashboard') ? 'dashboard' : (Request::segment(3) ?? '') }}' }">
            <ul class="space-y-0.5">
                <!-- Dashboard -->
                <li>
                    <a href="{{ isset($company) ? (is_object($company) ? route('companies.show', $company->slug) : route('companies.show', $company)) : route('companies.index') }}" 
                       class="menu-item {{ Request::routeIs('companies.show') || Request::routeIs('companies.index') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Dashboard</span>
                    </a>
                </li>

                @if(isset($company))
                <!-- AI Assistant -->
                <li class="pt-1.5 pb-1">
                    <span x-show="$store.sidebar.isExpanded"
                          class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">AI</span>
                    <hr x-show="!$store.sidebar.isExpanded" class="border-gray-100 mx-2">
                </li>
                <li>
                    <a href="{{ route('ai.assistant', $company->slug) }}"
                       class="menu-item {{ Request::routeIs('ai.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.346.346a1 1 0 01-.707.293H10.03a1 1 0 01-.707-.293l-.346-.346z"/>
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">AI Assistant</span>
                    </a>
                </li>
                <!-- Sales Group -->
                <li class="pt-1.5 pb-1">
                    <span x-show="$store.sidebar.isExpanded" 
                          class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Sales</span>
                    <hr x-show="!$store.sidebar.isExpanded" class="border-gray-100 mx-2">
                </li>

                @can('view-any-clients', App\Models\Client::class)
                <li>
                    <a href="{{ route('clients.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('clients.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Clients</span>
                     </a>
                </li>
                @endcan

                @can('view-any-invoices', App\Models\Invoice::class)
                <li>
                    <a href="{{ route('invoices.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('invoices.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Invoices</span>
                    </a>
                </li>
                @endcan

                @can('view-any-orders', App\Models\Order::class)
                <li>
                    <a href="{{ route('orders.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('orders.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Orders</span>
                    </a>
                </li>
                @endcan

                @can('view-any-payments', App\Models\Payment::class)
                <li>
                    <a href="{{ route('payments.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('payments.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Payments</span>
                    </a>
                </li>
                @endcan

                <!-- Inventory Group -->
                <li class="pt-1.5 pb-1">
                    <span x-show="$store.sidebar.isExpanded" 
                          class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Inventory</span>
                    <hr x-show="!$store.sidebar.isExpanded" class="border-gray-100 mx-2">
                </li>

                @can('view-any-products', App\Models\Product::class)
                <li>
                    <a href="{{ route('products.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('products.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Products</span>
                    </a>
                </li>
                @endcan

                @can('view-any-categories', App\Models\Category::class)
                <li>
                    <a href="{{ route('categories.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('categories.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Categories</span>
                    </a>
                </li>
                @endcan

                @can('view-any-suppliers', App\Models\Supplier::class)
                <li>
                    <a href="{{ route('suppliers.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('suppliers.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Suppliers</span>
                    </a>
                </li>
                @endcan

                <!-- Collaboration Group -->
                <li class="pt-1.5 pb-1">
                    <span x-show="$store.sidebar.isExpanded" 
                          class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Collaboration</span>
                    <hr x-show="!$store.sidebar.isExpanded" class="border-gray-100 mx-2">
                </li>

                @can('view-any-tasks', App\Models\Task::class)
                <li>
                    <a href="{{ route('tasks.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('tasks.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Tasks</span>
                    </a>
                </li>
                @endcan

                @can('view-any-calender-events', App\Models\CalenderEvent::class)
                <li>
                    <a href="{{ route('calender-events.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('calender-events.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Calendar</span>
                    </a>
                </li>
                @endcan

                @can('view-any-conversations', App\Models\Conversation::class)
                <li>
                    <a href="{{ route('conversations.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('conversations.*') || Request::routeIs('messages.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Messages</span>
                    </a>
                </li>
                @endcan

                <!-- Access Control Group -->
                <li class="pt-1.5 pb-1">
                    <span x-show="$store.sidebar.isExpanded" 
                          class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Access Control</span>
                    <hr x-show="!$store.sidebar.isExpanded" class="border-gray-100 mx-2">
                </li>

                @can('view-any-memberships', App\Models\Membership::class)
                <li>
                    <a href="{{ route('memberships.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('memberships.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354l1.108 3.41H16.5l-2.83 2.056 1.08 3.328L12 11.092l-2.75 2.056 1.08-3.328-2.83-2.056h3.892L12 4.354z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Members</span>
                    </a>
                </li>
                @endcan

                @can('view-any-roles', App\Models\Role::class)
                <li>
                    <a href="{{ route('roles.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('roles.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Roles</span>
                    </a>
                </li>
                @endcan

                <!-- System Group -->
                <li class="pt-3 pb-1">
                    <span x-show="$store.sidebar.isExpanded" 
                          class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">System</span>
                    <hr x-show="!$store.sidebar.isExpanded" class="border-gray-100 mx-2">
                </li>
                
                <li>
                    <a href="{{ route('companies.info', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('companies.info') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Info</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('trash.index', $company->slug) }}" 
                       class="menu-item {{ Request::routeIs('trash.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                       :class="{ 'xl:justify-center xl:px-2': !$store.sidebar.isExpanded }">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span x-show="$store.sidebar.isExpanded" class="truncate">Trash</span>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>
