
<li class="submenu">
    <a href="#"><i class="fa fa-group"></i> <span>HR</span> <span class="menu-arrow"></span></a>
    <ul>

        <li class="submenu">
            <a href="#"> <span>Configuration</span> <span class="menu-arrow"></span></a>
            <ul>

                <li class="submenu">
                    <a href="#"> <span>Location Setup</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('/company')}}">Company Info</a></li>
                        <li><a href="{{url('/company-branches')}}">Company Location</a></li>
                        <li><a href="{{url('/time')}}">Time Settings</a></li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"> <span>General Settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li> <a href="{{url('temp')}}"> <span>Temperature</span></a>  </li>
                        <li> <a href="{{url('city')}}"> <span>Cities</span></a>  </li>
                        <li> <a href="{{url('platforms')}}"> <span>Plat Forms</span></a>  </li>
                        <li><a href="{{url('/society')}}">Societies </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"> <span>Roles Management</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li> <a href="{{url('roles')}}"> <span>Roles</span></a>  </li>
                        <li> <a href="{{url('role-permissions')}}"> <span>Role Permissions</span></a>  </li>
                        <li> <a href="{{url('users')}}"> <span>Users</span></a>  </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"> <span> HRM</span> <span class="menu-arrow"></span></a>
            <ul>
                <li><a href="{{url('/departments')}}">Department/Designation</a></li>
                <li><a href="{{url('/grades')}}">Grades</a></li>
                <li><a href="{{url('/employees')}}">Add Employee</a></li>

                <li class="submenu">
                    <a href="#"><i class="la la-money"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a  href="{{url('salary')}}"> Salary Slips </a></li>
                        <li><a  href="{{url('salary-sheet')}}"> Salary Sheet</a></li>
                        <li><a href="{{url('payroll-items')}}"> Payroll Items </a></li>
                        <li><a href="{{url('/expense')}}">Expenses List</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="fa fa-user"></i> <span> Job Seeker </span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('recruitment/existing')}}">CV Bank</a></li>
                <li><a href="{{url('recruitment/new')}}">Jobs</a></li>
                <li><a href="{{url('job-applicants')}}">Applicants</a></li>
                <li><a href="{{url('interviews')}}">Interviews</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-files-o"></i> <span> Onboarding </span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/policies')}}">Policies</a></li>
                <li><a href="{{url('/offer-letter')}}">Offer Letter</a></li>
                <li><a href="{{url('/exp-letter')}}">Experience Letter</a></li>
                <li><a href="{{url('/clearance-letter')}}">Clearance Letter</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-external-link-square"></i> <span> Resignations </span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/resignations')}}">Resignations</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-external-link-square"></i> <span> Attendance  </span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/emp-attendance')}}">Self Attendance</a></li>
                <li><a href="{{url('/att-dashboard')}}">Time / Attendance</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-edit"></i> <span>Learning/Development</span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/trainers')}}">Trainers</a></li>
                <li><a href="{{url('/targets')}}">Targets</a></li>
                <li><a href="{{url('/trainings')}}">Trainings</a></li>
                <li><a href="{{url('/trainer-reviews')}}">Trainer Feedbacks</a></li>
                <li><a href="{{url('/emp-reviews')}}">Employee Feedbacks</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-rocket"></i> <span>Project Management</span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/projects')}}">Projects</a></li>
                <li><a href="{{url('/tasks')}}">Tasks Management</a></li>
                <li><a href="{{url('/team')}}">Team Management</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-edit"></i> <span>Leaves Management</span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/leaves-settings')}}">Leaves Settings</a></li>
                <li><a href="{{url('/leaves-request')}}">Leaves Request</a></li>
                <li><a href="{{url('/off-week')}}">Off Week</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-ticket"></i> <span>Help Desk</span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/ticket')}}">Tickets</a></li>

            </ul>
        </li>

        <li class="submenu">
            <a href="#"><i class="la la-rocket"></i> <span>Quotation</span> <span
                    class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{ url('/quotation') }}">Quotation</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"> <span>Reports</span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">


                <li class="submenu">
                    <a href="#"> <span>Attendance Report</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">

                        <li><a href="{{url('/daily-att-report')}}">Daily Att Report</a></li>
                        <li><a href="{{url('/monthly-att-report')}}">Monthly Att Report</a></li>
                        <

                    </ul>
                </li>
                <li><a href="{{ url('/checkout-report') }}">Emp Time Cost Report</a></li>
                <li><a href="{{ url('/dept-wise-salary-report') }}">Dept Salary Report</a></li>
                <li><a href="{{ url('/login-history') }}">Login History</a></li>



            </ul>
        </li>
    </ul>
