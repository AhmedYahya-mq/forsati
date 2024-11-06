@extends("admin.layout.layout")

@section('header')
    <link href="{{ asset('admin/css/form.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/css/contentManager/contentManager.css') }}" rel="stylesheet" media="all">



      <!-- تصميم CSS مخصص -->
      <style>
        /* From Uiverse.io by uxRakhal */
        /* The switch - the box around the slider */

        i.fas.icon-show-pass {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(50%);
            cursor: pointer;
        }

        .switch {
            font-size: 17px;
            position: relative;
            display: inline-block;
            width: 2.5em;
            height: 1em;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: white;
            border-radius: 50px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 0.7em;
            width: 0.7em;
            right: 0.2em;
            bottom: 0.15em;
            transform: translateX(150%);
            background-color: #59d102;
            border-radius: inherit;
            transition: all 0.4s cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        .slider:after {
            position: absolute;
            content: "";
            height: 0.7em;
            width: 0.7em;
            left: 0.2em;
            bottom: 0.15em;
            background-color: #ff0000;
            border-radius: inherit;
            transition: all 0.4s cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        .switch input:focus+.slider {
            box-shadow: 0 0 1px #59d102;
        }

        .switch input:checked+.slider:before {
            transform: translateY(0);
        }

        .switch input:checked+.slider::after {
            transform: translateX(-150%);
        }

        @media (min-width: 640px) {
            .sm\:justify-between {
                justify-content: center;
            }
        }
    </style>

    <!-- Title Page-->
    <title>أدارة المستخدمين</title>

@endsection


@section("form")
    <div class="container-form">
        <div class="container">
        <div class="row justify-content-between">
            <!-- عنوان النموذج وزر الإغلاق -->
            <div class="mb-3">
            <h2 ><span id="title-form">إضافة</span> مستخدم</h2>
            </div>
            <div class="mb-3" id="close-form" title="إغلاق">
                <span class="btn"><i class="fas fa-times"></i></span>
            </div>
        </div>

        <!-- نموذج الإدخال -->
        <form id="form">
            <div class="row">
                <div class="col-12 mb-3 text-right">
                    <label for="user-name" class="form-label"> الأسم:</label>
                    <input type="text" class="form-control" name="name" id="user-name" placeholder="أدخل الأسم...">
                </div>
                <!-- حقل إدخال عنوان المنحة -->
                <div class="col-12 mb-3 text-right">
                    <label for="user-email" class="form-label"> البريد الكتروني:</label>
                    <input type="email" class="form-control" name="email" id="user-email" placeholder="أدخل  البريد الكتروني...">
                </div>
                <!-- قائمة منسدلة متعددة لاختيار التخصصات -->
                <div class="col-12 mb-3 text-right">
                    <label for="permissions-select" class="form-label">اختر التخصص:</label>
                    <select id="permissions-select" class="form-control" name="permissions[]" multiple="multiple" style="width: 100%;">

                        @foreach ($permissions as $permission )
                        <option value="{{ $permission->id }}">{{ $permission->text }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3 text-right">
                    <label for="password" class="form-label">كلمة المرور:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="أدخل كلمة المرور ...">
                    <i class="fas fa-eye-slash icon-show-pass" data-target="#password"></i>
                </div>

                <div class="col-12 mb-3 text-right">
                    <label for="confirmPassword" class="form-label">تأكيد كلمة المرور:</label>
                    <input type="password" name="password_confirmation" class="form-control" id="confirmPassword"
                        placeholder="أدخل تأكيد كلمة المرور ...">
                    <i class="fas fa-eye-slash icon-show-pass" data-target="#confirmPassword"></i>

                </div>

            </div>
            <!-- زر الإرسال -->
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
        </div>
    </div>
@endsection


@section("content")
    <section>
        <div class="main-content">
        <div class="section__content section__content--p30 mt-5 pt-5">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">بيانات المستخدمين</h3>
                        <div class="row justify-content-between px-3 align-items-center mb-2">
                            <div class="col-md-0 mt-3">
                                <div class="search-container">
                                    <div class="input-container">
                                        <input id="search" type="text" name="search" value="{{ $search }}" class="input"
                                            placeholder="البحث عن تخصص...">
                                        <svg id="btn-search" xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"
                                            class="icon">
                                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                            <g stroke-linejoin="round" stroke-linecap="round"
                                                id="SVGRepo_tracerCarrier"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <rect fill="white" height="24" width="24"></rect>
                                                <path fill=""
                                                    d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM9 11.5C9 10.1193 10.1193 9 11.5 9C12.8807 9 14 10.1193 14 11.5C14 12.8807 12.8807 14 11.5 14C10.1193 14 9 12.8807 9 11.5ZM11.5 7C9.01472 7 7 9.01472 7 11.5C7 13.9853 9.01472 16 11.5 16C12.3805 16 13.202 15.7471 13.8957 15.31L15.2929 16.7071C15.6834 17.0976 16.3166 17.0976 16.7071 16.7071C17.0976 16.3166 17.0976 15.6834 16.7071 15.2929L15.31 13.8957C15.7471 13.202 16 12.3805 16 11.5C16 9.01472 13.9853 7 11.5 7Z"
                                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-0 mt-3">
                                <button class="icon-btn add-btn add-btn-js">
                                    <div class="add-icon"></div>
                                    <div class="btn-txt" title="اضافة منحه">أضافة مستخدم</div>
                                </button>
                            </div>
                        </div>
                        <!-- USER DATA-->
                        <div class="user-data m-b-30">
                            <h3 class="title-3 m-b-30">
                                <i class="zmdi zmdi-account-calendar"></i>بيانات المستخدمين
                            </h3>
                            <div class="filters m-b-45">
                                <div class="rs-select2--dark rs-select2--md m-r-10 rs-select2--border">
                                    <select class="js-select2"  name="property">
                                        <option {{ $user_type === "__ALL__"? 'selected="selected"':"" }}  value="__ALL__">كل المستخدمين</option>
                                        <option {{ $user_type === "manage_all"? 'selected="selected"':"" }} value="manage_all">مشرفين</option>
                                        <option {{ $user_type === "manage_users,manage_specializations,manage_scholarships,manage_content,manage_blogs"? 'selected="selected"':"" }} value="manage_users,manage_specializations,manage_scholarships,manage_content,manage_blogs">مستخدمين</option>
                                        <option {{ $user_type === "normal_user"? 'selected="selected"':"" }} value="normal_user">أعضاء</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                            <div class="table-responsive table-data">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>الرقم</td>
                                            <td>الأسم</td>
                                            <td>نوع الحساب</td>
                                            <td>صلاحيات</td>
                                            <td>نشط</td>
                                            <td>حالة البريد الكتروني</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $itritor=1;
                                        @endphp
                                        @forelse ($users as $_user)
                                        <tr id="user-{{$_user->id}}">
                                            <td>
                                                <span>{{ $itritor++ }}</span>
                                            </td>
                                            <td>
                                                <div class="table-data__info" id="info-user">
                                                    <h6>{{ $_user->name }}</h6>
                                                    <span>
                                                        <a href="mailto:{{ $_user->email }}">{{ $_user->email }}</a>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if (count($_user->permissions) == 1 && $_user->permissions[0]->id == 'manage_all')
                                                    <span class="role admin">مشرف</span>
                                                @elseif (count($_user->permissions) > 1 && $_user->permissions[0]->id != 'normal_user' && $_user->permissions[0]->id != 'manage_all')
                                                    <span class="role user">مستخدم</span>
                                                @else
                                                    <span class="role member">عضو</span>
                                                @endif
                                            </td>
                                            <td id="policies">
                                                <div class="rs-select2--trans rs-select2--sm">
                                                    @foreach ($_user->permissions as $permission)
                                                    <span class="role user mt-1" style="background-color: goldenrod;" data-policy='{{$permission->id}}'>{{$permission->text}}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                <div class="rs-select2--trans rs-select2--sm">
                                                    <label class="switch">
                                                        <input type="checkbox" name="state"  data-id="{{ $_user->id }}" {{ $_user->status?"checked":"" }}/>
                                                        <span class="slider"></span>
                                                    </label>

                                                </div>
                                            </td>

                                            <td>
                                                <div class="rs-select2--trans rs-select2--sm">
                                                    <label class="switch">
                                                        <input type="checkbox" name="email_verified_at" data-id="{{ $_user->id }}"  {{ $_user->email_verified_at != null ? "checked":"" }} />
                                                        <span class="slider"></span>
                                                    </label>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="item" data-toggle="tooltip" data-id="{{ $_user->id }}" title="تعديل"
                                                        data-placement="top" title=""
                                                        data-original-title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-id="{{ $_user->id }}" title="حذف"
                                                        data-placement="top" title=""
                                                        data-original-title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7">
                                                <h2 class="text-center">لا يوجد مستخدمين</h2>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="user-data__footer m-3">
                                    <div>
                                        <span id="show-pages">
                                            {{ __('pagination.showing') }} {{ $users->firstItem() ?? 0 }}
                                            {{ __('pagination.to') }} {{ $users->lastItem() ?? 0 }}
                                            {{ __('pagination.of') }} {{ $users->total() }}
                                            {{ __('pagination.results') }}
                                        </span>
                                    </div>
                                    <div id="js-pagition">
                                        {{ $users->onEachSide(-1)->links() }}
                                    </div>
                            </div>
                        <!-- END USER DATA-->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection


@section("scripts")
    <script src="{{ asset('admin/js/usersManager/userManager.js') }}"></script>
@endsection

@section("user","active")
