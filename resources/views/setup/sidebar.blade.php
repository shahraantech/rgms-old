<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                @if (Auth::user()->role == 'admin')
                    <li class="submenu">
                        <a href="#"><i class="fa fa-user"></i> <span> House Keeping </span> <span
                                class="menu-arrow"></span></a>
                        <ul>

                            <li class="submenu">
                                <a href="#"> <span>Configuration</span> <span class="menu-arrow"></span></a>
                                <ul>

                                    <li class="submenu">
                                        <a href="#"> <span>Location Setup</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li><a href="{{ url('/company') }}">Company Info</a></li>
                                            <li><a href="{{ url('/company-branches') }}">Company Location</a></li>
                                            <li><a href="{{ url('/time') }}">Time Settings</a></li>

                                        </ul>
                                    </li>

                                    <li class="submenu">
                                        <a href="#"> <span>Roles Management</span> <span
                                                class="menu-arrow"></span></a>
                                        <ul>
                                            <li> <a href="{{ url('roles') }}"> <span>Roles</span></a> </li>
                                            <li> <a href="{{ url('role-permissions') }}"> <span>Role
                                                        Permissions</span></a> </li>
                                            <li> <a href="{{ url('users') }}"> <span>Users</span></a> </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="#"> <span> HRM</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ url('/departments') }}">Department</a></li>
                                    <li><a href="{{ url('/designation') }}">Designation</a></li>
                                    <li><a href="{{ url('/grades') }}">Grades</a></li>
                                    <li><a href="{{ url('/employees') }}">Add Employee</a></li>

                                    <li class="submenu">
                                        <a href="#"><span> Payroll </span> <span
                                                class="menu-arrow"></span></a>
                                        <ul style="display: none;">
                                            <li><a href="{{ url('salary') }}"> Salary Slips </a></li>
                                            <li><a href="{{ url('salary-sheet') }}"> Salary Sheet</a></li>
                                            <li><a href="{{ url('payroll-items') }}"> Payroll Items </a></li>
                                            <li><a href="{{ url('/expense') }}">Expenses List</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="#"><i class="la la-briefcase"></i> <span> Job Seeker </span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{ url('recruitment/existing') }}">CV Bank</a></li>
                                    <li><a href="{{ url('recruitment/new') }}">Jobs</a></li>
                                    <li><a href="{{ url('job-applicants') }}">Applicants</a></li>
                                    <li><a href="{{ url('interviews') }}">Interviews</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-files-o"></i> <span> OnBoarding </span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{ url('/policies') }}">Policies</a></li>
                                    <li><a href="{{ url('/offer-letter') }}">Offer Letter</a></li>
                                    <li><a href="{{ url('/exp-letter') }}">Experience Letter</a></li>
                                    <li><a href="{{ url('/clearance-letter') }}">Clearance Letter</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-external-link-square"></i> <span> Resignations </span>
                                    <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{ url('/resignations') }}">Resignations</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-external-link-square"></i> <span> Attendance </span>
                                    <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{ url('/emp-attendance') }}">Self Attendance</a></li>
                                    <li><a href="{{ url('/att-dashboard') }}">Time / Attendance</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-edit"></i> <span>Learning/Development</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{ url('/trainers') }}">Trainers</a></li>
                                    <li><a href="{{ url('/targets') }}">Targets</a></li>
                                    <li><a href="{{ url('/trainings') }}">Trainings</a></li>
                                    <li><a href="{{ url('/trainer-reviews') }}">Trainer Feedbacks</a></li>
                                    <li><a href="{{ url('/emp-reviews') }}">Employee Feedbacks</a></li>
                                </ul>
                            </li>
{{--                            --}}
{{--                            <li class="submenu">--}}
{{--                                <a href="#"><i class="la la-rocket"></i> <span>Company Assets</span> <span--}}
{{--                                        class="menu-arrow"></span></a>--}}
{{--                                <ul style="display: none;">--}}
{{--                                    <li><a href="{{ url('/assets') }}">Assets</a></li>--}}
{{--                                    <li><a href="{{ url('/create-specification') }}">Create Specification</a></li>--}}
{{--                                    <li><a href="{{ url('/add-specification') }}">Add Specification</a></li>--}}
{{--                                    <li><a href="{{ url('/asign-assets') }}">Assign Assets</a></li>--}}
{{--                                    --}}{{-- <li><a href="{{ url('/specification') }}">Specification</a></li> --}}
{{--                                </ul>--}}
{{--                            </li>--}}
                            <li class="submenu">
                                <a href="#"><i class="la la-edit"></i> <span>Leaves Management</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{ url('/leaves-settings') }}">Leaves Settings</a></li>
                                    <li><a href="{{ url('/leaves-request') }}">Leaves Request</a></li>
                                    <li><a href="{{ url('/off-week') }}">Off Week</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-ticket"></i> <span>Help Desk</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ url('/ticket') }}">Tickets</a></li>

                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-ticket"></i> <span>Reports</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">


                            <li class="submenu">
                                <a href="#"><i class="la la-edit"></i> <span>Attendance Report</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a href="{{ url('/daily-att-report') }}">Daily Report</a></li>
                                    <li><a href="{{ url('/monthly-att-report') }}">Monthly Report</a></li>



                                </ul>
                            </li>

                        </ul>
                    </li>
                @endif

                @if (Auth::user()->role == 'employee')
                    <li class="submenu">
                        <a href="#"><i class="fa fa-user"></i> <span> House Keeping </span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li> <a href="{{ url('leaves') }}"><i class="la la-info"></i> <span>Leaves</span></a>
                            </li>
                            <li> <a href="{{ url('resignation') }}"><i class="la la-external-link-square"></i>
                                    <span>Resignation Letter</span></a> </li>
                            <li> <a href="{{ url('help-desk') }}"><i class="la la-file-pdf-o"></i> <span>Help Desk
                                        Ticket</span></a> </li>
                            <li> <a href="{{ url('my-expenses') }}"><i class="la la-user-secret"></i>
                                    <span>Expenses</span></a> </li>
                            <li> <a href="{{ url('call-recording') }}"><i class="la la-user-secret"></i> <span>Call
                                        Recordings</span></a> </li>

                            <li class="submenu">
                                <a href="#"><i class="la la-edit"></i> <span>Learning/Development</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a href="{{ url('/emp-trainings') }}">My Trainings</a></li>
                                    <li><a href="{{ url('/trainer-feedback') }}">My Feedbacks</a></li>
                                    <li><a href="{{ url('/write-feedback') }}">Write Feedbacks</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-rocket"></i> <span>Projects Management</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    @if (App\Models\User::join('leads', 'leads.leader_id', '=', 'users.account_id')->where('users.account_id', Auth::user()->account_id)->first())
                                        <li><a href="{{ url('/my-projects') }}">My Projects</a></li>
                                    @endif
                                    <li><a href="{{ url('/my-tasks') }}">My Project Tasks</a></li>
                                    <li><a href="{{ url('my-daily-task') }}">My Daily Tasks</a></li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="#"><i class="la la-files-o"></i> <span>Attendance</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{ url('/emp-attendance') }}">Attendance</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @php
                        $mod = App\Models\Module::get();
                    @endphp
                    @foreach ($mod as $mod)
                        <li class="submenu">
                            @php
                                $allow = 0;
                                $chekSm = App\Models\SubModule::where('module_id', $mod->id)->get();
                                foreach ($chekSm as $chekSm) {
                                    $chekPerm = App\Models\RoleHasPermission::where('sub_module_id', $chekSm->id)->get();
                                    foreach ($chekPerm as $chek) {
                                        if ($chek->role_id == Auth::user()->role_id && $chek->is_allow == 1) {
                                            $allow = 1;
                                        }
                                    }
                                }
                            @endphp
                            @if ($chekSm && $allow == 1)
                                <a href="#"><i class="la la-user"></i> <span>{{ $mod->module }}</span> <span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    @php
                                        $m = App\Models\SubModule::where('module_id', $mod->id)->get();
                                    @endphp
                                    @foreach ($m as $sm)
                                        @php
                                            $chekPerm = App\Models\RoleHasPermission::where('sub_module_id', $sm->id)->get();
                                        @endphp
                                        @foreach ($chekPerm as $chekPerm)
                                            @if ($chekPerm->role_id == Auth::user()->role_id && $chekPerm->is_allow == 1)
                                                <li> <a
                                                        href="{{ $sm->route }}"><span>{{ $sm->title }}</span></a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @endif
                @if (Auth::user()->role == 'trainer')
                    <li> <a href="{{ url('/') }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li> <a href="{{ url('trainee-list') }}"><i class="la la-child"></i> <span>My Trainee</span></a>
                    </li>
                    <li> <a href="{{ url('trainee-feedback') }}"><i class="la la-commenting"></i> <span>Trainee
                                Feedbacks</span></a> </li>
                @endif

                @if (Auth::user()->role == 'accounts')
                    <li> <a href="{{ url('/') }}"> <span>Dashboard</span></a> </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span> Accounts </span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li class="submenu">
                                <a href="#"> <span> Chart Of Accounts </span> <span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li> <a href="{{ url('coa') }}"> <span>COA Lists</span></a> </li>
                                    <li> <a href="{{ url('coa-mapping') }}"> <span>COA Mapping</span></a> </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"> <span>Cash A/C </span> <span
                                        class="menu-arrow"></span></a>
                                <ul>

                                    <li> <a href="{{ url('accounts') }}"> <span>A/C Trial Balance</span></a> </li>
                                    <li> <a href="{{ url('ledgers') }}"> <span>Ledgers</span></a> </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><span>Bank A/C</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ url('/bank') }}">Bank Trial Balance</a></li>

                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"> <span>Transactions</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li> <a href="{{ url('payments') }}"> <span>Payments Voucher</span></a> </li>
                                    <li> <a href="{{ url('receipt') }}"> <span>Receipts Voucher</span></a> </li>
                                    <li> <a href="{{ url('jv') }}"> <span>Journal Voucher</span></a> </li>


                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><span>Manage Expense</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ url('/manage-expense') }}">Add Expense</a></li>
                                    <li><a href="{{ url('/expense-summary') }}">Expense Summary</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-user-circle"></i> <span>Peoples</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li> <a href="{{ url('vendors') }}"> <span>Add Vendor</span></a> </li>
                            <li> <a href="{{ url('clients') }}"> <span>Add Customer </span></a> </li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-product-hunt"></i> <span>Item Management</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ url('/category') }}">Add Category</a></li>
                            <li><a href="{{ url('/products') }}">Add Items</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span> Purchase </span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ url('/purchase') }}">Add Purchase</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span> Sales </span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ url('sale') }}">Dealers Sale</a></li>
                            <li><a href="{{ url('bulk-sale') }}">Bulk Sales</a></li>
                            <li><a href="{{ url('regular-sale') }}">Regular Sale</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span>Attendance</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ url('/emp-attendance') }}">Attendance</a></li>
                        </ul>
                    </li>
                    {{--  --}}
                    {{-- <li class="submenu"> --}}
                    {{-- <a href="#"><i class="la la-building"></i> <span>Builders</span> <span class="menu-arrow"></span></a> --}}
                    {{-- <ul> --}}
                    {{-- <li><a href="{{url('/buildings')}}">Manage Buildings</a></li> --}}
                    {{-- <li><a href="{{url('/buildings-cost')}}">Manage Buildings Cost</a></li> --}}
                    {{-- </ul> --}}
                    {{-- </li> --}}
                    <li class="submenu">
                        <a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ url('/stock') }}">Inventory Reports</a></li>
                            <li><a href="{{ url('/sale-report') }}">Sale Reports </a></li>
                            <li><a href="{{ url('/purchase-list') }}">Purchase Reports </a></li>
                            <li><a href="{{url('/monthly-profit-loss-report')}}">Monthly Profit Report </a></li>
                            <li><a href="{{url('commission-report')}}">Commission Report</a></li>
                            <li><a href="{{ url('/loss-profit-report') }}">Loss & Profit Reports </a></li>
                            <li><a href="{{ url('/balance-sheet/1/1') }}">Balance Sheet</a></li>


                        </ul>
                    </li>


                        <li class="submenu">
                            <a href="#"><i class="la la-user"></i> <span>House Keeping</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ url('/society') }}">Projects </a></li>
                                <li> <a href="{{ url('role-permissions') }}"> <span>Role
                                                        Permissions</span></a> </li>
                            </ul>
                        </li>
                @endif
                @if (Auth::user()->role == 'call-center')

                    <li> <a href="{{ url('/') }}"> <span>Dashboard</span></a> </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span> Social Media </span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li class="submenu">
                                <a href="#"> <span>Posts</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li> <a href="{{ url('posts') }}"> <span>Posts</span></a> </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"> <span>Campaigns</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li> <a href="#"> <span>Social Media Campaign</span></a> </li>
                                    <li> <a href="sms"> <span>SMS Campaign</span></a> </li>
                                    <li> <a href="email"> <span>Email Campaign</span></a> </li>
                                    <li> <a href="{{ url('email-attachment') }}"> <span>Random Email Campaign</span></a> </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"> <span>Response</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li> <a href="#"> <span>Posts Response</span></a> </li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="#"><i class="la la-user"></i> <span>Chat</span> <span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li class="submenu">
                                        <a href="#"> <span>Chat</span> <span class="menu-arrow"></span></a>
                                        <ul>
                                            <li> <a href="{{ url('chat') }}"> <span>Chat</span></a> </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span>Projects & Targets</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li class="submenu">
                                <a href="#"> <span>Targets Management</span> <span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ url('/targets') }}">Create Targets</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"> <span>Team Management</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{ url('/team') }}">Team Management</a></li>
                                </ul>
                            </li>
                            {{--  --}}
                            {{-- <li class="submenu"> --}}
                            {{-- <a href="#"><span>Project Management</span> <span class="menu-arrow"></span></a> --}}
                            {{-- <ul style="display: none;"> --}}
                            {{-- <li><a href="{{url('/projects')}}">Projects</a></li> --}}
                            {{-- <li><a href="{{url('/tasks')}}">Tasks Management</a></li> --}}
                            {{-- </ul> --}}
                            {{-- </li> --}}
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span>Leads Management</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            {{-- <li> <a href="{{url('leads')}}"> <span>Create Leads</span></a>  </li> --}}
                            <li> <a href="{{ url('leads-list') }}"> <span>Leads List</span></a> </li>
                            <li> <a href="{{ url('my-leads') }}"> <span>My Leads</span></a> </li>
                            <li> <a href="{{ url('allocated-leads') }}"> <span>CSR Leads</span></a> </li>
                            <li> <a href="{{ url('manager-allocated-leads') }}"> <span>Manager Leads</span></a> </li>
                            <li> <a href="{{ url('open-leads') }}"> <span>Open Leads</span></a> </li>
                            {{-- <li> <a href="{{url('manager-leads')}}"> <span>Manager Leads</span></a>  </li> --}}
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span>Meetings & Sales</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li> <a href="{{ url('walkin-customer') }}"> <span>Customer Form</span></a> </li>
                            <li> <a href="{{ url('meetings') }}"> <span>Meetings List</span></a> </li>
                            <li> <a href="{{ url('my-meetings') }}"> <span>My Meetings</span></a> </li>
                            <li> <a href="{{ url('sales-list') }}"> <span>Sales List</span></a> </li>
                            <li> <a href="{{ url('my-sales') }}"> <span>My Sales</span></a> </li>

                        </ul>
                    </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-user"></i> <span>Customer Survey</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li> <a href="{{ url('create-survey') }}"> <span>Create Survey</span></a> </li>


                            </ul>
                        </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span>Attendance</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ url('/emp-attendance') }}">Attendance</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-edit"></i> <span>Reports</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a href="{{ url('leads-response') }}">Leads Response Report</a></li>
                            <li><a href="{{ url('csr-no-of-leads') }}">CSR NO Of Leads</a></li>
                            <li><a href="{{ url('manager-no-of-leads') }}">Manager NO Of Leads</a></li>
{{--                            <li><a href="{{ url('leads-analysis') }}">Leads Analysis</a></li>--}}
                            <li><a href="{{ url('sales-report') }}">Sales Report</a></li>
                            <li><a href="{{ url('dead-lead-report') }}">Dead Lead Report</a></li>
                            <li><a href="{{ url('calls-qa-report') }}">Calls QA Report</a></li>
                            <li><a href="{{ url('emp-leads-analysis') }}">Emp Leads Analysis</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-home"></i><span>Property Management</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ url('/property-type') }}">Property Type</a></li>
                            <li><a href="{{ url('/create-property') }}">Create Property</a></li>
                            <li><a href="{{ url('/property-variation') }}">Property Variation</a></li>
                            <li><a href="{{ url('/property-projects') }}">Property Projects</a></li>
                            <li><a href="{{ url('/get-seller') }}">Seller</a></li>
                            <li><a href="{{ url('/get-buyer') }}">Buyer</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-user"></i> <span>House Keeping</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ url('/leads-settings') }}">Leads Settings</a></li>
                            <li><a href="{{ url('/leads-source-settings') }}">Leads Source Settings</a></li>

                            <li class="submenu">
                                <a href="#"> <span>General Settings</span> <span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li> <a href="{{ url('temp') }}"> <span>Temperatures</span></a> </li>
                                    <li> <a href="{{ url('city') }}"> <span>Cities</span></a> </li>
                                    <li> <a href="{{ url('platforms') }}"> <span>Social Platforms</span></a> </li>
                                    <li><a href="{{ url('/society') }}">Societies </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->role == 'super-admin')
                    @include('setup.super-admin-sidebar')
                @endif

                    <li class="submenu">
                        <a href="#"><i class="la la-calendar"></i> <span>Calender</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li> <a href="{{ url('calender') }}"> <span>Daily Planner</span></a> </li>
                        </ul>
                    </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