</li>
<li class="submenu">
    <a href="#"><i class="fas fa-phone"></i> <span>Call Center</span> <span class="menu-arrow"></span></a>
    <ul>
        <li> <a href="{{url('/')}}"> <span>Dashboard</span></a>  </li>

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
    </ul>
</li>
<li class="submenu">
    <a href="#"><i class="fas fa-wallet"></i> <span>Accounts</span> <span class="menu-arrow"></span></a>
    <ul>
        <li> <a href="{{url('accounts-dashboard')}}"> <span>Dashboard</span></a>  </li>
        <li class="submenu">
            <a href="#"><i class="la la-user"></i> <span> Accounts </span> <span class="menu-arrow"></span></a>
            <ul>
                <li class="submenu">
                    <a href="#"> <span> Company Accounts </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li> <a href="{{url('coa')}}"> <span>COA</span></a>  </li>
                        <li> <a href="{{url('accounts')}}"> <span>Trial Balance</span></a>  </li>
                        <li> <a href="{{url('ledgers')}}"> <span>Ledgers</span></a>  </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><span> Banks </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('/bank')}}">Add Bank Branches</a></li>
                        {{--                                    <li><a href="{{url('/manage-bank')}}">Bank Branches List</a></li>--}}
                        <li><a href="{{url('/bank-transaction')}}">Bank Transaction</a></li>
                        <li><a href="{{url('/bank-summary')}}">Bank Summary</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"> <span>Transactions</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li> <a href="{{url('payments')}}"> <span>Payments Voucher</span></a>  </li>
                        <li> <a href="{{url('receipt')}}"> <span>Receipts Voucher</span></a>  </li>
                        <li> <a href="{{url('jv')}}"> <span>Journal Voucher</span></a>  </li>
                        {{--                                    <li><a href="{{url('/deposit')}}">Deposit</a></li>--}}
                        <li><a href="{{url('/transfer')}}">Transfer</a></li>
                        <li><a href="{{url('/balance-sheet')}}">Balance Sheet</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><span>Manage Expense</span> <span class="menu-arrow"></span></a>
                    <ul>
                        {{--
                        <li><a href="{{url('/expense-head')}}">Expense Head</a></li>
                        --}}
                        <li><a href="{{url('/manage-expense')}}">Add Expense</a></li>
                        <li><a href="{{url('/expense-summary')}}">Expense Summary</a></li>
                    </ul>
                </li>

            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-user-circle"></i> <span>Peoples</span> <span class="menu-arrow"></span></a>
            <ul>
                <li> <a href="{{url('vendors')}}"> <span>Add Vendor</span></a>  </li>
                <li> <a href="{{url('clients')}}"> <span>Add Customer </span></a>  </li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-product-hunt"></i> <span>Item Management</span> <span class="menu-arrow"></span></a>
            <ul>
                <li><a href="{{url('/category')}}">Add Category</a></li>
                <li><a href="{{url('/products')}}">Add Items</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-files-o"></i> <span> Purchase </span> <span class="menu-arrow"></span></a>
            <ul>
                <li><a href="{{url('/purchase')}}">Add Purchase</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-files-o"></i> <span> Sales </span> <span class="menu-arrow"></span></a>
            <ul>
                <li><a href="{{url('/sale')}}">Add Sale</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-files-o"></i> <span>Attendance</span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{url('/emp-attendance')}}">Attendance</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
            <ul>
                <li><a href="{{url('/stock')}}">Inventory Reports</a></li>
                <li><a href="{{url('/stock-raw-material')}}">Stock  (Raw Material) Reports</a></li>
                <li><a href="{{url('/sale-report')}}">Sale Reports </a></li>
                <li><a href="{{url('/purchase-report')}}">Purchase Reports </a></li>
                <li><a href="{{url('/loss-profit-report')}}">Loss & Profit Reports </a></li>
                <li><a href="{{url('/daily-summary')}}">Daily Summary Reports </a></li>
                <li><a href="{{url('/today-summary')}}">Today Summary Reports </a></li>
                <li> <a href="{{url('chart-accounts')}}"> <span>COA Reports</span></a>  </li>
            </ul>
        </li>
    </ul>
</li>

