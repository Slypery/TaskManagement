<ul class="border-l-[1px] border-gray-300">
    <li>
        <a href="{{ route('manager.dashboard') }}" data-sidebar-active="{{ $pageName == 'Dashboard' ? 'true' : '' }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 data-[sidebar-active=true]:border-l-[2px] data-[sidebar-active=true]:border-purple-700 data-[sidebar-active=true]:font-semibold data-[sidebar-active=true]:text-purple-700 transition-all duration-75">
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('manager.task_list.index') }}" data-sidebar-active="{{ $pageName == 'Task List' || $pageName == 'Task Detail' ? 'true' : '' }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 data-[sidebar-active=true]:border-l-[2px] data-[sidebar-active=true]:border-purple-700 data-[sidebar-active=true]:font-semibold data-[sidebar-active=true]:text-purple-700 transition-all duration-75">
            Task List
        </a>
    </li>
    <li>
        <a href="{{ route('manager.task_list.index') }}" data-sidebar-active="{{ $pageName == 'Return Task' ? 'true' : '' }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 data-[sidebar-active=true]:border-l-[2px] data-[sidebar-active=true]:border-purple-700 data-[sidebar-active=true]:font-semibold data-[sidebar-active=true]:text-purple-700 transition-all duration-75">
            Return Task
        </a>
    </li>
    <li>
        <a href="{{ route('manager.task_list.index') }}" data-sidebar-active="{{ $pageName == 'Employee Task List' ? 'true' : '' }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 data-[sidebar-active=true]:border-l-[2px] data-[sidebar-active=true]:border-purple-700 data-[sidebar-active=true]:font-semibold data-[sidebar-active=true]:text-purple-700 transition-all duration-75">
            Employee Task List
        </a>
    </li>
    <li>
        <a href="{{ route('manager.task_list.index') }}" data-sidebar-active="{{ $pageName == 'Employee Task Return' ? 'true' : '' }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 data-[sidebar-active=true]:border-l-[2px] data-[sidebar-active=true]:border-purple-700 data-[sidebar-active=true]:font-semibold data-[sidebar-active=true]:text-purple-700 transition-all duration-75">
            Employee Task Return
        </a>
    </li>
    <li>
        <a href="{{ route('auth.logout') }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 transition-all duration-75">
            Logout
        </a>
    </li>
</ul>
