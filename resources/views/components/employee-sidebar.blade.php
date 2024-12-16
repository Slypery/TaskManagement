<ul class="border-l-[1px] border-gray-300">
    <li>
        <a href="{{ route('employee.dashboard') }}" data-sidebar-active="{{ $pageName == 'Dashboard' ? 'true' : '' }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 data-[sidebar-active=true]:border-l-[2px] data-[sidebar-active=true]:border-purple-700 data-[sidebar-active=true]:font-semibold data-[sidebar-active=true]:text-purple-700 transition-all duration-75">
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('employee.task_list.index') }}" data-sidebar-active="{{ $pageName == 'Assignments' || $pageName == 'Assignment Detail' || $pageName == 'Forward Assignment' || $pageName == 'Edit Forwarded Assignment' || $pageName == 'Submission Detail' || $pageName == 'Make Submission' ? 'true' : '' }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 data-[sidebar-active=true]:border-l-[2px] data-[sidebar-active=true]:border-purple-700 data-[sidebar-active=true]:font-semibold data-[sidebar-active=true]:text-purple-700 transition-all duration-75">
            Assignments
        </a>
    </li>
    <li>
        <a href="{{ route('auth.logout') }}" class="flex px-4 py-1 -translate-x-[0.7px] border-yellow-900 hover:border-l-2 hover:bg-yellow-900/5 transition-all duration-75">
            Logout
        </a>
    </li>
</ul>
